<?php
/**
 * Vehicle Fits (http://www.vehiclefits.com for more information.)
 * @copyright  Copyright (c) Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class Elite_Vaf_Block_SearchTestCase extends VF_TestCase
{
    protected function getBlockWithChooserConfig($configArray)
    {
        return $this->getBlock(array('categorychooser' => $configArray));
    }

    protected function getBlockWithSearchConfig($configArray)
    {
        return $this->getBlock(array('search' => $configArray));
    }

    protected function getBlock($configArray = null, $requestParams = array())
    {
        $search = $this->doGetBlock();
        if (is_array($configArray)) {
            $search->setConfig(new Zend_Config($configArray));
        }
        VF_Singleton::getInstance()->setRequest($this->getRequest($requestParams));
        return $search;
    }

    protected function doGetBlock()
    {
        return new Elite_Vaf_Block_Search();
    }

    function getMagentoRequest($params = array())
    {
        $request = $this->getMock('Mage_Core_Controller_Request_Http', array(), array(), '', false);
        foreach ($params as $key => $val) {
            $cmd = 'get' . ucfirst($key);
            $request->expects($this->any())->method($cmd)->will($this->returnValue($val));
        }
        return $request;
    }

    // @todo curently if it is anything but product & catalog, for the controller & route name, it detects it as homepage
    protected function emulateHomepage($search)
    {
        VF_Singleton::getInstance()->setRequest($this->getMagentoRequest(array('controllerName' => 'index', 'routeName' => 'cms')));
    }

    protected function emulateNotHomepage($search)
    {
        VF_Singleton::getInstance()->setRequest($this->getMagentoRequest(array('controllerName' => 'category', 'routeName' => 'catalog')));
    }

}