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
 * to license@magentocommerce.com so we can send you a copy immediately.
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

/**
 * The paths are controlled by app/code/local/Elite/phpunit.xml.dist
 * using the <php><env /></php> section. To make changes, make a copy
 * of phpunit.xml.dist to phpunit.xml
 */

define( 'MAGE_PATH', realpath(getenv('PHP_MAGE_PATH')));
define( 'TEMP_PATH', getenv('PHP_TEMP_PATH') );

# database details for test server
define( 'VAF_DB_USERNAME', getenv('PHP_VAF_DB_USERNAME') );
define( 'VAF_DB_PASSWORD', getenv('PHP_VAF_DB_PASSWORD') );
define( 'VAF_DB_NAME', getenv('PHP_VAF_DB_NAME') );

# used to make "test only code" run (Google "test code in production")
define( 'ELITE_TESTING', 1 );
define('ELITE_PATH',MAGE_PATH.'/app/code/local/Elite');
require_once('bootstrap.php');

set_include_path(
    ELITE_PATH
        . PATH_SEPARATOR . MAGE_PATH . '/app/code/local/'
        . PATH_SEPARATOR . MAGE_PATH . '/app/code/core/'
        . PATH_SEPARATOR . MAGE_PATH . '/lib/'
        . PATH_SEPARATOR . get_include_path()
);

$_SESSION = array();

function my_autoload($class_name) {
    $file = str_replace( '_', '/', $class_name . '.php' );
    if( 'Mage.php' == $file )
    {
        throw new Exception();
    }
    

    require_once $file;
}
spl_autoload_register('my_autoload');

/** Null out some Magento behavior we do not want to execute because it would have some un-intended side effects. */
class Mage_Bundle_Model_Option 
{
}

class Mock_Mage_Collection
{
    function addIdFilter() {}
}

class Mage_Catalog_Model_Category
{
    function getProductCollection()
    {
        return new Mock_Mage_Collection;
    }
    
    function getId() {}
}

class Mage_Catalog_Model_Product
{
    protected $id;
    protected $name;
    protected $price;
    protected $finalPrice;
    protected $minimal_price;

    function setId( $id )
    {
        $this->id = $id;
    }
    
    function getId()
    {
        return $this->id;
    }
    
    function setName( $name )
    {
        $this->name = $name;
    }
    
    function getName()
    {
        return $this->name;
    }

    function getPrice()
    {
        return $this->price;
    }
    
    function setPrice($price)
    {
        $this->price = $price;
    }

    function getMinimalPrice()
    {
        return $this->minimal_price;
    }

    function setMinimalPrice($price)
    {
       $this->minimal_price = $price;
    }

    function getFinalPrice()
    {
        return $this->finalPrice;
    }
    
    function setFinalPrice($price)
    {
        $this->finalPrice = $price;
    }
    
}

class Mage_Customer_Model_Session
{
    function __call( $mandatory, $argument )
    {
    }
}

class Mage_Core_Model_Session
{
    function __call( $mandatory, $argument )
    {
    }
    
    function init($namespace, $sessionName=null)
    {
        return $this;
    }
}

class Mage_Core_Block_Abstract
{
    function __construct()
    {
    }
    
    function getRequest()
    {
        
    }
}

class Mage_Core_Controller_Varien_Action
{
    protected $request;
    
    function __construct( $request )
    {
        $this->request = $request;
    }
    
    function getRequest()
    {
        return $this->request;
    }
}
   
class Mage
{
    /**
     * Registry collection
     *
     * @var array
     */
    static private $_registry                   = array();
    
    /**
     * Register a new variable
     *
     * @param string $key
     * @param mixed $value
     * @param bool $graceful
     * @throws Mage_Core_Exception
     */
    public static function register($key, $value, $graceful = false)
    {
        if (isset(self::$_registry[$key])) {
            if ($graceful) {
                return;
            }
            self::throwException('Mage registry key "'.$key.'" already exists');
        }
        self::$_registry[$key] = $value;
    }
    
    /**
     * Retrieve a value from registry by a key
     *
     * @param string $key
     * @return mixed
     */
    public static function registry($key)
    {
        if (isset(self::$_registry[$key])) {
            return self::$_registry[$key];
        }
        return null;
    }

    public static function dispatchEvent()
    {
        return false;
    }

    public static function getStoreConfig()
    {
        return false;
    }
    
    public static function isInstalled()
    {
        return true;
    }

    public static function resetRegistry()
    {
        self::$_registry = array();
    }

    static function getResourceSingleton()
    {
        
    }
    
    static function getBaseUrl()
    {
        return '/';
    }

    public static function getUrl($url)
    {
        return $url;
    }
}