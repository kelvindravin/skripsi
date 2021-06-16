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
# serial = serial.Serial(
#     port='/dev/ttyUSB0',
#     baudrate=9600,
#     parity=serial.PARITY_NONE,
#     stopbits=serial.STOPBITS_ONE,
#     bytesize=serial.EIGHTBITS,
#     timeout=3
# )

#database details
mydb = mysql.connector.connect(
  host="localhost",
  user="pi",
  password="admin",
  database="pemantauanrumah"
)

# ====user account====
def insertUserToDB(email,password):
    cursor = mydb.cursor()

    query = "INSERT INTO user (email,password) VALUES (%s,%s)"
    val = (email,password)

    cursor.execute(query, val)

    mydb.commit()
    print("Account Registered!")

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
    
def updateSatuanDataToDB(idEdit, identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi, warning):
    cursor = mydb.cursor()

    query = "UPDATE satuan SET identitas = %s, identitasLengkap = %s, satuanLengkap = %s, ambangBatas = %s, lokasi = %s, warning = %s WHERE idSatuan = %s"
    val = (identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi , warning, idEdit)

    cursor.execute(query, val)

    mydb.commit()

def getAllEmail():
    cursor = mydb.cursor(buffered=True)

    cursor.execute("""SELECT email,notifikasi FROM user""")
    result = cursor.fetchall()
    
    return result
    
# ====user account====

# ====insert data to database====
def insertDataToDB(idSatuan, nilaiPengukuran):
    cursor = mydb.cursor()

    query = "INSERT INTO parameter (idSatuan, waktu, nilaiPengukuran) VALUES (%s,%s,%s)"
    val = (idSatuan, datetime.now(), nilaiPengukuran)

    cursor.execute(query, val)

    mydb.commit()
    
def insertSatuanDataToDB(identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi, warning):
    cursor = mydb.cursor()

    query = "INSERT INTO satuan (identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi, warning) VALUES (%s,%s,%s,%s,%s,%s)"
    val = (identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi, warning)

    cursor.execute(query, val)

    mydb.commit()
# ====end of insert data====

# for translating True to Online / False to Offline
def translateStatusIntoWords(status):
    if status == True:
        return "Online"
    else:
        return "Offline"

# opening thread and start sensing until it's turned off
class sensorSense():
    def __init__(self, interval = 2.5):
        self.interval = interval

        sensingThread = threading.Thread(target=self.run, args=())
        sensingThread.daemon = True

        sensingThread.start()

    def run(self):
        while sensingStatus:            
            #data = serial.readline().decode("ascii").strip()
            data = "H0.00 T0.00 L0.00 C0.00 A0.00 P0.00 K0.00"
            #print(data)
            
            #identitas -> returns array of identitas (ex : [T,H,L])
            identitas = mydb.cursor(buffered=True)

            identitas.execute("""SELECT identitas FROM satuan""")
            identitasArray = [item[0] for item in identitas.fetchall()]

            if data != "":
                parameters = data.split() #returns -> [T0,H0,L0]
                
                #splitting parameter from value and insert to DB
                for value in parameters:
                    
                    parameterInisial = value[0] # ex : H
                    nilaiPengukuran = value[1:] # ex : 70
                    
                    #getIdSatuan -> getting idSatuan for insertion to db, returns idSatuan
                    idSatuanCursor = mydb.cursor(buffered=True)

                    queryIdSatuan = "SELECT idSatuan FROM satuan WHERE identitas = %s"
                    value = (parameterInisial,)
                    idSatuanCursor.execute(queryIdSatuan, value)
                    
                    idSatuan = [item[0] for item in idSatuanCursor.fetchall()][0]
                    
                    #inserting to database
                    insertDataToDB(idSatuan, nilaiPengukuran)
                    
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
        print("Parameter sensor yang tersedia : ")
        print("(Format : Inisial Sensor , Identitas Lengkap , Satuan Standar , Ambang Batas , Lokasi Penempatan)")
        
        listParam = mydb.cursor(buffered=True)

        listParam.execute("""SELECT identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi  FROM satuan""")
        hasil = listParam.fetchall()
        
        for x in hasil:
            print(x)
        
        print("1. Buat Parameter Sensor Baru")
        print("2. Edit Parameter Sensor")
        print("3. Kembali")
        print("=============================================")
        
        choice = input()
        if choice == "1":
            print("Silahkan masukkan data-data berikut :")
            
            print("Inisial dari parameter baru (harus sesuai dengan inisial pesan dari arduino) : ")
            identitas = input()
        
            print("Identitas lengkap berdasarkan inisial dari sensor : ")
            identitasLengkap = input()
            
            print("Satuan standar dari parameter terkait : ")
            satuanLengkap = input()
            
            print("Ambang batas dari parameter terkait : ")
            ambangBatas = input()
            
            print("Lokasi pemasangan dari sensor parameter terkait : ")
            lokasi = input()
            
            print("Apakah warning yang akan diberikan apabila ambang batas terlampaui / kurang dari (max 256 karakter) : ")
            warning = input()
        
            correction = 'inisial : ' + identitas + '\n' + 'nama parameter : ' + identitasLengkap + '\n' + 'satuan : ' + satuanLengkap + '\n' + 'ambang batas : ' + ambangBatas + '\n'  + 'lokasi : ' + lokasi + '\n'  + 'warning : ' + warning
            print(correction)
            print("Periksa kembali parameter baru, apakah sesuai? (Y/N)")
            checkCorrection = input()
            
            if checkCorrection == "Y":
                insertSatuanDataToDB(identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi, warning)
                
            mainMenu()
        elif choice == "2":
            print("Silahkan pilih data yang akan di edit :")
            print("(Format : id, Inisial Sensor , Identitas Lengkap , Satuan Standar , Ambang Batas , Lokasi Penempatan)")

            listEdit= mydb.cursor(buffered=True)

            listEdit.execute("""SELECT * FROM satuan""")
            preview = listEdit.fetchall()
            
            for x in preview:
                print(x)
            
            print("Silahkan pilih id data yang akan di edit : ")
            idEdit = input()
            
            print("Inisial dari parameter (harus sesuai dengan inisial pesan dari arduino) : ")
            identitas = input()
        
            print("Identitas lengkap berdasarkan inisial dari sensor : ")
            identitasLengkap = input()
            
            print("Satuan standar dari parameter terkait : ")
            satuanLengkap = input()
            
            print("Ambang batas dari parameter terkait : ")
            ambangBatas = input()
            
            print("Lokasi pemasangan dari sensor parameter terkait : ")
            lokasi = input()
            
            print("Warning yang akan diberikan apabila ambang batas terlampaui / kurang dari (max 256 karakter) : ")
            warning = input()
        
            correction = 'inisial : ' + identitas + '\n' + 'nama parameter : ' + identitasLengkap + '\n' + 'satuan : ' + satuanLengkap + '\n' + 'ambang batas : ' + ambangBatas + '\n'  + 'lokasi : ' + lokasi + '\n'  + 'warning : ' + warning
            print(correction)
            
            print("Periksa kembali parameter yang telah diubah, apakah sesuai? (Y/N)")
            
            checkCorrection = input()
            
            if checkCorrection == "Y":
                updateSatuanDataToDB(idEdit , identitas, identitasLengkap, satuanLengkap, ambangBatas, lokasi, warning)
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