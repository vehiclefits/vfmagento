@ECHO OFF
php C:\xampp\php\phpunit.phar --no-globals-backup  --stop-on-failure --debug --bootstrap E:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php E:\dev\vaf\app\code\local\Elite\%*