# Dit is de code van de raspberry PI om de temparatuur door te sturen naar de webserver.

# !/usr/bin/python3
import sys, getopt
import argparse
import sense_hat
import time
import requests

sensor_name = 'Temperatuur';


# parse arguments
verbose = True
interval = 3  # second
url = "http://10.80.17.17:80/KBS_group2/temp.php?secret=geheimwachtwoord&temp="

opts, args = getopt.getopt(sys.argv[1:], "vt:")

for opt, arg in opts:
    if opt == '-v':
        verbose = False
    elif opt == '-t':
        interval = int(arg)

# instantiate a sense-hat object
sh = sense_hat.SenseHat()

# infinite loop

while True:

    # measure temperature
    temp = round(sh.get_temperature(), 1)
    # verbose
    #if verbose:
    #    print("Temperature: %s C" % temp)

    # temp = temp - 10
    

    #stuurt output naar php
    temp = str(temp)
    
    postObject = {
        "temp": temp
    }
    
    temp = url+temp
    result = requests.get(temp)
    print(result.text)
    print("Aanvraag verstuurd")

    
    # wait a while
    time.sleep(interval)

