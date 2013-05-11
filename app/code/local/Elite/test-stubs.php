<?php
/** Null out some Magento behavior we do not want to execute because it would have some un-intended side effects. */
class Mage_Bundle_Model_Option
{
}

class Mock_Mage_Collection
{
    function addIdFilter()
    {
    }
}

class Mage_Catalog_Model_Category
{
    function getProductCollection()
    {
        return new Mock_Mage_Collection;
    }

    function getId()
    {
    }
}

class Mage_Catalog_Model_Product
{
    protected $id;
    protected $name;
    protected $price;
    protected $finalPrice;
    protected $minimal_price;

    function __construct()
    {

    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function setData($data)
    {
        return $this;
    }

    function setName($name)
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
    function __call($mandatory, $argument)
    {
    }
}

class Mage_Core_Model_Session
{
    function __call($mandatory, $argument)
    {
    }

    function init($namespace, $sessionName = null)
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

    function __construct($request)
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
    static private $_registry = array();

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
            self::throwException('Mage registry key "' . $key . '" already exists');
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