<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
error_reporting( E_ALL | E_STRICT | E_NOTICE );
ini_set( 'display_errors', 1 );


define( 'MAGE_PATH', __DIR__.'/../vendor/kylecannon/magento/');

/**
 * The paths are controlled by app/code/local/Elite/phpunit.xml.dist
 * using the <php><env /></php> section. To make changes, make a copy
 * of phpunit.xml.dist to phpunit.xml
 */

define( 'TEMP_PATH', getenv('PHP_TEMP_PATH') );

# database details for test server
define( 'VAF_DB_USERNAME', getenv('PHP_VAF_DB_USERNAME') );
define( 'VAF_DB_PASSWORD', getenv('PHP_VAF_DB_PASSWORD') );
define( 'VAF_DB_NAME', getenv('PHP_VAF_DB_NAME') );

# used to make "test only code" run (Google "test code in production")
define( 'ELITE_TESTING', 1 );

$elite_path = __DIR__.'/../';
defined('ELITE_PATH') or define( 'ELITE_PATH', $elite_path ); // put path to app/code/local/Elite
defined('ELITE_CONFIG_DEFAULT') or define(  'ELITE_CONFIG_DEFAULT', ELITE_PATH . '/Vaf/config.default.ini' );
defined('ELITE_CONFIG') or define(  'ELITE_CONFIG', ELITE_PATH . '/Vaf/config.ini' );

# If being used on qUnit tests, ensure composer's autoloader is setup.
require_once(__DIR__.'/../vendor/autoload.php');

set_include_path(
        PATH_SEPARATOR . MAGE_PATH . '/lib/'
        . PATH_SEPARATOR . get_include_path()
        . PATH_SEPARATOR . MAGE_PATH . '/app/code/local/'
        . PATH_SEPARATOR . MAGE_PATH . '/app/code/core/'

);

$_SESSION = array();

# If being used on qUnit tests, ensure DB is injected
$database = new VF_TestDbAdapter(array(
    'dbname' => VAF_DB_NAME,
    'username' => VAF_DB_USERNAME,
    'password' => VAF_DB_PASSWORD
));
VF_Singleton::getInstance()->setReadAdapter($database);

# used to autoload the Mage_ classes
function my_autoload($class_name) {
    $file = str_replace( '_', '/', $class_name . '.php' );

    if( 'Mage.php' == $file )
    {
        throw new Exception();
    }
    require_once $file;
}
spl_autoload_register('my_autoload');

require_once('test-stubs.php');