import mysql.connector
import cv2
import numpy as np
from pyzbar.pyzbar import decode
from time import sleep
import json
import threading as th
import RPi.GPIO as GPIO

currentID = 0
isScan = True
mydb = mysql.connector.connect(
        host="192.168.100.22",
        user="modulehub_database",
        passwd="modulehub_database",
        database="modulehub_database"
        )
mycursor = mydb.cursor(dictionary=True)
cap = cv2.VideoCapture(0)
def reOpenScanner():
    while True:
        ret, frame = cap.read()
        if isScan:
            decoder(frame)
        else:
            pass

        cv2.imshow('Scan QR Code for Subject', frame)
        code = cv2.waitKey(10)
        if code == ord('q'):
            break

def isScanSet():
    # cv2.destroyAllWindows()
    T = th.Timer(5.0, isScanSetTrue)
    T.start()
    print("Please wait for our notice before returning the next module.")
    print("Please wait....")

def isScanSetTrue():
    global isScan
    isScan = True
    print("You can put the module now")

print('Scan QR to start')

def decoder(image):
    gray_img = cv2.cvtColor(image,0)
    barcode = decode(gray_img)

    for obj in barcode:
        print('Please Wait... ')
        # sleep(2)
        points = obj.polygon
        (x,y,w,h) = obj.rect
        pts = np.array(points, np.int32)
        pts = pts.reshape((-1, 1, 2))
        cv2.polylines(image, [pts], True, (0, 255, 0), 3)

        barcodeData = obj.data.decode("utf-8")
        barcodeType = obj.type
        barcodeData = json.loads(barcodeData)

        if "subject" in barcodeData.keys():
            # False Scan Here
            global isScan
            isScan = False
            mycursor.execute(f'''SELECT * FROM which_student
                                WHERE id = 1 ''')
            students = mycursor.fetchall()

            if not students:
                print("Please scan your QR Student ID first.")
                break
            else:
                for student in students:
                    currentID = student["student_id"]
            print(f"Student ID:  {currentID}")
            print("Subject exists!")
            subjectID = barcodeData["subject"]
            updateStatus = f'''UPDATE module m
                            SET m.returned = '1' 
                            WHERE m.subject_id = '{subjectID}' AND m.user_id = '{currentID}' AND m.returned = '-1'
                            ORDER BY m.id
                            ASC LIMIT 1 '''
            mycursor.execute(updateStatus)
            mydb.commit()

            # updateStatus = f'''UPDATE class SET returned = '1' WHERE subject_id = {subjectID} AND user_id = {currentID} '''
            # mycursor.execute(updateStatus)
            # mydb.commit()

            # For Servo Motor here
            GPIO.setmode(GPIO.BOARD)
            GPIO.setwarnings(False)
            GPIO.setup(23, GPIO.OUT)
            pwm = GPIO.PWM(23, 50)
            pwm.start(0)

            def SetAngle(angle):
                duty = angle / 18 + 2
                GPIO.output(23, True)
                pwm.ChangeDutyCycle(duty)
                sleep(1)
                GPIO.output(23, False)   
                pwm.ChangeDutyCycle(0)


            SetAngle(90)
            pwm.stop()
            GPIO.cleanup()

            #End Servo motor here

            # Start Stepper here
            GPIO.setmode(GPIO.BCM)
            GPIO.setwarnings(False)
            GPIO.setup(18, GPIO.OUT)
            GPIO.output(18, GPIO.LOW)

            GPIO.output(18, GPIO.HIGH)
            sleep(5)
            GPIO.output(18, GPIO.LOW)

            pwm.stop()
            GPIO.cleanup()
            # End Stepper here

            mycursor.execute(f'''SELECT *, u.id as user_id FROM module m
                                JOIN subjects s ON s.id = m.subject_id
                                JOIN users u ON u.id = m.user_id
                                WHERE u.id = {currentID} AND m.returned = -1 ''')
            subjects = mycursor.fetchall()


            if not subjects:
                    print("All subject(s) has been returned!")
            else:
                print("Remaining subjects for returning:")
                for subject in subjects:
                    print("Subject: " + str.capitalize(subject["code"]) + "; Week: " + str(subject["count_week"]))
                print("Please put the module into the bin")
            isScanSet()
        else:
            print("Invalid QR code")

reOpenScanner()