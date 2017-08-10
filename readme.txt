remoteDB

This is my attempt to define a 'good' database for IRPs and to use with irp_classes (https://github.com/msillano/irp_classes)
It must be a starting point for building home automation applications.
As a demo of remoteDB capabilities, this is an application to perform a simple replica of standard IR remote controls.
You can see it as an example of using remoteDB and the included php libraries you can use in your IR applications.
--------------------------
notes
in this directory the demo files:
  irp_xxxxxx.php: libraries (include)
  test_xxxxx.php: main test pages, called by index.html
  usr_yyyyyy.php: pages used by test_xxxx
  do_yyyyyyy.php: pages used by test_xxxx

-------------------------------------------
INSTALLATION
1) Copy everything in the web area of your WAMP server: e.g. ' ...\apache\htdocs\www\remoteDB'.
2) You must also download irp_classes from https://github.com/msillano/irp_classes and install it in ' ...\apache\htdocs\www\phpIRPlib'
        note: Due to links and include, do not change 'remoteDB' and 'phpIRPlib' installation dirs.
3a) Create the demo DataBase 'remotesdb' with some data, importing in mySQL the file ...\www\remoteDB\sql\demo_remotesdb.sql
3b) This is a demo, so you can not change the default access in ...\www\remoteDB\irp_config.php
4a) -------- optional
  If you have Arduino-uno and an IR receiver:
         See the dir phpIRPlib/Arduino
4b) -------- mandatory with Arduino
  Serial communications php-Arduino in windows for phpIRPlib/irp_rxtxArduino.php:
         Download and install 'PHP Serial extension' free from http://www.thebyteworks.com (with some limits).
4c) --- no Arduino:
  This demo can run without Arduino and  without serial extension, using recorded IR data.
  To do it replace in files usr_simplerawRX.php and usr_simpleSerialTX.php the include:
               require_once ("$d/../phpIRPlib/irp_rxtxArduino.php");  
     with:     require_once ("$d/irp_rxtxZero.php");
4d) If you have some different IR HW, modify irp_rxtxArduino.php to receive RAW data from your HW.
------------------
5) start from ...\www\remoteDB\index.html

DOCUMENTATION
a) see ...\www\remoteDB\documents\remoteDB\*.*
b) see readme.txt in dirs
c) see comments ebedded into pnp sources.
