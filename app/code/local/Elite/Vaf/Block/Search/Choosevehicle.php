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

class Elite_Vaf_Block_Search_Choosevehicle extends Elite_Vaf_Block_Search
{
    protected $product_id;
    
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('vf/vaf/search.phtml');
    }
	
    function action()
    {
        return '?';
    }
    
    function _toHtml()
    {
        if (!$this->getTemplate()) {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }
    
    function getHeaderText()
    {
        return 'Choose your Vehicle';
    }
    
    function showClearButton()
    {
        return false;
    }
    
    function getSubmitText()
    {
        return 'Choose';
    }
    
    function listEntities( $level )
    {
        if($level != $this->getSchema()->getRootLevel() )
        {
            return array();
        }
        $entity = new VF_Level( $level );
        return $entity->listInUse( $this->getRequestLevels(), $this->getProductId() );           
    }
    
    function setProductId( $product_id )
    {
        $this->product_id = $product_id;
    }
    
    function getProductId()
    {
        return $this->product_id;
    }
    
    function showCategoryChooser()
    {
        return false;
    }
    
    function showSubmitButton()
    {
        return true;
    }
    
    function getMethod()
    {
        return 'POST';
    }
    
    function formId()
    {
        return 'vafChooserForm';
    }

}
