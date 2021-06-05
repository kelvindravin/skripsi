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

# Admin Defined Sensor Location, can be editable in sensor_location.txt file

# Check if sensor_location.txt file is exist, if not write default value of not set
if os.path.isfile('sensor_location.txt'):
    file = open("sensor_location.txt", "r")
    sensor_location = file.read().split(sep=",")
else:
    print("File Tidak Ditemukan! Akan membuat file baru, silahkan rubah lokasi dari sensor!")
    time.sleep(1)
    
    print("Silahkan Masukkan lokasi dari Node Sensor 1 (temperatur,humiditas,LPG,asap,CO) : ")
    newLocSensor1 = input()
    print("Silahkan Masukkan lokasi dari Node Sensor 2 (pH air, turbiditas air) : ")
    newLocSensor2 = input()
    
    file = open("sensor_location.txt", "w")
    file.write(newLocSensor1 + "," + newLocSensor2)
    file.close()
    
    print("Lokasi sensor disimpan dengan nama text file sensor_location.txt")
    
    file = open("sensor_location.txt", "r")
    sensor_location = file.read().split(sep=",")
    
    time.sleep(1)

lokasi_temperature = sensor_location[0]
lokasi_humidity = sensor_location[0]
lokasi_lpg = sensor_location[0]
lokasi_smoke = sensor_location[0]
lokasi_co = sensor_location[0]
lokasi_ph = sensor_location[1]
lokasi_turbidity = sensor_location[1]

batas_lpg = 100
batas_co = 25
batas_smoke = 100

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
        
    def sendWarningEmail(self,lpg,smoke,co):
        sender_address = '2017730022.monitoring@gmail.com'
        sender_pass = 'homemonitoring'
        
        cursor = mydb.cursor(buffered=True)#the buffer will prevent unread result found from fetchone()
        cursor.execute("""SELECT email FROM user WHERE notifikasi = 1""")
        result = cursor.fetchone()
        
        mail_content = '''Telah dideteksi keberadaan tanda bahaya dalam area pemeriksaan, dengan detail sebagai berikut :\n\n'''
        warning_content_lpg = '''Kadar LPG dalam udara : ''' + str(lpg) + '''PPM (dengan batas sebesar ''' + str(batas_lpg) + '''PPM) \n'''
        warning_content_co = '''Kadar CO dalam udara : ''' + str(co) + '''PPM (dengan batas sebesar ''' + str(batas_co) + '''PPM) \n'''
        warning_content_smoke = '''Kadar LPG dalam udara : ''' + str(smoke) + '''PPM (dengan batas sebesar ''' + str(batas_smoke) + '''PPM) \n\n'''
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
        lpg_count = 0
        co_count = 0
        smoke_count = 0
        
        lpg = 0
        co = 0
        smoke = 0
        
        while sensingStatus:            
            data = serial.readline().decode("ascii").strip()
#             print(data)
#             data = "H90.00 T30.00 L200.00 C200.00 A200.00 P14.00 K10.00"
            #data = "H60 T25 L0 C0 A0 P7 K0"
#             
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
                        if float(nilai) > float(batas_lpg):
                            lpg_count += 1
                            lpg = int(nilai)
                        else :
                            lpg_count = 0
                        insertDataToDB("lpg",nilai,datetime.now(),lokasi_lpg)
                    elif value[0] == "C":
                        nilai = value[1:]
                        if float(nilai) > float(batas_co):
                            co_count += 1
                            co = int(nilai)
                        else :
                            co_count = 0
                        insertDataToDB("carbon",nilai,datetime.now(),lokasi_co)
                    elif value[0] == "A":
                        nilai = value[1:]
                        if float(nilai) > float(batas_smoke):
                            smoke_count += 1
                            smoke = int(nilai)
                        else :
                            smoke_count = 0
                        insertDataToDB("smoke",nilai,datetime.now(),lokasi_smoke)
                    elif value[0] == "P":
                        nilai = value[1:]
                        insertDataToDB("ph",nilai,datetime.now(),lokasi_ph)
                    elif value[0] == "K":
                        nilai = value[1:]
                        insertDataToDB("turbidity",nilai,datetime.now(),lokasi_turbidity)

                    #warning notification for around 30 times (more or less 5 minutes) of hazard detection
                    if smoke_count >= 30 or co_count >= 30 or lpg_count >= 30:
                        self.sendWarningEmail(lpg,smoke,co)
                        smoke_count = 0
                        co_count = 0
                        lpg_count = 0

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
    print("6. Update Lokasi Sensor")
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
        print("Silahkan Masukkan lokasi dari Node Sensor 1 (temperatur,humiditas,LPG,asap,CO) : ")
        newLocSensor1 = input()
        print("Silahkan Masukkan lokasi dari Node Sensor 2 (pH air, turbiditas air) : ")
        newLocSensor2 = input()
        file = open("sensor_location.txt", "w")
        file.write(newLocSensor1 + "," + newLocSensor2)
        file.close()
        print("Sukses mengupdate lokasi sensor!")
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