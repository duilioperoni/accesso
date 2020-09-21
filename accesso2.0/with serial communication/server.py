import serial #python -m pip install pyserial
import time

def ReadStatus(bath):

    file = open("status.txt", 'r')
    content = eval(file.read())
    file.close()

    return content[bath - 1]

#Init serial ports
serBath1 = serial.Serial('/dev/ttyUSB0', timeout=0)
serBath2 = serial.Serial('/dev/ttyUSB1', timeout=0)
serBath1.write(b'0e')
serBath2.write(b'0e')

#Init variables and status file
status1, status2 = 0, 0

file = open("status.txt", 'w')
file.write(str(status1) + ',' + str(status2))
file.close()

while True:
    #Read Sensors
    if status1 != 3 and status1 != 4: #Skip sensor reading if the restroom is need of sanification
        status1 = serBath1.read_until(b'e')
    else:
        status1 = ''
    if status2 != 3 and status2 != 4:    
        status2 = serBath2.read_until(b'e')
    else:
        status2 = ''

    #If sensors don't have any updates, read status from the file
    try:
        status1 = int(status1)
    except:
        status1 = int(ReadStatus(1))

    try:
        status2 = int(status2)
    except:
        status2 = int(ReadStatus(2))

    print(str(status1) + ',' + str(status2))

    #Update the file
    file = open("status.txt", 'w')
    file.write(str(status1) + ',' + str(status2))
    file.close()
    
    time.sleep(0.2)