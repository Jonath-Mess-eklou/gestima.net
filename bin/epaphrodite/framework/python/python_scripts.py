import sys
 
"""
This file will interface with the OSSIM-framework which will pro
bloc + ip
allow + ip
addAgent + ip
delAgent + ip
 
"""
 
cmd = sys.argv
wf = open("IPs.txt", "at")
if(cmd[1] == "bloc"):
        wf.writelines(cmd[1] + " " + cmd[2] + "\n")