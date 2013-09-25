<?php


class Elite_TestCase extends VF_AbstractTestCase
{

    protected function setUp()
    {
        parent::setUp();
        Elite_Vaf_Singleton::getInstance(true);
        Elite_Vaf_Singleton::getInstance()->setRequest(new Zend_Controller_Request_Http);
        $database = new VF_TestDbAdapter(array(
                                              'dbname'   => VAF_DB_NAME,
                                              'username' => VAF_DB_USERNAME,
                                              'password' => VAF_DB_PASSWORD
                                         ));
        Elite_Vaf_Singleton::getInstance()->setReadAdapter($database);

        VF_Schema::$levels = null;

        $_SESSION = array();
        $_GET = array();
        $_REQUEST = array();
        $_POST = array();
        $_FILES = array();

        $this->resetIdentityMaps();
        $this->dropAndRecreateMockProductTable();

        if (class_exists('Mage', false)) {
            Mage::resetRegistry();
        }

        $this->doSetUp();
    }

    function getProductForSku($sku)
    {
        $sql = sprintf(
            "SELECT `entity_id` from `test_catalog_product_entity` WHERE `sku` = %s",
            $this->getReadAdapter()->quote($sku)
        );
        $r = $this->query($sql);
        $product_id = $r->fetchColumn();
        $r->closeCursor();

        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($product_id);

        return $product;
    }

    function newProduct($id = null)
    {
        $product = new Elite_Vaf_Model_Catalog_Product;
        if (!is_null($id)) {
            $product->setId($id);
        }
        return $product;
    }

    function newWheelProduct($id = null)
    {
        $product = new Elite_Vafwheel_Model_Catalog_Product($this->newProduct($id));
        return $product;
    }

    function newWheelAdapterProduct($id = null)
    {
        $product = new Elite_Vafwheeladapter_Model_Catalog_Product($this->newProduct($id));
        return $product;
    }

    function newTireProduct($id = null, $tireSize = null, $tireType = null)
    {
        $tireProduct = new Elite_Vaftire_Model_Catalog_Product($this->newProduct($id));
        if (!is_null($tireSize)) {
            $tireProduct->setTireSize($tireSize);
        }
        if (!is_null($tireType)) {
            $tireProduct->setTireType($tireType);
        }
        return $tireProduct;
    }

    /** @return Elite_Vaftire_Model_FlexibleSearch */
    function flexibleTireSearch($requestParams = array())
    {
        $this->setRequestParams($requestParams);

        $flexibleSearch = new VF_FlexibleSearch(new VF_Schema(), $this->getRequest($requestParams));
        $tireFlexibleSearch = new Elite_Vaftire_Model_FlexibleSearch($flexibleSearch);
        return $tireFlexibleSearch;
    }

    /** @return Elite_Vafwheeladapter_Model_FlexibleSearch */
    function flexibleWheeladapterSearch($requestParams = array())
    {
        $this->setRequestParams($requestParams);

        $flexibleSearch = new VF_FlexibleSearch(new VF_Schema(), $this->getRequest($requestParams));
        $tireFlexibleSearch = new Elite_Vafwheeladapter_Model_FlexibleSearch($flexibleSearch);
        return $tireFlexibleSearch;
    }

    function flexibleWheelSearch($requestParams = array())
    {
        if (count($requestParams)) {
            $this->setRequestParams($requestParams);
            $request = $this->getRequest($requestParams);
        } else {
            $request = Elite_Vaf_Singleton::getInstance()->getRequest();
        }

        $flexibleSearch = new VF_FlexibleSearch(new VF_Schema(), $request);
        $flexibleSearch = new Elite_Vafwheel_Model_FlexibleSearch($flexibleSearch);
        return $flexibleSearch;
    }

    function merge($slaveLevels, $masterLevel)
    {
        $merge = new Elite_Vaf_Model_Merge($slaveLevels, $masterLevel);
        $merge->execute();
    }

    function split($vehicle, $grain, $newTitles)
    {
        $split = new Elite_Vaf_Model_Split($vehicle, $grain, $newTitles);
        $split->execute();
    }

    function boltPattern($boltPatternString, $offset = null)
    {
        return Elite_Vafwheel_Model_BoltPattern::create($boltPatternString, $offset);
    }

    function wheelAdapterFinder()
    {
        return new Elite_Vafwheeladapter_Model_Finder;
    }

    function tireFinder()
    {
        return new Elite_Vaftire_Model_Finder;
    }

    function definitionsController($request = null)
    {
        if (is_null($request)) {
            $request = new Zend_Controller_Request_Http();
        }
        require_once(ELITE_PATH . '/Vaf/controllers/Admin/VehicleslistController.php');
        require_once(ELITE_PATH . '/Vaf/controllers/Admin/DefinitionsController/TestSubClass.php');
        $controller
            = new Elite_Vaf_Admin_DefinitionsController_TestSubClass($request, new Zend_Controller_Response_Http());
        return $controller;
    }

    function createTireMMY($make, $model, $year)
    {
        $vehicle = $this->createMMY($make, $model, $year);
        return new Elite_Vaftire_Model_Vehicle($vehicle);
    }

    protected function setRequest(Zend_Controller_Request_Abstract $request)
    {
        Elite_Vaf_Singleton::getInstance()->setRequest($request);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Singleton::getInstance()->getReadAdapter();
    }

    protected function getHelper($config = array(), $requestParams = array())
    {
        $request = $this->getRequest($requestParams);
        $helper = Elite_Vaf_Singleton::getInstance();
        $helper->setRequest($request);
        if (count($config)) {
            $helper->setConfig(new Zend_Config($config, true));
        }
        return $helper;
    }

    protected function request($controllerName = '', $routeName = '', $uri = false)
    {
        if ($uri) {
            $request = $this->getMock(
                'Mage_Core_Controller_Request_Http',
                array('getControllerName', 'getRouteName'),
                array($uri),
                '',
                true,
                false
            );
        } else {
            $request = $this->getMock(
                'Mage_Core_Controller_Request_Http',
                array('getControllerName', 'getRouteName'),
                array(),
                '',
                false,
                false
            );
        }
        $request->expects($this->any())->method('getControllerName')->will($this->returnValue($controllerName));
        $request->expects($this->any())->method('getRouteName')->will($this->returnValue($routeName));
        return $request;
    }

}

class Elite_Vaf_Model_TestSubClass extends VF_Level
{

    function getLevels()
    {
        return array('make', 'model', 'year');
    }

    function getNextLevel()
    {
        return '';
    }

    function getPrevLevel()
    {
        return '';
    }

    function getLeafLevel()
    {
        return 'year';
    }

    function createEntity($level, $id = 0)
    {
        switch ($level) {
            case 'make':
                return new Elite_Vaf_Model_TestSubClass_Make($level, $id);
                break;
            case 'model':
                return new Elite_Vaf_Model_TestSubClass_Model($level, $id);
                break;
            case 'year':
                return new Elite_Vaf_Model_TestSubClass_Year($level, $id);
                break;
        }
        return new VF_Level($level, $id);
    }

}