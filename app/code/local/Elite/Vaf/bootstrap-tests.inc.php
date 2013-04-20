<?php
error_reporting( E_ALL | E_STRICT | E_NOTICE );
ini_set( 'display_errors', 1 );

require_once('bootstrap.php');

# set up paths specific to test environment
define( 'MAGE_PATH', dirname( __FILE__ ) . '/../../../../../' );
define( 'TESTFILES', 'C:/Windows/Temp' );

# database details for test server
define( 'VAF_DB_USERNAME', 'root' );
define( 'VAF_DB_PASSWORD', '' );
define( 'VAF_DB_NAME', 'vaf' );

# used to make "test only code" run (Google "test code in production")
define( 'ELITE_TESTING', 1 );

set_include_path( 
     ELITE_PATH
     . PATH_SEPARATOR . MAGE_PATH . '/app/code/local/'
     . PATH_SEPARATOR . MAGE_PATH . '/app/code/core/'
     . PATH_SEPARATOR . MAGE_PATH . '/lib/'
     . PATH_SEPARATOR . get_include_path()
);