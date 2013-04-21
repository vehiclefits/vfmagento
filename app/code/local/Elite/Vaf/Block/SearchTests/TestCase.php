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
abstract class Elite_Vaf_Block_SearchTests_TestCase extends Elite_Vaf_TestCase
{
    protected function getBlockWithChooserConfig( $configArray )
    {
        return $this->getBlock( array( 'categorychooser' => $configArray ));
    }
    
    protected function getBlockWithSearchConfig( $configArray )
    {
        return $this->getBlock( array( 'search' => $configArray ));
    }
    
    protected function getBlock( $configArray = null, $requestParams = array() )
    {
        $search = $this->doGetBlock();
        if( is_array( $configArray ) )
        {
            $search->setConfig( new Zend_Config( $configArray ) );
        }
        $search->setRequest( $this->getRequest( $requestParams ) );
        return $search;
    }
    
    protected function doGetBlock()
    {
        return new Elite_Vaf_Block_Search();
    }
    
    function getRequest( $params = array() )
    {
        $request = $this->getMock( 'Mage_Core_Controller_Request_Http', array(), array(), '', false );
        foreach( $params as $key => $val )
        {
            $cmd = 'get' . ucfirst( $key );
            $request->expects( $this->any() )->method( $cmd )->will( $this->returnValue( $val ) );
        }
        return $request;
    }
    
    // @todo curently if it is anything but product & catalog, for the controller & route name, it detects it as homepage
    protected function emulateHomepage( $search )
    {
        $search->setRequest( $this->getRequest( array( 'controllerName' => 'index', 'routeName' => 'cms' ) ) ); 
    }
    
    protected function emulateNotHomepage( $search )
    {
        $search->setRequest( $this->getRequest( array( 'controllerName' => 'category', 'routeName' => 'catalog' ) ) );
    }
    
}