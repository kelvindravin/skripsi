import serial
import time
import mysql.connector
from datetime import datetime
import threading
import os
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# Global Variables

appRunning = True
sensingStatus = False

#serial details
serial = serial.Serial(
     port='/dev/ttyUSB0',
     baudrate=9600,
     parity=serial.PARITY_NONE,
     stopbits=serial.STOPBITS_ONE,
     bytesize=serial.EIGHTBITS,
     timeout=3
 )

#database details
mydb = mysql.connector.connect(
  host="localhost",
  user="pi",
  password="admin",
  database="pemantauanrumah"
)

# ====update data to database====
def updateUserNotifikasi(email,notifikasi):
    mycursor = mydb.cursor()

    sql = """UPDATE user SET notifikasi = %s where email = %s"""
    val = (notifikasi, email)

    mycursor.execute(sql,val)

    mydb.commit()
    print("Account Notification Updated!")
    
def updateUserPassword(email,password):
    mycursor = mydb.cursor()

    sql = """UPDATE user SET password = %s where email = %s"""
    val = (password, email)

    mycursor.execute(sql,val)

    mydb.commit()
    print("Account Password Updated!")
    
def updateSensorDataToDB(idEdit , inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode):
    cursor = mydb.cursor()

    query = "UPDATE sensor SET inisialSensor = %s, identitasSensor = %s, satuan = %s, ambangBatas = %s, warning = %s, idNode = %s WHERE idSatuan = %s"
    val = (inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode, idEdit)

    cursor.execute(query, val)

    mydb.commit()
    
def updateNodeSensorDataToDB(idEdit ,namaNode, lokasi):
    cursor = mydb.cursor()

    query = "UPDATE nodeSensor SET namaNode = %s, lokasiNode = %s WHERE idNode = %s"
    val = (namaNode, lokasi, idEdit)

    cursor.execute(query, val)

    mydb.commit()
# ====end of update data to database====

# ====insert data to database====
def insertUserToDB(email,password):
    cursor = mydb.cursor()

    query = "INSERT INTO user (email,password) VALUES (%s,%s)"
    val = (email,password)

    cursor.execute(query, val)

    mydb.commit()
    print("Account Registered!")

def insertDataToDB(idSensor, nilaiPengukuran):
    cursor = mydb.cursor()

    query = "INSERT INTO pengukuran (idSensor, waktu, nilaiPengukuran) VALUES (%s,%s,%s)"
    val = (idSensor, datetime.now(), nilaiPengukuran)

    cursor.execute(query, val)

    mydb.commit()
    
def insertSensorDataToDB(inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode):
    cursor = mydb.cursor()

    query = "INSERT INTO sensor (inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode) VALUES (%s,%s,%s,%s,%s,%s)"
    val = (inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode)

    cursor.execute(query, val)

    mydb.commit()
    
def insertNodeSensorDataToDB(namaNode, lokasi):
    cursor = mydb.cursor()

    query = "INSERT INTO nodeSensor (namaNode, lokasiNode) VALUES (%s,%s)"
    val = (namaNode, lokasi)

    cursor.execute(query, val)

    mydb.commit()
# ====end of insert data====

# ====additional method====
def translateStatusIntoWords(status):
    if status == True:
        return "Online"
    else:
        return "Offline"

def getAllEmail():
    cursor = mydb.cursor(buffered=True)

    cursor.execute("""SELECT email,notifikasi FROM user""")
    result = cursor.fetchall()
    
    return result
# ====end of additional method====

# opening thread and start sensing until it's turned off
class sensorSense():
    def __init__(self, interval = 2.5):
        self.interval = interval

        sensingThread = threading.Thread(target=self.run, args=())
        sensingThread.daemon = True

        sensingThread.start()
        
    def sendWarningEmail(self,lpg,smoke,co,batas_lpg,batas_smoke,batas_co):
        sender_address = '2017730022.monitoring@gmail.com'
        sender_pass = 'homemonitoring'
        
        cursor = mydb.cursor(buffered=True)#the buffer will prevent unread result found from fetchone()
        cursor.execute("""SELECT email FROM user WHERE notifikasi = 1""")
        result = cursor.fetchone()
        
        mail_content = '''Telah dideteksi keberadaan tanda bahaya dalam area pemeriksaan, dengan detail sebagai berikut :\n\n'''
        warning_content_lpg = '''Kadar LPG dalam udara : ''' + str(lpg) + ''' PPM (dengan batas sebesar ''' + str(batas_lpg) + '''PPM) \n'''
        warning_content_co = '''Kadar CO dalam udara : ''' + str(co) + ''' PPM (dengan batas sebesar ''' + str(batas_co) + '''PPM) \n'''
        warning_content_smoke = '''Kadar Asap dalam udara : ''' + str(smoke) + ''' PPM (dengan batas sebesar ''' + str(batas_smoke) + '''PPM) \n\n'''
        mail_end_content = '''Berhati-hatilah, dan harap periksa kondisi tersebut\nHome Monitoring - 2017730022'''
        content = mail_content + warning_content_lpg + warning_content_co + warning_content_smoke + mail_end_content
        
        for receiver_address in result:
            message = MIMEMultipart()
            message['From'] = "Home Monitoring System"
            message['To'] = receiver_address
            message['Subject'] = 'Home Monitoring Warning Notification'
            message.attach(MIMEText(content, 'plain'))
            
            #SMTP Session
            session = smtplib.SMTP('smtp.gmail.com', 587)
            session.starttls()
            session.login(sender_address, sender_pass)
            text = message.as_string()
            session.sendmail(sender_address, receiver_address, text)
            session.quit()

    def run(self):
        #violation counter of LPG, CO and Smoke
        lpg_violation = 0
        smoke_violation = 0
        co_violation = 0
        
        lpg_violation_value = ""
        smoke_violation_value = ""
        co_violation_value = ""
        
        ambangBatas = mydb.cursor(buffered=True)

        ambangBatas.execute("""SELECT ambangBatas FROM sensor WHERE inisialSensor = 'L' OR inisialSensor = 'C' OR inisialSensor = 'A'""")
        ambangBatasArray = [item[0] for item in ambangBatas.fetchall()] #returns in order [0]-> LPG, [1]->Carbon, [2]->Smoke
        
        while sensingStatus:            
            data = serial.readline().decode("ascii").strip()
            #data = "H67.00 T26.00 L0.00 C0.00 A0.00 P7.20 K0.00"
            #print(data)
            
            #inisialSensor -> returns array of identitas (ex : [T,H,L])
            inisialSensor = mydb.cursor(buffered=True)

            inisialSensor.execute("""SELECT inisialSensor FROM sensor""")
            inisialSensorArray = [item[0] for item in inisialSensor.fetchall()]

            if data != "":
                parameters = data.split() #returns -> [T0,H0,L0]
                
                #splitting parameter from value and insert to DB
                for value in parameters:
                    
                    parameterInisial = value[0] # ex : H
                    nilaiPengukuran = value[1:] # ex : 70
                    
                    #violation checking for email warning
                    if parameterInisial == "L" and float(nilaiPengukuran) >= ambangBatasArray[0]:
                        lpg_violation += 1
                        lpg_violation_value = nilaiPengukuran
                        
                    if parameterInisial == "C" and float(nilaiPengukuran) >= ambangBatasArray[1]:
                        co_violation += 1
                        co_violation_value = nilaiPengukuran
                        
                    if parameterInisial == "A" and float(nilaiPengukuran) >= ambangBatasArray[2]:
                        smoke_violation += 1
                        smoke_violation_value = nilaiPengukuran
                        
                    if lpg_violation > 5 or co_violation > 5 or smoke_violation > 5:
                        self.sendWarningEmail(lpg_violation_value,smoke_violation_value,co_violation_value,ambangBatasArray[0],ambangBatasArray[2],ambangBatasArray[1])
                        lpg_violation = 0
                        smoke_violation = 0
                        co_violation = 0
                    
                    #getIdSensor -> getting idSensor for insertion to db, returns idSensor
                    idSensorCursor = mydb.cursor(buffered=True)

                    queryIdSensor = "SELECT idSensor FROM sensor WHERE inisialSensor = %s"
                    value = (parameterInisial,)
                    idSensorCursor.execute(queryIdSensor, value)
                    
                    idSensor = [item[0] for item in idSensorCursor.fetchall()][0]
                    
                    #getIdNode -> getting idNode for insertion to db, returns idNode
                    idNodeCursor = mydb.cursor(buffered=True)

                    queryIdNode = "SELECT nodeSensor.idNode FROM nodeSensor JOIN sensor ON nodeSensor.idNode = sensor.idNode WHERE inisialSensor = %s"
                    value = (parameterInisial,)
                    idNodeCursor.execute(queryIdNode, value)
                    
                    idNode= [item[0] for item in idNodeCursor.fetchall()][0]
                    
                    #inserting to database
                    insertDataToDB(idSensor, nilaiPengukuran)
                    
            time.sleep(self.interval)

# Starting Application

# ==== Main Menu Component ====
def mainMenu():
    time.sleep(1)
    print("Status Sensor : " + translateStatusIntoWords(sensingStatus))
    print("=============================================")
    print("Menu :")
    print("1. Mulai Pencatatan Sensing")
    print("2. Berhenti Pencatatan Sensing")
    print("3. Daftar Account User Website Pemantauan")
    print("4. Update User Password")
    print("5. Update Notifikasi User")
    print("6. Manage Parameter Sensor")
    print("7. Keluar")
    print("=============================================")
    print("Silahkan Masukkan Nomor Input :")
# ==== End of Main Menu Component ====

print("Selamat Datang pada Aplikasi Sistem Pemantauan Rumah")
mainMenu()
userInput = input()

while appRunning:
    # enabling sensing
    if userInput == "1" and sensingStatus == False:    
        sensingStatus = True
        sensorSense()
        print("Sensing Started!")
        mainMenu()
    elif userInput == "2" and sensingStatus == True:
        sensingStatus = False
        print("Sensing Stopped!")
        mainMenu()
    elif userInput == "3":
        print("Silahkan masukkan email :")
        email = input()
        print("Silahkan masukkan password :")
        password = input()
        insertUserToDB(email,password)
        mainMenu()
    elif userInput == "4":
        data = getAllEmail()
        print("List email yang sudah terdaftar :\n")
        for x in data:
            print(x[0])
        print("\nSilahkan masukkan email yang akan diubah passwordnya:")
        email = input()
        print("Silahkan masukkan password baru :")
        password = input()
        updateUserPassword(email,password)
        mainMenu()
    elif userInput == "5":
        data = getAllEmail()
        print("List email dan status notifikasi yang sudah terdaftar :")
        for x in data:
            print(x)
        print("Silahkan masukkan email yang akan diubah :")
        email = input()
        print("Apakah anda ingin menyalakan/mematikan notifikasi? (masukkan 0 = mati ATAU 1 = nyala) :")
        notifikasi = input()
        updateUserNotifikasi(email,notifikasi)
        mainMenu()
    elif userInput == "6":
        
        print("=============================================")
        print("Manage Parameter Sensor")
        print("=============================================")
        print("Sensor-sensor yang tersedia : ")
        #print("(Format : Inisial Sensor , Identitas Lengkap , Satuan Standar , Ambang Batas , Lokasi Penempatan)")
        
        listSensor = mydb.cursor(buffered=True)

        listSensor.execute("""SELECT namaNode ,lokasiNode, inisialSensor, identitasSensor, satuan, ambangBatas, warning  FROM sensor JOIN nodeSensor ON sensor.idNode = nodeSensor.idNode""")
        hasil = listSensor.fetchall()
        
        for x in hasil:
            print(x)
        
        print("1. Masukkan Node Sensor Baru")
        print("2. Masukkan Jenis Sensor Baru")
        print("3. Edit Node Sensor")
        print("4. Edit Sensor")
        print("5. Kembali")
        print("=============================================")
        
        choice = input()
        if choice == "1":
            print("Silahkan masukkan data-data node sensor baru :")
            
            print("Nama node sensor : ")
            namaNode = input()
            
            print("Lokasi penempatan node sensor : ")
            lokasi = input()
            
            correction = 'Nama Node : ' + namaNode + '\n' + 'Lokasi Node : ' + lokasi
            print(correction)
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                insertNodeSensorDataToDB(namaNode, lokasi)
            
            mainMenu()
            
        elif choice == "2":
            print("Pilih id node sensor yang akan dilengkapi oleh sensor ini : ")
            print("(Format List : idNode, Nama Node, Lokasi Node)")
            
            listEdit= mydb.cursor(buffered=True)

            listEdit.execute("""SELECT * FROM nodeSensor""")
            preview = listEdit.fetchall()
            
            for x in preview:
                print(x)
                
            idNode = input()
            
            print("Silahkan masukkan data-data jenis sensor baru :")
            
            print("Inisial dari hasil pengukuran sensor (harus sesuai dengan inisial sensor pada arduino) : ")
            inisialSensor = input()
        
            print("Nama dari hasil pengukuran sensor : ")
            identitasSensor = input()
            
            print("Satuan standar hasil pengukuran dari sensor terkait : ")
            satuan = input()
            
            print("Ambang batas hasil pengukuran dari parameter terkait : ")
            ambangBatas = input()
            
            print("Apakah warning yang akan diberikan apabila hasil pengukuran memenuhi ambang batas dari (max 256 karakter) : ")
            warning = input()
        
            correction = 'inisial sensor : ' + inisialSensor + '\n' + 'nama hasil pengukuran sensor : ' + identitasSensor + '\n' + 'satuan : ' + satuan + '\n' + 'ambang batas : ' + ambangBatas + '\n' + 'warning : ' + warning
            print(correction)
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                insertSensorDataToDB(inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode)
                
            mainMenu()
        elif choice == "3":
            print("Silahkan pilih data node sensor yang akan di edit :")
            print("(Format : idNode, Nama Node, Lokasi Node)")
            listEdit= mydb.cursor(buffered=True)

            listEdit.execute("""SELECT * FROM nodeSensor""")
            preview = listEdit.fetchall()
            
            for x in preview:
                print(x)
            
            print("Silahkan pilih id data yang akan di edit : ")
            idEdit = input()
            
            print("Nama node sensor : ")
            namaNode = input()
            
            print("Lokasi penempatan node sensor : ")
            lokasi = input()
            
            correction = 'Nama Node : ' + namaNode + '\n' + 'Lokasi Node : ' + lokasi
            print(correction)
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                updateNodeSensorDataToDB(idEdit ,namaNode, lokasi)
            
            mainMenu()
            
        elif choice == "4":
            print("Silahkan pilih data sensor yang akan di edit :")
            print("(Format : idSensor, Inisial Sensor , Identitas Sensor , Satuan , Ambang Batas , Warning)")

            listEdit= mydb.cursor(buffered=True)

            listEdit.execute("""SELECT * FROM sensor""")
            preview = listEdit.fetchall()
            
            for x in preview:
                print(x)
            
            print("Silahkan pilih id data yang akan di edit : ")
            idEdit = input()
            
            print("Apakah sensor akan dipindahkan ke node lain? (Apabila tidak, masukkan id node sensor yang sedang dipasang sensor ini) : ")
            print("(Format List : idNode, Nama Node, Lokasi Node)")
            
            listEdit= mydb.cursor(buffered=True)

            listEdit.execute("""SELECT * FROM nodeSensor""")
            preview = listEdit.fetchall()
            
            for x in preview:
                print(x)
                
            idNode = input()
            
            print("Inisial dari hasil pengukuran sensor (harus sesuai dengan inisial sensor pada arduino) : ")
            inisialSensor = input()
        
            print("Nama dari hasil pengukuran sensor : ")
            identitasSensor = input()
            
            print("Satuan standar hasil pengukuran dari sensor terkait : ")
            satuan = input()
            
            print("Ambang batas hasil pengukuran dari parameter terkait : ")
            ambangBatas = input()
            
            print("Apakah warning yang akan diberikan apabila hasil pengukuran memenuhi ambang batas dari (max 256 karakter) : ")
            warning = input()
        
            correction = 'inisial sensor : ' + inisialSensor + '\n' + 'nama hasil pengukuran sensor : ' + identitasSensor + '\n' + 'satuan : ' + satuan + '\n' + 'ambang batas : ' + ambangBatas + '\n' + 'warning : ' + warning
            print(correction)
            
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                updateSensorDataToDB(idEdit , inisialSensor, identitasSensor, satuan, ambangBatas, warning, idNode)
                
            mainMenu()
        else:
            mainMenu()
    elif userInput == "7":
        sensingStatus = False
        appRunning = False
        print("Sensing dan Aplikasi dimatikan..")
        print("Selamat Tinggal!")
        break
    elif userInput == "menu":
        mainMenu()
    else:
        print("Perintah tidak diketahui \ Perintah sedang dijalankan, silahkan masukkan \"menu\" untuk melihat menu.")
    userInput = input()
    
# End of Starting Application