import serial
import time
import mysql.connector
from datetime import datetime

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

# ====insert data to database====
def insertDataToDB(tipeSensor,data,time):
    cursor = mydb.cursor()

    query = "INSERT INTO sensorReading (timestamp, pengukuran, sensorPengukur) VALUES (%s,%s,%s)"
    val = (time,data,tipeSensor)

    cursor.execute(query, val)

    mydb.commit()
#     print(cursor.rowcount, "record diterima.")

# ====end of insert data====

while True:
     data = serial.readline().decode("ascii").strip()
     if data != "":
         parameters = data.split()
         
         if len(parameters)== 6:
             
             #splitting parameter from value and insert to DB
             for value in parameters:
                 if value[0] == "H":
                     nilai = value[1:]
                     insertDataToDB("humidity",nilai,datetime.now())
                 elif value[0] == "T":
                     nilai = value[1:]
                     insertDataToDB("temperature",nilai,datetime.now())
                 elif value[0] == "L":
                     nilai = value[1:]
                     insertDataToDB("lpg",nilai,datetime.now())
                 elif value[0] == "C":
                     nilai = value[1:]
                     insertDataToDB("carbon",nilai,datetime.now())
                 elif value[0] == "A":
                     nilai = value[1:]
                     insertDataToDB("smoke",nilai,datetime.now())
                 elif value[0] == "P":
                     nilai = value[1:]
                     insertDataToDB("ph",nilai,datetime.now())
                     
             print("Data inserted into database! Inserted : ")
             print(parameters)
             
#      insertDataToDB(data,datetime.now())

# ====select data from database====
# 
# cursor = mydb.cursor()
# cursor.execute("SELECT * FROM sensorReading")
# result = cursor.fetchall()
# 
# for x in result:
#     print(x)


# ====end of select data====
