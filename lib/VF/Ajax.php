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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class VF_Ajax implements VF_Configurable
{
    protected $alphaNumeric;
    protected $schema;
    
    /** @var Zend_Config */
    protected $config;
    
    function execute( VF_Schema $schema, $alphaNumeric=false )
    {
        $this->alphaNumeric = $alphaNumeric;
        $this->schema = $schema;
        
        $levels = $schema->getLevels();
        $c = count( $levels );
        
        $levelFinder = new VF_Level_Finder();
        if( isset( $_GET['front'] ) )
        {
            $product = isset($_GET['product']) ? $_GET['product'] : null;
            if($alphaNumeric)
            {
                $children = $levelFinder->listInUseByTitle( new VF_Level($this->requestLevel()), $this->requestLevels(), $product );
            }
            else
            {
                $children = $levelFinder->listInUse( new VF_Level($this->requestLevel()), $this->requestLevels(), $product );
            }
        }
        else
        {
            $children = $levelFinder->listAll( $this->requestLevel(), $this->requestLevels() );
        }
        
        echo $this->renderChildren($children);
    }
    
    function requestLevel()
    {
        return $this->getRequest()->getParam('requestLevel');
    }
    
    function getValue( $level )
    {
        return isset( $_GET[ $level ] ) ? $_GET[ $level ] : null;
    }

    /** Get the option text prompting the user to make a selection */
    function getDefaultSearchOptionText($level=null)
    {
        if( !isset( $_GET['front'] ) )
        {
            return false;
        }
        return Elite_Vaf_Helper_Data::getInstance()->getDefaultSearchOptionText($level,$this->getConfig());
    }
    
    function renderChildren( $children )
    {
        ob_start();
        $label = $this->getDefaultSearchOptionText($this->requestLevel());
        if( count( $children ) > 1 && $label )
        {
            echo '<option value="0">' . $label . '</option>';
        }
        
        foreach( $children as $child )
        {
            if($this->alphaNumeric)
            {
                echo '<option value="' . $child->getTitle() . '">' . htmlentities( $child->getTitle(), ENT_QUOTES, 'UTF-8' ) . '</option>';
            }
            else
            {
                echo '<option value="' . $child->getId() . '">' . htmlentities( $child->getTitle(), ENT_QUOTES, 'UTF-8' ) . '</option>';
            }
        }
        return ob_get_clean();
    }
    
    function requestLevels()
    {
        $params = array();
        foreach($this->schema()->getLevels() as $level)
        {
            if($this->getRequest()->getParam($level))
            {
                $params[$level] = $this->getRequest()->getParam($level);
            }
        }
        return $params;
    }
    
    function schema()
    {
        return $this->schema;
    }
    
    function getRequest()
    {
        return new Zend_Controller_Request_Http();
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }    
        return $this->config;
    }
    
    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }
}
