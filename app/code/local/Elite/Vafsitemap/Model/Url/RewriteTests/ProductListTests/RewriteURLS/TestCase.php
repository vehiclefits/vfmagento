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
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_TestCase extends Elite_Vafsitemap_Model_Url_RewriteTests_TestCase
{

    function rewrite(Zend_Controller_Request_Http $request = null, $config = null)
    {
        $rewrite = new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
        if (is_null($request)) {
            $request = new Zend_Controller_Request_HttpTestCase();
        }
        if (!is_null($config)) {
            $rewrite->setConfig($config);
        }
        return $rewrite->rewrite($request, new Zend_Controller_Response_Http());
    }

}