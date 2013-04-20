<?php

abstract class Elite_Vaf_Helper_DataTestCase extends Elite_Vaf_TestCase
{

    protected function rand()
    {
	return 5;
    }

    protected function getHelper($config = array(), $requestParams = array())
    {
	$request = $this->getRequest($requestParams);
	$helper = Elite_Vaf_Helper_Data::getInstance();
	$helper->reset();
	$helper->setRequest($request);
	if (count($config))
	{
	    $helper->setConfig(new Zend_Config($config, true));
	}
	return $helper;
    }

}