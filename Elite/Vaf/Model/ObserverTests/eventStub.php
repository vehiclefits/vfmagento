<?php
class Elite_Vaf_Model_ObserverTests_eventStub
{
    protected $controller;

    function __construct()
    {
        $this->controller = new Elite_Vaf_Model_ObserverTests_controllerStub;
    }

    function getControllerAction()
    {
        return $this->controller;
    }
}

