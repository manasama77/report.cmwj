###################
CMWJ REPORT - Alarm & Chart
###################

Application for PT. Daiichi Mandiri Automation - Project 270 for client PT. Central Motor Wheel Jakarta (CMWJ). This application create for generate Alarm and Chart report.
Start Project - 
End Project Phase 1 - 2021-02-19

*******************
Repair Bugs Logs
*******************
- 2021-03-09
	- Repair Bug tanggal pada alarmhistory, sesudah menampilkan table alarmhistory tanggal sebelum di export tidak sama dengan form filter
	- Repair Bug penghitungan durasi, kini, durasi menampilkan 2 digit decimal

*******************
Server Requirements
*******************

- PHP version 7.2 or newer is recommended
- MySql or MariaDB
- Apache / NGINX Server
- Composer

It should work on 5.6 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

- Fork / Clone / Download Source Code from this git (https://github.com/manasama77/report.cmwj)
- Extract if there is still compressed
- Copy & Paste to apache / nginx root folder
- Open Folder report.cmwj
- Open terminal (Git BASH, Command Prompt, Powershell for windows)
- Pointing to apache / nginx root folder -> report.cmwj
- Type on terminal "composer install"

If you having trouble while installation email me to *adam.pm77@gmail.com*

***************
Acknowledgement
***************

This application create using
- PHP Framework - Codeigniter
- Css Framework - Bootstrap
- Javascript library
	- Jquery
	- Mpdf
