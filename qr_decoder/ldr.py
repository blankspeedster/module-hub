import mysql.connector, webbrowser
import os
from gpiozero import LightSensor, Buzzer
from time import sleep

ldr = LightSensor(4)
buzzer = Buzzer(17)

while True:
    sleep(0.01)
    print(ldr.value)
    
    mydb = mysql.connector.connect(
        host="192.168.43.60",
        user="root",
        passwd="",
        database="spcf_turnstile"
        )
    mycursor = mydb.cursor()
    mycursor.execute("SELECT status FROM devices WHERE devicename = 'spcf-main-in-1' ")
    myresult = mycursor.fetchone()
    for status in myresult:
        print(status)
    
    if(status=='1'):
        print('Ready to go')
        sleep(5)
        updateStatus = "UPDATE devices SET status = '0' WHERE devicename='spcf-main-in-1' "
        mycursor.execute(updateStatus)
        mydb.commit()
    else:
        print('Not Ready')
        if ldr.value < 0.5:
            buzzer.on()
            print('INTRUDER')
            webbrowser.open('192.168.43.60/tripwire/intruder.php')
            sleep(5)
            webbrowser.open('192.168.43.60/tripwire')
            #os.system("taskkill /im chromium.exe /f")
        else:
            buzzer.off()
        