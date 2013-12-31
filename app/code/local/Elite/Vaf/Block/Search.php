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
 *
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vaf_Block_Search extends Elite_Vaf_Block_Abstract implements VF_Configurable
{
    /**
     * @var Elite_Vaf_Search_Mage
     */
    public $searchStrategy;

    /** @var  Zend_Controller_Request_Abstract */
    protected $request;

    function __construct()
    {
        $this->searchStrategy = new Elite_Vaf_Search_Mage();
    }

    /**
     * @return Elite_Vaf_Search_Mage
     */
    public function getSearchStrategy()
    {
        return $this->searchStrategy;
    }

    function url($route)
    {
        return Mage::getUrl($route);
    }

    function _toHtml()
    {
        if (!$this->searchStrategy->shouldShow($this->searchStrategy->currentCategoryId())) {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }

    function setTemplate($template)
    {
        $this->searchStrategy->setTemplate($template);
        parent::setTemplate($template);
        return $this;
    }

    function setRequest(Zend_Controller_Request_Abstract $request)
    {
        $this->request = $request;
        $this->searchStrategy->setRequest($request);
    }

    function getRequest()
    {
        return $this->searchStrategy->getRequest();
    }

    function getConfig()
    {
        return $this->searchStrategy->getConfig();
    }

    function setConfig(Zend_Config $config)
    {
        $this->searchStrategy->setConfig($config);
    }
}
