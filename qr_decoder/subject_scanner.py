import mysql.connector
import cv2
import numpy as np
from pyzbar.pyzbar import decode
from time import sleep
import time
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

def stepper(angleValue):
    print("Pushing Stepper")
    # setting in for gpio stepper
    out1 = 5
    out2 = 6
    out3 = 13
    out4 = 12

    GPIO.setmode(GPIO.BCM)
    GPIO.setup(out1,GPIO.OUT)
    GPIO.setup(out2,GPIO.OUT)
    GPIO.setup(out3,GPIO.OUT)
    GPIO.setup(out4,GPIO.OUT)

    i=0
    positive=0
    negative=0
    y=0

    GPIO.output(out1,GPIO.LOW)
    GPIO.output(out2,GPIO.LOW)
    GPIO.output(out3,GPIO.LOW)
    GPIO.output(out4,GPIO.LOW)
    x = int(angleValue)
    if x > 0 and x <= 400:
        for y in range(x,0,-1):
            if negative==1:
                if i==7:
                    i=0
                else:
                    i=i+1
                y=y+2
                negative=0
            positive=1
            #print((x+1)-y)
            if i==0:
                GPIO.output(out1,GPIO.HIGH)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==1:
                GPIO.output(out1,GPIO.HIGH)
                GPIO.output(out2,GPIO.HIGH)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==2:  
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.HIGH)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==3:    
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.HIGH)
                GPIO.output(out3,GPIO.HIGH)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==4:  
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.HIGH)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==5:
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.HIGH)
                GPIO.output(out4,GPIO.HIGH)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==6:    
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.HIGH)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==7:    
                GPIO.output(out1,GPIO.HIGH)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.HIGH)
                time.sleep(0.03)
                #time.sleep(0.03)
            if i==7:
                i=0
                continue
            i=i+1
    
    
    elif x<0 and x>=-400:
        x=x*-1
        for y in range(x,0,-1):
            if positive==1:
                if i==0:
                    i=7
                else:
                    i=i-1
                y=y+3
                positive=0
            negative=1
            #print((x+1)-y) 
            if i==0:
                GPIO.output(out1,GPIO.HIGH)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==1:
                GPIO.output(out1,GPIO.HIGH)
                GPIO.output(out2,GPIO.HIGH)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==2:  
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.HIGH)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==3:    
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.HIGH)
                GPIO.output(out3,GPIO.HIGH)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==4:  
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.HIGH)
                GPIO.output(out4,GPIO.LOW)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==5:
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.HIGH)
                GPIO.output(out4,GPIO.HIGH)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==6:    
                GPIO.output(out1,GPIO.LOW)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.HIGH)
                time.sleep(0.03)
                #time.sleep(0.03)
            elif i==7:    
                GPIO.output(out1,GPIO.HIGH)
                GPIO.output(out2,GPIO.LOW)
                GPIO.output(out3,GPIO.LOW)
                GPIO.output(out4,GPIO.HIGH)
                time.sleep(0.03)
                #time.sleep(0.03)
            if i==0:
                i=7
                continue
            i=i-1
    GPIO.cleanup()

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

            # Start Stepper here
            # stepper(120)
            if subjectID == 1:
                # math
                stepper(30)
            if subjectID == 2:
                # science
                stepper(60)
            if subjectID == 3:
                stepper(90)   
            if subjectID == 4:
                stepper(120)    
            GPIO.cleanup()
            sleep(1)
            # End Stepper here


            # For Servo Motor here
            GPIO.setmode(GPIO.BCM)
            GPIO.setwarnings(False)
            GPIO.setup(27, GPIO.OUT)
            pwm = GPIO.PWM(27, 50)
            pwm.start(0)

            def SetAngle(angle):
                duty = angle / 18 + 2
                GPIO.output(27, True)
                pwm.ChangeDutyCycle(duty)
                sleep(1)
                GPIO.output(27, False)   
                pwm.ChangeDutyCycle(0)

            SetAngle(0)
            sleep(2)
            SetAngle(90)
            sleep(0)
            pwm.stop()
            GPIO.cleanup()

            #End Servo motor here

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