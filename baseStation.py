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
    
def updateSensorDataToDB(idEdit , inisialSensor, identitasSensor, satuan, ambangAtas, ambangBawah, warningAmbangAtas, warningAmbangBawah, idNode, notifPriority):
    cursor = mydb.cursor()

    query = "UPDATE sensor SET inisialSensor = %s, identitasSensor = %s, satuan = %s, ambangBatasAtas = %s, ambangBatasBawah = %s , warningAmbangAtas = %s, warningAmbangBawah = %s, idNode = %s, notifPriority = %s WHERE idSensor = %s"
    val = (inisialSensor, identitasSensor, satuan, ambangAtas, ambangBawah, warningAmbangAtas , warningAmbangBawah, idNode, notifPriority, idEdit)

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
    
def insertSensorDataToDB(inisialSensor, identitasSensor, satuan, ambangBatasAtas, ambangBatasBawah , warningAmbangAtas, warningAmbangBawah, idNode, notifPriority):
    cursor = mydb.cursor()

    query = "INSERT INTO sensor (inisialSensor, identitasSensor, satuan, ambangBatasAtas, ambangBatasBawah , warningAmbangAtas, warningAmbangBawah, notifPriority, idNode) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)"
    val = (inisialSensor, identitasSensor, satuan, ambangBatasAtas, ambangBatasBawah , warningAmbangAtas, warningAmbangBawah, notifPriority, idNode)

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
    def __init__(self, interval = 0):
        self.interval = interval

        sensingThread = threading.Thread(target=self.run, args=())
        sensingThread.daemon = True

        sensingThread.start()
        
    def sendWarningEmail(self,notif):
        sender_address = '2017730022.monitoring@gmail.com'
        sender_pass = 'homemonitoring'
        
        cursor = mydb.cursor(buffered=True)#the buffer will prevent unread result found from fetchone()
        cursor.execute("""SELECT email FROM user WHERE notifikasi = 1""")
        result = cursor.fetchone()
        
        mail_content = "Telah dideteksi keberadaan tanda bahaya dalam area pemeriksaan, dengan detail sebagai berikut :\n\n"
        mail_end = "\n\n Harap berhati-hatilah dan periksa kembali keadaan tersebut! \n\n Home Monitoring System - 2017730022"

        content = mail_content + notif + mail_end
        
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
        ambangBatas = mydb.cursor(buffered=True)

        ambangBatas.execute("""SELECT inisialSensor, identitasSensor, satuan ,ambangBatasAtas, ambangBatasBawah FROM sensor WHERE notifPriority = 1""")
        ambangBatasArray = ambangBatas.fetchall() #returns ambangBatasAtas, ambangBatasBawah
        
        #removing last data
        data = serial.readline().decode("ascii").strip()
        data = ""
        
        #to prevent email spam
        emailDelay = False
        delayCounter = 0
        warningFlag = False
        
        while sensingStatus:            
            data = serial.readline().decode("ascii").strip()
#             data = "AH71.00 AT29.00 AL10.00 AC0.00 AA0.00 BP8.20 BK11.00"
#             data = "AH11.00 AT17.00 AL0.00 AC0.00 AA0.00 BP6.20 BK0.00"
#             data = "AH50.00 AT25.00 AL0.00 AC0.00 AA0.00 BP7.00 BK0.00"
            #print(data)
            
            #inisialSensor -> returns array of identitas (ex : [T,H,L])
            inisialSensor = mydb.cursor(buffered=True)

            inisialSensor.execute("""SELECT inisialSensor FROM sensor""")
            inisialSensorArray = [item[0] for item in inisialSensor.fetchall()]

            if data != "":
                parameters = data.split() #returns -> [T0,H0,L0]
                emailWarningNotification = ""
                
                #splitting parameter from value and insert to DB
                for value in parameters:
                    
                    parameterNode = value[0] #ex : A
                    parameterInisial = value[1] # ex : H
                    nilaiPengukuran = value[2:] # ex : 70
                    
                    #violation checking for email warning

                    for violationCheck in ambangBatasArray:
                        if parameterInisial == violationCheck[0] :
                            if float(nilaiPengukuran) > violationCheck[3]:
                                warningFlag = True
                                emailWarningNotification += "Nilai pada parameter " + violationCheck[1] + " bernilai :" + nilaiPengukuran + " " + violationCheck[2] + " melebihi ambang batas sejumlah " + str(violationCheck[3]) + " " + violationCheck[2]
                            elif float(nilaiPengukuran) < violationCheck[4]:
                                warningFlag = True
                                emailWarningNotification += "Nilai pada parameter " + violationCheck[1] + " bernilai :" + nilaiPengukuran + " " + violationCheck[2] + " kurang dari ambang batas sejumlah " + str(violationCheck[4]) + " " + violationCheck[2]
                            emailWarningNotification += "\n"
                    
                    #getId -> getting namaNode and idSensor for insertion to db, returns namaNode, idSensor
                    idCursor = mydb.cursor(buffered=True)

                    queryId = "SELECT sensor.idSensor, nodeSensor.namaNode FROM nodeSensor JOIN sensor ON nodeSensor.idNode = sensor.idNode WHERE inisialSensor = %s AND namaNode = %s"
                    value = (parameterInisial, parameterNode)
                    idCursor.execute(queryId, value)
                    
                    #error handling for empty result
                    ids= idCursor.fetchall()[0][0]
                    
                    #inserting to database
                    insertDataToDB(ids, nilaiPengukuran)
            
            if warningFlag and emailDelay == False:
#                 print("sent!")
                self.sendWarningEmail(emailWarningNotification)
                warningFlag = False
                emailDelay = True
                delayCounter = 20 #more or less is one minute long
            
            if emailDelay:
                delayCounter -= 1
            
            if delayCounter == 0:
#                 print("email delay was resetted, email will be sent again")
                emailDelay = False
                
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
        print("(Format : Inisial Sensor , Lokasi Penempatan ,  Identitas Lengkap , Satuan Standar , Ambang Batas Atas , Ambang Batas Bawah , Warning Ambang Batas Atas , Warning Ambang Batas Bawah)")
        
        listSensor = mydb.cursor(buffered=True)

        listSensor.execute("""SELECT namaNode ,lokasiNode, inisialSensor, identitasSensor, satuan, ambangBatasAtas, warningAmbangAtas, ambangBatasBawah, warningAmbangBawah FROM sensor JOIN nodeSensor ON sensor.idNode = nodeSensor.idNode""")
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
            
            print("Ambang batas atas pada pengukuran dari parameter terkait (apabila nilai parameter melebihi ambang batas atas berarti bahaya) : ")
            ambangBatasAtas = input()
            
            print("Ambang batas bawah pada pengukuran dari parameter terkait (apabila nilai parameter kurang dari ambang batas bawah berarti bahaya) : ")
            ambangBatasBawah = input()
            
            print("Apakah warning yang akan diberikan apabila hasil pengukuran melebihi ambang batas atas (max 256 karakter) : ")
            warningBatasAtas = input()
            
            print("Apakah warning yang akan diberikan apabila hasil pengukuran kurang dari ambang batas bawah (max 256 karakter) : ")
            warningBatasBawah = input()
            
            print("Aktifkan pengawasan via notifikasi untuk parameter ini? (input 0 untuk tidak, 1 untuk iya) : ")
            notifPriority = input()
        
            correction = 'inisial sensor : ' + inisialSensor + '\n' + 'nama hasil pengukuran sensor : ' + identitasSensor + '\n' + 'satuan : ' + satuan + '\n' + 'ambang batas atas : ' + ambangBatasAtas + '\n' + 'warning ambang batas atas: ' + warningBatasAtas + 'ambang batas bawah : ' + ambangBatasBawah + '\n' + 'warning ambang batas bawah: ' + warningBatasBawah + '\n' + 'Pengawasan Notifikasi: ' + notifPriority
            print(correction)
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                insertSensorDataToDB(inisialSensor, identitasSensor, satuan, ambangBatasAtas, ambangBatasBawah, warningBatasAtas, warningBatasBawah , idNode, notifPriority)
                
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
            
            print("Ambang batas atas pada pengukuran dari parameter terkait (apabila nilai parameter melebihi ambang batas atas berarti bahaya) : ")
            ambangBatasAtas = input()
            
            print("Ambang batas bawah pada pengukuran dari parameter terkait (apabila nilai parameter kurang dari ambang batas bawah berarti bahaya) : ")
            ambangBatasBawah = input()
            
            print("Apakah warning yang akan diberikan apabila hasil pengukuran melebihi ambang batas atas (max 256 karakter) : ")
            warningBatasAtas = input()
            
            print("Apakah warning yang akan diberikan apabila hasil pengukuran kurang dari ambang batas bawah (max 256 karakter) : ")
            warningBatasBawah = input()
            
            print("Aktifkan pengawasan via notifikasi untuk parameter ini? (input 0 untuk tidak, 1 untuk iya) : ")
            notifPriority = input()
        
            correction = 'inisial sensor : ' + inisialSensor + '\n' + 'nama hasil pengukuran sensor : ' + identitasSensor + '\n' + 'satuan : ' + satuan + '\n' + 'ambang batas atas : ' + ambangBatasAtas + '\n' + 'warning ambang batas atas: ' + warningBatasAtas + 'ambang batas bawah : ' + ambangBatasBawah + '\n' + 'warning ambang batas bawah: ' + warningBatasBawah + '\n' + 'Pengawasan Notifikasi: ' + notifPriority
            print(correction)
            
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                updateSensorDataToDB(idEdit , inisialSensor, identitasSensor, satuan, ambangBatasAtas, ambangBatasBawah, warningBatasAtas, warningBatasBawah , idNode , notifPriority)
                
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