<b>Application setup</b>
This simulation is a web application based on xAMP platform.
For a local test you need to install a xAMP platform on your computer.
xAMP is an acronym for x=any OS, A=Apache web server, M=MySql database manager, P=PHP scripting language.

<b>Installation of LAMP on Linux Debian and derivatives</>
sudo apt-get update
sudo apt-get -y install apache2
sudo systemctl start apache2.service
sudo apt-get install mysql-server (during setup create a root pwd)
sudo apt-get -y install php php-mysql
sudo systemctl restart apache2.service
sudo apt install phpmyadmin (require mysql root pwd)

<b>Installation of WAMP on Windows</b>
WAMP platform is not integrated in Windows OS.
You need to install third party application like xAMPP.
Launch xampp-control application and start Apache and MySQL servers

Copy Application folder "accessosim" into Apache data directory
Linux OS:	usually / var / www / 
Windows OS:  <xAMPP installation path>\htdocs

Visit address: http://localhost/accessosim
This is home page of simulation. Home page contains:
- A block diagram of system
- link to microcomputer based presence sensor simulator page
- link to message broker simulator page
- link to dashboard simulator page
- link to teacher app simulator page
- link to maintenance app simulator page
Each link opens on a different page so you can operate on each page independently and see effect on the other pages.

For example some typical action are:

<b>Normal restroom operation</b>
On teacher app: reserve a VACANT restroom; request in sent to message broker and RESERVED status is echoed on message broker, dashboard, teacher app and maintenance app. 
On micro simulator: switch corresponding sensor status to ON to simulate student access, restroom status is updated to ENGAGED on message broker, dashboard and apps.
On micro simulator: after a while switch same sensor status to OFF to simulate student come out, restroom status is updated to VACANT on message broker, dashboard and apps.

<b>Maintenance  restroom operation</b>
On maintenance app: put to maintenance restroom in any state; request in sent to message broker and MAINTENANCE status is echoed on message broker, dashboard, teacher app and maintenance app. 
On micro simulator: switch corresponding sensor status to ON to simulate maintenance access, restroom status remain to MAINTENANCE but sensor status is switched to ON.
On micro simulator: optional: after a while switch corresponding sensor status to OFF to simulate maintenance come out, restroom status remain to MAINTENANCE but sensor status is switched to OFF.
On maintenance app:  after a while remove maintenance from restroom; request in sent to message broker and VACANT or ENGAGED status  status is echoed depending on status of the presence sensor.

