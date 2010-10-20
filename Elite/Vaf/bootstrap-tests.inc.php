<?php
error_reporting( E_ALL | E_STRICT | E_NOTICE );
ini_set( 'display_errors', 1 );

define( 'ELITE_PATH', 'E:\dev\vaf\app\code\local\Elite' ); // put path to app/code/local/Elite
define( 'ELITE_CONFIG', ELITE_PATH . '/Vaf/config.ini' );
define( 'TESTFILES', dirname( __FILE__ ) . '/../../tests/files/' );

define( 'ELITE_TESTING', 1 );

set_include_path( 
     ELITE_PATH
     . PATH_SEPARATOR . 'E:\dev\vaf\app\code\local\\'
     . PATH_SEPARATOR . 'E:\dev\vaf\app\code\core\\'
     . PATH_SEPARATOR . 'E:\dev\vaf\lib\\'
     . PATH_SEPARATOR . ELITE_PATH . '\lib'
     . PATH_SEPARATOR . get_include_path()
);