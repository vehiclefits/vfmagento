<?php


class Elite_Vaf_Search_Mage extends VF_Search
{
    /** @var array of category ids we are searching */
    protected $categories;

    /** @var Elite_Vaf_Block_Search_CategoryChooser */
    protected $chooser;

    /** @var Elite_Vaf_Model_Catalog_Category_Filter */
    protected $filter;

    protected $current_category_id;

    function __construct()
    {
        $this->categories = (isset($_GET['category']) && is_array($_GET['category'])) ? $_GET['category'] : array(3);
        foreach ($this->categories as $index => $id) {
            $this->categories[$index] = (int)$id; // allow integers only
        }
        $this->chooser = new Elite_Vaf_Block_Search_CategoryChooser();
    }

    function translate($text)
    {
        if (defined('ELITE_TESTING')) {
            return $text;
        }
        return Mage::helper('catalog/product')->__($text);
    }

    function currentCategoryId()
    {
        if (!$this->isCategoryPage()) {
            return 0;
        }
        if (isset($this->current_category_id)) {
            return $this->current_category_id;
        }
        $category = Mage::registry('current_category');
        $categoryId = is_object($category) ? $category->getId() : 0;
        $this->setCurrentCategoryId($categoryId);
        return $categoryId;
    }

    /**
     * Retrieve request object
     *
     * @return Mage_Core_Controller_Request_Http
     */
    function getRequest()
    {
        if ($this->_request instanceof Zend_Controller_Request_Abstract
            || $this->_request instanceof Mage_Core_Controller_Request_Http
        ) {
            return $this->_request;
        }
        $this->_request = VF_Singleton::getInstance()->getRequest();
        return $this->_request;
    }

    function url($route)
    {
        return Mage::getUrl($route);
    }
} 