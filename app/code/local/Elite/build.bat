REM @ECHO OFF
set PHP-BIN=C:\wamp\bin\php\php5.3.0\php-win.exe
set PHING_HOME=C:\wamp\bin\php\php5.3.0\PEAR\phing\phing
set PHP_CLASSPATH=C:\wamp\bin\php\php5.3.0\PEAR\phing\classes
set PATH=%PATH%;%PHING_HOME%\bin

C:\wamp\bin\php\php5.3.0\phing.bat -Dbuildpath E:\dev\vafbuild dist