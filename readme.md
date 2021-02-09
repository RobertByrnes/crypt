# Crypt
This software is licenced under the MIT licence and is open source.
Use of this software is for educational purposes only and the creator waives
responsibility for uses other than the intended purpose.

# Version
This version: Beta

# Requirements
This software is written for use via a PHP web application delivered from Apache.
Crypt was written using PHP version 7.4.9 and Apache version 2.4.46 and Powershell v1.

# Installation
Download the repo from https://www.https://github.com/RobertByrnes/crypt and install in
the root directory of wampapache64 e.g. www/ or other specified folder. This application
may be installed on a Linux system (see future developements).

# Use
# Beta Version:
The Beta version contains:

- PHP methods for encrypting strings using md5, bcrypt, argon and
custom methods. 'classes/Shifty.php' contains methods for one way encryption and reversable
encryption methods.

- PHP algorithms for brute forcing encrypted string to resolves them to the orignal human
readable string. 'classes/LockPick.php' contains these methods. There are 2 tabs in the UI, one
for MD5 encryptions and one for other encryption methods e.g. bcrypt. None MD5 methods require the
use of a dictionary of possible strings to use to brute force a solution. The dictionaries are located
in 'wordlist/'.

# WARNING:
- In the UI tab 'hashBrute' the user sets the allowable server time for brute forcing
encrypted strings - if set high (some encryptions will require a great number of attempts to 
resolve) it may be necessary to terminate the script running on the apache server.  In the 'shells/'
DIR there is a Powershell script 'killswitch.ps1' - currently working via cmd/powershell terminal with
admin privellages to restart wampapache64.

- The class CheckUrl.php utilises cURL methods within PHP to gather information on a given URL.
The prime bit of information being 'primary_ip' and 'OS_error'. Included within the class is
logging to a text file location in 'logs/'.

- The 'assets/' DIR contains the files to run the UI as well as 'includes/' - 'includes/' contains
.php files. The file ajaxRequest.php handles ajax calls from the UI to the classes and return the data
to be displayed to the UI.

# import new dictionaries
This application ships with 10 dictionaries contain 1 million string to use in brute force attempts.
To add additional dictionaries it is advised 
# future developments
- Other encryption algorithms e.g. SHA256.
- Set up a brute force attack to a login page where email address is known.
- Apache killswitch for Linux.
- MAC address changer for use with Windows and Linux.




