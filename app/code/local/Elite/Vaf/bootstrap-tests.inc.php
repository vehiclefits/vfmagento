<?php
error_reporting( E_ALL | E_STRICT | E_NOTICE );
ini_set( 'display_errors', 1 );

require_once('bootstrap.php');

/**
 * The paths are controlled by app/code/local/Elite/phpunit.xml.dist
 * using the <php><env /></php> section. To make changes, make a copy
 * of phpunit.xml.dist to phpunit.xml
 */

define( 'MAGE_PATH', $_ENV['MAGE_PATH']);
define( 'TESTFILES', $_ENV['TESTFILES'] );

# database details for test server
define( 'VAF_DB_USERNAME', $_ENV['VAF_DB_USERNAME'] );
define( 'VAF_DB_PASSWORD', $_ENV['VAF_DB_PASSWORD'] );
define( 'VAF_DB_NAME', $_ENV['VAF_DB_NAME'] );

# used to make "test only code" run (Google "test code in production")
define( 'ELITE_TESTING', 1 );

set_include_path( 
     ELITE_PATH
     . PATH_SEPARATOR . MAGE_PATH . '/app/code/local/'
     . PATH_SEPARATOR . MAGE_PATH . '/app/code/core/'
     . PATH_SEPARATOR . MAGE_PATH . '/lib/'
     . PATH_SEPARATOR . get_include_path()
);