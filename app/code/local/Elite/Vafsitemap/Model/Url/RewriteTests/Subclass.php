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
class Elite_Vafsitemap_Model_Url_RewriteTests_Subclass extends Elite_Vafsitemap_Model_Url_Rewrite
{
    protected $id;
    
    function rewrite(Zend_Controller_Request_Http $request=null, Zend_Controller_Response_Http $response=null)
    {            
        return parent::rewrite($request,$response);
    }
    
    function getStoreId()
    {
        return 1;
    }
    
    function setId($id)
    {
        $this->id = $id;
    }
    
    function getId()
    {
        return $this->id;
    }
    
    function load($id, $field=null)
    {
        if( 'test.html' == $id && 'request_path' == $field )
        {
            $this->setId(1);
        }
    }
    
    function getTargetPath()
    {
        return '/catalog/product/view/id/1';
    }
    
}