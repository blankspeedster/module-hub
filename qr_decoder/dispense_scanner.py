import mysql.connector
import cv2
import numpy as np
from pyzbar.pyzbar import decode
from time import sleep
import json
import RPi.GPIO as GPIO

currentID = 0 

GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)
GPIO.setup(23, GPIO.OUT)
GPIO.output(23, GPIO.LOW)

mydb = mysql.connector.connect(
        host="192.168.100.22",
        user="modulehub_database",
        passwd="modulehub_database",
        database="modulehub_database"
        )
mycursor = mydb.cursor(dictionary=True)

print('Scan QR to start')

def decoder(image):
    gray_img = cv2.cvtColor(image,0)
    barcode = decode(gray_img)

    for obj in barcode:
        print('Please Wait... ')
        sleep(2)
        points = obj.polygon
        (x,y,w,h) = obj.rect
        pts = np.array(points, np.int32)
        pts = pts.reshape((-1, 1, 2))
        cv2.polylines(image, [pts], True, (0, 255, 0), 3)

        barcodeData = obj.data.decode("utf-8")
        barcodeType = obj.type
        barcodeData = json.loads(barcodeData)

        if "user" in barcodeData.keys():
            print("user exists!")
            global currentID
            currentID = barcodeData["user"]
            mycursor.execute(f'''SELECT * FROM users WHERE id = {currentID}''')
            result = mycursor.fetchone()
            if result is None:
                print("No user found. Please try again.")
            else:
                print(str.capitalize(result["firstname"])+" "+str.capitalize(result["lastname"]))
                mycursor.execute(f''' SELECT * FROM users u
                                JOIN module m
                                ON m.user_id = u.id
                                WHERE m.returned = 0 AND u.id = {currentID}
                                LIMIT 1 ''')
                subjects = mycursor.fetchall()
                if not subjects:
                    print("Student has received the modules already.")
                else:
                    updateStatus = f'''UPDATE module SET returned = '-1' WHERE user_id = {currentID} '''
                    mycursor.execute(updateStatus)
                    mydb.commit()
                    
                    GPIO.output(23, GPIO.HIGH)
                    sleep(5)
                    GPIO.output(23, GPIO.LOW)

                    print("Modules has been dispensed. Please tap another QR code for dispensing.")
        else:
            print("Invalid QR code")      

        # string = "Data " + str(barcodeData) + " | Type " + str(barcodeType)
        # newString = str(barcodeData["user"])
        # cv2.putText(frame, newString, (x,y), cv2.FONT_HERSHEY_SIMPLEX,0.8,(255,0,0), 2)
        # cv2.putText(frame, string, (x,y), cv2.FONT_HERSHEY_SIMPLEX,0.8,(255,0,0), 2)

        # print("Barcode: "+barcodeData +" | Type: "+barcodeType)

cap = cv2.VideoCapture(0)
while True:
    ret, frame = cap.read()
    decoder(frame)
    cv2.imshow('Image', frame)
    code = cv2.waitKey(10)
    if code == ord('q'):
        break