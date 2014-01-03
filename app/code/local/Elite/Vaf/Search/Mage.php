<?php


class Elite_Vaf_Search_Mage extends VF_SearchForm
{
    /** @var array of category ids we are searching */
    protected $categories;

    /** @var Elite_Vaf_Block_Search_CategoryChooser */
    protected $chooser;

    /** @var Elite_Vaf_Model_Catalog_Category_Filter */
    protected $filter;

    protected $current_category_id;

    /** @var  Zend_Controller_Request_Abstract */
    protected $_request;

    function __construct()
    {
        $this->categories = (isset($_GET['category']) && is_array($_GET['category'])) ? $_GET['category'] : array(3);
        foreach ($this->categories as $index => $id) {
            $this->categories[$index] = (int)$id; // allow integers only
        }
        $this->chooser = new Elite_Vaf_Block_Search_CategoryChooser();
    }

    function getFilter()
    {
        if (!$this->filter instanceof Elite_Vaf_Model_Catalog_Category_Filter) {
            $this->filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
            $this->filter->setConfig($this->getConfig());
        }
        return $this->filter;
    }

    function setFilter(Elite_Vaf_Model_Catalog_Category_Filter $filter)
    {
        $this->filter = $filter;
    }

    function getSearchPostUrl()
    {
        return Mage::getUrl('vaf/results');
    }

    /** Just delegates for testability purposes */
    function getCategories()
    {
        $this->getChooser()->setConfig($this->getConfig());
        return $this->getChooser()->getFilteredCategories($this->getChooser()->getAllCategories());
    }

    /** Just delegates for testability purposes */
    function getFilteredCategories(array $categories)
    {
        $this->getChooser()->setConfig($this->getConfig());
        return $this->getChooser()->getFilteredCategories($categories);
    }

    protected function isHomepage()
    {
        return ('index' == $this->getRequest()->getControllerName() && 'cms' == $this->getRequest()->getRouteName());
    }

    protected function isCmsPage()
    {
        return ('page' == $this->getRequest()->getControllerName() && 'cms' == $this->getRequest()->getRouteName());
    }

    protected function isProductPage()
    {
        if ('product' == $this->getRequest()->getControllerName()) {
            return true;
        }
        return false;
    }

    protected function isCategoryPage()
    {
        if ('category' == $this->getRequest()->getControllerName()) {
            return true;
        }
        return false;
    }

    protected function isVafPage()
    {
        if ('vaf' == $this->getRequest()->getModuleName()) {
            return true;
        }
        return false;
    }

    protected function isChooseVehiclePage()
    {
        if ('choosevehicle' == $this->getRequest()->getActionName()) {
            return true;
        }
        return false;
    }

    /** @return bool if vaf/categoryOnHomepage == true and it is the homepage, show the category chooser */
    function showCategoryChooser()
    {
        $this->getChooser()->setConfig($this->getConfig());
        if ($this->isHomepage()) {
            return $this->getChooser()->showCategoryChooserHomepage();
        } else {
            return $this->getChooser()->showCategoryChooserNonHomepage();
        }
    }

    /** @return bool if vaf/categoryOnHomepage == true and it is the homepage, show the category chooser */
    function showAllOptionOnCategoryChooser()
    {
        $this->getChooser()->setConfig($this->getConfig());
        if ($this->isHomepage()) {
            return $this->getChooser()->showAllOptionHomepage();
        } else {
            return $this->getChooser()->showAllOptionAllPages();
        }
    }

    function getCategoryChooserAllOptionText()
    {
        $setting = $this->getConfig()->categorychooser->allOptionText;
        if ($setting) {
            return $setting;
        }
        return 'All Categories';
    }

    function categoryAction($categoryId)
    {
        if (!$categoryId) {
            return;
        }
        $categoryIdsHomepage = explode(',', $this->getConfig()->search->categoriesThatSubmitToHomepage);
        $categoryIdsRefresh = explode(',', $this->getConfig()->search->categoriesThatRefresh);
        if (in_array($categoryId, $categoryIdsHomepage)) {
            return $this->url('vaf/product/list');
        }
        if (in_array($categoryId, $categoryIdsRefresh)) {
            return '?';
        }
    }

    function action()
    {
        if ($this->categoryAction($this->currentCategoryId())) {
            return $this->categoryAction($this->currentCategoryId());
        }
        $submitAction = $this->getConfig()->search->submitAction;
        $submitOnCategoryAction = $this->getConfig()->search->submitOnCategoryAction;
        $submitOnProductAction = $this->getConfig()->search->submitOnProductAction;
        $submitOnHomepageAction = $this->getConfig()->search->submitOnHomepageAction;
        if ($this->getConfig()->category->disable) {
            return $this->url('vaf/product/list');
        }
        if ($this->isCategoryPage()) {
            if ($submitOnCategoryAction) {
                return $submitOnCategoryAction;
            }
            return '?';
        }
        if ($this->isCmsPage() || ('' != $submitAction && '' == $submitOnProductAction && '' == $submitOnHomepageAction)) {
            if ('refresh' == $submitAction) {
                return '?';
            }
            if ('homepagesearch' == $submitAction) {
                return $this->url('vaf/product/list');
            }
            return $submitAction;
        }
        if ('' == $submitAction && '' == $submitOnProductAction && '' == $submitOnHomepageAction) {
            return $this->url('vaf/product/list');
        }
        if ($this->isProductPage()) {
            if ('' == $submitOnProductAction && '' != $submitAction) {
                return $submitAction;
            }
            if ('refresh' == $submitOnProductAction) {
                return '?';
            }
            if ('homepagesearch' == $submitOnProductAction) {
                return $this->url('vaf/product/list');
            }
            return $submitOnProductAction;
        }
        if ($this->isHomepage()) {
            if ('' == $submitOnHomepageAction && '' != $submitAction) {
                return $submitAction;
            }
            if ('refresh' == $submitOnHomepageAction) {
                return '?';
            }
            if ('homepagesearch' == $submitOnHomepageAction) {
                return $this->url('vaf/product/list');
            }
            return $submitOnHomepageAction;
        }
    }


    function setCurrentCategoryId($id)
    {
        $this->current_category_id = $id;
    }

    function shouldShow($categoryId)
    {
        if ($this->isChooseVehiclePage()) {
            return false;
        }
        if (VF_Singleton::getInstance()->getConfig()->category->disable && !$this->isHomepage() && !$this->isVafPage()) {
            return false;
        }
        if (!$this->getTemplate()) {
            return false;
        }
        if (!$this->categoryEnabled($categoryId)) {
            return false;
        }
        return true;
    }

    function categoryEnabled($categoryId)
    {
        if (!$categoryId) {
            return true;
        }
        return $this->getFilter()->shouldShow($categoryId);
    }

    function getHeaderText()
    {
        return $this->translate('Search By Vehicle');
    }


    /** @return Elite_Vaf_Block_Search_CategoryChooser */
    function getChooser()
    {
        return $this->chooser;
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