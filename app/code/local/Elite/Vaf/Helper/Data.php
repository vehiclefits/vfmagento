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

/**
 * Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
 * PROFESSIONAL IDENTIFICATION:
 * "www.vehiclefits.com"
 * PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
 * "Automotive Ecommerce Provided By Vehicle Fits llc"
 *
 * All Rights Reserved
 * VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the conditions in license.txt are met
 */
class Elite_Vaf_Helper_Data extends Mage_Core_Helper_Abstract implements VF_Configurable
{

    /**  @var Zend_Config */
    protected $config;
    static $dbAdapter;
    protected $productIds;

    /** @return Elite_Vaf_Helper_Data */
    static function getInstance($new = false) // test only
    {
        static $instance;
        if (is_null($instance) || $new) {
            $instance = new Elite_Vaf_Helper_Data;
        }
        return $instance;
    }

    function reset()
    {
        unset($this->productIds);
    }

    function getConfig()
    {
        if (!$this->config instanceof Zend_Config) {
            if(file_exists(ELITE_CONFIG)) {
                $config = new Zend_Config_Ini(ELITE_CONFIG, null, true);
            } else {
                $config = new Zend_Config_Ini(ELITE_CONFIG_DEFAULT, null, true);
            }
            $this->setConfig($config);
        }
        return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
        $this->ensureDefaultSectionsExist($config);
        $this->config = $config;
    }

    /**
     * store paramaters in the session
     * @return integer fit_id
     */
    function storeFitInSession()
    {
        $search = $this->flexibleSearch();
        $mapping_id = $search->storeFitInSession();

        if (file_exists(ELITE_PATH . '/Vaftire')) {
            $tireSearch = new Elite_Vaftire_Model_FlexibleSearch($search);
            $tireSearch->storeTireSizeInSession();
        }
        if (file_exists(ELITE_PATH . '/Vafwheel')) {
            $wheelSearch = new Elite_Vafwheel_Model_FlexibleSearch($search);
            $wheelSearch->storeSizeInSession();
        }
        if (file_exists(ELITE_PATH . '/Vafwheeladapter')) {
            $wheeladapterSearch = new Elite_Vafwheeladapter_Model_FlexibleSearch($search);
            $wheeladapterSearch->storeAdapterSizeInSession();
        }
        return $mapping_id;
    }

    function clearSelection()
    {
        $this->flexibleSearch()->clearSelection();
    }

    function getLeafLevel()
    {
        $schema = new VF_Schema();
        return $schema->getLeafLevel();
    }

    function getValueForSelectedLevel($level)
    {
        $search = new VF_FlexibleSearch($this->schema(), $this->getRequest());
        $search->storeFitInSession();
        return $search->getValueForSelectedLevel($level);
    }

    function getFitId()
    {
        return $this->getValueForSelectedLevel($this->getLeafLevel());
    }

    protected function hasAValidSessionRequest()
    {
        return isset($_SESSION[$this->getLeafLevel()]) && $_SESSION[$this->getLeafLevel()];
    }

    /** @return Zend_Controller_Request_Abstract */
    function getRequest()
    {
        // for testing
        if ($this->_request instanceof Zend_Controller_Request_Abstract) {
            return $this->_request;
        }
        if (defined('ELITE_TESTING')) {
            return;
        }
        // magento specific code
        if ($controller = Mage::app()->getFrontController()) {
            $this->_request = $controller->getRequest();
        } else {
            throw new Exception(Mage::helper('core')->__("Can't retrieve request object"));
        }
        return $this->_request;
    }

    /** for testability */
    function setRequest($request)
    {
        $this->_request = $request;
    }

    function vehicleSelection()
    {
        $this->storeFitInSession();
        $search = $this->flexibleSearch();
        return $search->vehicleSelection();
    }

    function getProductIds()
    {
        if (isset($this->productIds) && is_array($this->productIds) && count($this->productIds)) {
            return $this->productIds;
        }
        $ids = $this->doGetProductIds();
        $this->productIds = $ids;
        return $ids;
    }

    protected function doGetProductIds()
    {
        $this->storeFitInSession();
        $productIds = $this->flexibleSearch()->doGetProductIds();
        return $productIds;
    }

    /** Get the option loading text for the ajax */
    function getLoadingText()
    {
        return isset($this->getConfig()->search->loadingText) ? $this->getConfig()->search->loadingText : 'loading';
    }

    /** Get the option text prompting the user to make a selection */
    function getDefaultSearchOptionText($level = null, $config = null)
    {
        if (is_null($config)) {
            $config = $this->getConfig();
        }
        $text = trim($config->search->defaultText);
        if (empty($text)) {
            $text = '-please select-';
        }
        $text = sprintf($text, ucfirst($level));
        return $text;
    }

    function showSearchButton()
    {
        $block = new Elite_Vaf_Block_Search();
        $block->setConfig($this->getConfig());
        return $block->showSearchButton();
    }

    /** @return boolean wether or not to prefix select boxes with a label */
    function showLabels()
    {
        if (isset($this->getConfig()->search->labels)) {
            return $this->getConfig()->search->labels;
        }
        return true;
    }

    function ensureDefaultSectionsExist($config)
    {
        $this->ensureSectionExists($config, 'category');
        $this->ensureSectionExists($config, 'categorychooser');
        $this->ensureSectionExists($config, 'mygarage');
        $this->ensureSectionExists($config, 'homepagesearch');
        $this->ensureSectionExists($config, 'search');
        $this->ensureSectionExists($config, 'seo');
        $this->ensureSectionExists($config, 'product');
        $this->ensureSectionExists($config, 'logo');
        $this->ensureSectionExists($config, 'directory');
        $this->ensureSectionExists($config, 'importer');
        $this->ensureSectionExists($config, 'tire');
    }

    function ensureSectionExists($config, $section)
    {
        if (!is_object($config->$section)) {
            $config->$section = new Zend_Config(array());
        }
    }

    /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        if (isset(self::$dbAdapter)) return self::$dbAdapter;

        // cron
        if (Zend_Registry::isRegistered('db')) {
            return Zend_Registry::get('db');
        }

        // test code only
        if (defined('ELITE_TESTING')) {
            if (is_null(self::$dbAdapter)) {

                self::$dbAdapter = new My_Adapter(array('dbname' => VAF_DB_NAME, 'username' => VAF_DB_USERNAME, 'password' => VAF_DB_PASSWORD));
                self::$dbAdapter->getConnection()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

                self::$dbAdapter->getConnection()->query('SET character set utf8;');
                self::$dbAdapter->getConnection()->query('SET character_set_client = utf8;');
                self::$dbAdapter->getConnection()->query('SET character_set_results = utf8;');
                self::$dbAdapter->getConnection()->query('SET character_set_connection = utf8;');
                self::$dbAdapter->getConnection()->query('SET character_set_database = utf8;');
                self::$dbAdapter->getConnection()->query('SET character_set_server = utf8;');
            }
            return self::$dbAdapter;
        }
        // end 'test code only'

        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $read->query('SET character_set_client = utf8;');


        $config = $read->getConfig();

        self::$dbAdapter = new My_Adapter($config);
        self::$dbAdapter->getConnection()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        self::$dbAdapter->getConnection()->query('SET character set utf8;');
        self::$dbAdapter->getConnection()->query('SET character_set_client = utf8;');
        self::$dbAdapter->getConnection()->query('SET character_set_results = utf8;');
        self::$dbAdapter->getConnection()->query('SET character_set_connection = utf8;');
        self::$dbAdapter->getConnection()->query('SET character_set_database = utf8;');
        self::$dbAdapter->getConnection()->query('SET character_set_server = utf8;');

        return self::$dbAdapter;
    }

    function displayBrTag()
    {
        if (is_null($this->getConfig()->search->insertBrTag)) {
            return true;
        }
        return $this->getConfig()->search->insertBrTag;
    }

    function enableDirectory()
    {
        if (!is_null($this->getConfig()->directory->enable) && $this->getConfig()->directory->enable) {
            return true;
        }
        return false;
    }

    function schema()
    {
        $schema = new VF_Schema();
        return $schema;
    }

    /** @return VF_FlexibleSearch */
    function flexibleSearch()
    {
        $search = new VF_FlexibleSearch($this->schema(), $this->getRequest());
        $search->setConfig($this->getConfig());

        if (file_exists(ELITE_PATH . '/Vafwheel')) {
            $search = new Elite_Vafwheel_Model_FlexibleSearch($search);
        }

        if (file_exists(ELITE_PATH . '/Vaftire')) {
            $search = new Elite_Vaftire_Model_FlexibleSearch($search);
        }

        if (file_exists(ELITE_PATH . '/Vafwheeladapter')) {
            $search = new Elite_Vafwheeladapter_Model_FlexibleSearch($search);
        }

        return $search;
    }

    function getBaseUrl($https = null)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, $https);
    }

    function processUrl()
    {
        return $this->getBaseUrl(isset($_SERVER['HTTPS'])) . '/vaf/ajax/process?';
    }

    function homepageSearchURL()
    {
        return $this->getBaseUrl(isset($_SERVER['HTTPS'])) . '/vaf/product/list?';
    }

}

/** Test only DB Adapter for emulating transaction nesting in MYSQL */
class My_Adapter extends Zend_Db_Adapter_Pdo_Mysql
{

    /**
     * Keeps track of transaction nest level, to emulate mysql support, -1 meaning no transaction
     * has begun, 0 meaning there is no nesting, 1 meaning there are 2 transactions, ad infintum
     *
     * @var integer
     */
    public $_transaction_depth = -1;
    protected $_should_emulate_nesting = true;

    function beginTransaction()
    {
        $this->_transaction_depth++;
        if ($this->_transaction_depth > 0) {
            return;
        }
        return parent::beginTransaction();
    }

    function commit()
    {
        $this->_transaction_depth--;
        if ($this->shouldEmulateNesting()) {
            return;
        }
        return parent::commit();
    }

    function rollBack()
    {
        $this->_transaction_depth--;
        if ($this->shouldEmulateNesting()) {
            return;
        }
        return parent::rollBack();
    }

    protected function shouldEmulateNesting()
    {
        return $this->_should_emulate_nesting && $this->isNested();
    }

    protected function isNested()
    {
        return $this->_transaction_depth >= 0;
    }

    function __call($methodName, $arguments)
    {
        $method = array($this->wrapped, $methodName);
        return call_user_func_array($method, $arguments);
    }
}
