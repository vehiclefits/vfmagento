<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_TestCase extends Elite_Vafsitemap_Model_Url_RewriteTests_TestCase
{
	function rewrite( Zend_Controller_Request_Http $request = null )
    {
		$rewrite = new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
		if(is_null($request))
		{
			$request = new  Zend_Controller_Request_HttpTestCase();
		}
		return $rewrite->rewrite( $request, new Zend_Controller_Response_Http() );
    }
}