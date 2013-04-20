<?php
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