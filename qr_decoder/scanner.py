import mysql.connector
import cv2
import numpy as np
from pyzbar.pyzbar import decode
from time import sleep
import json

currentID = 0 

mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        passwd="",
        database="modulehub_database"
        )
mycursor = mydb.cursor(dictionary=True)

def decoder(image):
    gray_img = cv2.cvtColor(image,0)
    barcode = decode(gray_img)

    for obj in barcode:
        print('Please Wait... ')
        sleep(1)
        points = obj.polygon
        (x,y,w,h) = obj.rect
        pts = np.array(points, np.int32)
        pts = pts.reshape((-1, 1, 2))
        cv2.polylines(image, [pts], True, (0, 255, 0), 3)

        barcodeData = obj.data.decode("utf-8")
        barcodeType = obj.type
        barcodeData = json.loads(barcodeData)

        if "user" in barcodeData.keys():
            print("user exist!")
            global currentID
            currentID = barcodeData["user"]
            mycursor.execute(f'''SELECT * FROM users WHERE id = {currentID}''')
            result = mycursor.fetchone()
            if result is None:
                print("No user found. Please try again.")
            else:
                print(str.capitalize(result["firstname"])+" "+str.capitalize(result["lastname"]))
                mycursor.execute(f'''SELECT *, u.id as user_id FROM class c
                                JOIN subjects s ON s.id = c.subject_id
                                JOIN users u ON u.id = c.user_id
                                WHERE u.id = {currentID} AND returned = 0''')
                subjects = mycursor.fetchall()
                print("Remaining subjects for returning:")
                for subject in subjects:
                    print(str.capitalize(subject["code"]))
        elif "subject" in barcodeData.keys():
            print("Subject exits!")
            subjectID = barcodeData["subject"]
            updateStatus = f'''UPDATE class SET returned = '1' WHERE subject_id = {subjectID} AND user_id = {currentID} '''
            mycursor.execute(updateStatus)
            mydb.commit()

            mycursor.execute(f'''SELECT *, u.id as user_id FROM class c
                                JOIN subjects s ON s.id = c.subject_id
                                JOIN users u ON u.id = c.user_id
                                WHERE u.id = {currentID} AND returned = 0 ''')
            subjects = mycursor.fetchall()
            if subjects is None:
                print("All subjects has been returned!")
            else:
                print("Remaining subjects for returning:")
                for subject in subjects:
                    print(str.capitalize(subject["code"]))
        else:
            print("invalid QR code")      

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