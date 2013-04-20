<?php

abstract class Elite_Vafsitemap_Model_Url_RewriteTests_TestCase extends Elite_Vaf_TestCase
{

    function getSEORequest($uri)
    {
	$request = new Zend_Controller_Request_Http($uri);
	$request->setPathInfo($uri);
	return $request;
    }

}