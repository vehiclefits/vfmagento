<?php
class Elite_Vaf_MockController
{
    function getRequest()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getRequest();
    }
}