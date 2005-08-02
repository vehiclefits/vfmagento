@ECHO OFF
php C:\wamp\bin\php\php5.3.13\phpunit.phar --no-globals-backup  --stop-on-failure --bootstrap F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php F:\dev\vaf\app\code\local\Elite\%*