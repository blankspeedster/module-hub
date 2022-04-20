import RPi.GPIO as GPIO
from time import sleep

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
    sleep(2)
    GPIO.output(27, False)   
    pwm.ChangeDutyCycle(0)

SetAngle(0)
sleep(2)
SetAngle(90)
pwm.stop()
GPIO.cleanup()

#End Servo motor here