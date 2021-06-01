import serial
import time
import mysql.connector
from datetime import datetime
import threading
import os

# Global Variables

appRunning = True
sensingStatus = False

# Admin Defined Sensor Location //Change the value according to the placement of the sensor
lokasi_temperature = "dapur"
lokasi_humidity = "dapur"
lokasi_lpg = "dapur"
lokasi_smoke = "dapur"
lokasi_co = "dapur"
lokasi_ph = "penyimpanan air"
lokasi_turbidity = "penyimpanan air"

#serial details
serial = serial.Serial(
    port='/dev/ttyUSB0',
    baudrate=9600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS,
    timeout=2.5
)

#database details
mydb = mysql.connector.connect(
  host="localhost",
  user="pi",
  password="admin",
  database="pemantaurumah"
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
    
# ====user account====

# ====insert data to database====
def insertDataToDB(tipeSensor,data,time, lokasi):
    cursor = mydb.cursor()

    query = "INSERT INTO sensorReading (timestamp, pengukuran, sensorPengukur, lokasi) VALUES (%s,%s,%s,%s)"
    val = (time,data,tipeSensor,lokasi)

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
            data = serial.readline().decode("ascii").strip()
            #data = "H20 T20 L20 C20 A20 P20"
            if data != "":
                parameters = data.split()
                
                #splitting parameter from value and insert to DB
                for value in parameters:
                    if value[0] == "H":
                        nilai = value[1:]
                        insertDataToDB("humidity",nilai,datetime.now(),lokasi_humidity)
                    elif value[0] == "T":
                        nilai = value[1:]
                        insertDataToDB("temperature",nilai,datetime.now(),lokasi_temperature)
                    elif value[0] == "L":
                        nilai = value[1:]
                        insertDataToDB("lpg",nilai,datetime.now(),lokasi_lpg)
                    elif value[0] == "C":
                        nilai = value[1:]
                        insertDataToDB("carbon",nilai,datetime.now(),lokasi_co)
                    elif value[0] == "A":
                        nilai = value[1:]
                        insertDataToDB("smoke",nilai,datetime.now(),lokasi_smoke)
                    elif value[0] == "P":
                        nilai = value[1:]
                        insertDataToDB("ph",nilai,datetime.now(),lokasi_ph)
                    elif value[0] == "K":
                        nilai = value[1:]
                        insertDataToDB("turbidity",nilai,datetime.now(),lokasi_turbidity)
                            
                    # print("Data inserted into database! Inserted : ")
                    # print(parameters)

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
    print("6. Keluar")
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
        print("Silahkan masukkan email :")
        email = input()
        print("Silahkan masukkan password baru :")
        password = input()
        updateUserPassword(email,password)
        mainMenu()
    elif userInput == "5":
        print("Silahkan masukkan email :")
        email = input()
        print("Apakah anda ingin menyalakan/mematikan notifikasi? (masukkan 0 = mati ATAU 1 = nyala) :")
        notifikasi = input()
        updateUserNotifikasi(email,notifikasi)
        mainMenu()
    elif userInput == "6":
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

# ====select data from database====
# 
# cursor = mydb.cursor()
# cursor.execute("SELECT * FROM sensorReading")
# result = cursor.fetchall()
# 
# for x in result:
#     print(x)


# ====end of select data====