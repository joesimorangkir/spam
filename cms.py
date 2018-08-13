#!/usr/bin/env/python
#-*-coding:utf-8-*-
# Cms Detector
# Coded By Deray
# Greetz To | LOoLzeC | IndoXploit |
import sys,urllib
__banner__="""\033[1;37m
 ___________________
( JoeTampans       )
 -------------------
        o   ^__^
         o  ($$)\_______
            (__)\       )\/\
                
                ||----w |
                ||     ||
                
* Cms Detect By JoeTampans
"""
def cmshunter():
	target=sys.argv[1]
	print __banner__
	print "\033[1;37m\033[31m[-] \033[1;37mTarget : "+target+""
	print "\033[1;37m\033[31m[*] \033[1;37mScanning Cms.."
	list={"/wp-content/":"Wordpress","/administrator":"Joomla","/misc/drupal.js":"Drupal","/skin/frontend/":"Magento","/phpmyadmin":"phpmyadmin"}
	for (url,cms) in list.items():
		full=""+target+"/"+url+""
		try:
			lookit=urllib.urlopen(full)
			if lookit.getcode() == 200:
				print "\033[34m[*]\033[1;37m "+cms+" \033[31m=> \033[1;37mOk :D"
			else:
				print "\033[1;37m\033[31m[-]\033[1;37m "+cms+" \033[31m=> \033[31mNo :'v"
		except:
			print "\033[31m[-] \033[1;37mUssage : "+sys.argv[0]+" http://target.com"
			sys.exit()
	print "\033[31m[!] \033[1;37mScan Finished :v"
	print "\033[31m[!] \033[1;37mBabay :v :v"
	sys.exit()
if __name__ == "__main__":
	if len(sys.argv) !=2:
		print __banner__
		print "\033[31m[-] \033[1;37mUssage : "+sys.argv[0]+" http://target.com"
	else:
		cmshunter()
