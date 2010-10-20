<?php
//PHPUnit_Util_Filter::addDirectoryToWhitelist('E:\dev\vaf\app\code\local\Elite');
require_once('bootstrap-tests.inc.php');
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
    
//    public static function app()
//    {
//        debugbreak();
//    }
//    
//    public static function getResourceSingleton()
//    {
//        debugbreak();
//    }
//    
//    public static function dispatchEvent()
//    {
//        debugbreak();
//    }
//    
    public static function getStoreConfig()
    {
        return false;
    }
    
    public static function isInstalled()
    {
        return true;
    }
}

//$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
//$schemaGenerator->dropExistingTables();
//$schemaGenerator->execute('make,model,year');