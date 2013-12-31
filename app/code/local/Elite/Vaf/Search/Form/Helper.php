<?php


class Elite_Vaf_Search_Form_Helper implements VF_Configurable {

    /** @var Zend_Controller_Request_Http */
    protected $_request;

    /** @var Zend_Config */
    protected $config;



    function getConfig()
    {
        if (!$this->config instanceof Zend_Config) {
            $this->config = VF_Singleton::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
        $this->config = $config;
    }

    function getRequest()
    {
        return $this->_request;
    }

    /** for testability */
    function setRequest($request)
    {
        $this->_request = $request;
    }
} 