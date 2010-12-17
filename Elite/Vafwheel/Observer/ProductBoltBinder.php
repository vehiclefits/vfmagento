<?php
class Elite_Vafwheel_Observer_ProductBoltBinder
{
    function addBoltPatterns( $event )
    {
        $this->doAddBoltPatterns( $event->controller,  $event->product );
    }
    
    /**
    * @param Varien_Controller_Action
    * @param Mage_Catalog_Model_Product
    */
    protected function doAddBoltPatterns( $controller,  Elite_Vaf_Model_Catalog_Product $product )
    {
        $wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
        $wheelProduct->removeBoltPatterns();
        
        /** @todo get under test */
        if( isset($_FILES['boltpatterncsv']) && $_FILES['boltpatterncsv']['tmp_name'] && $_FILES['boltpatterncsv']['error'] == 0 )
        {
            $importer = new Elite_Vafwheel_Model_Importer_Bolts( $_FILES['boltpatterncsv']['tmp_name'] ); 
            $importer->import();
        }
            
        $patterns = $controller->getRequest()->getParam( 'multipatterns' );
        $patterns = explode( "\n", $patterns );
        foreach( $patterns as $k => $pattern )
        {
            $pattern = str_replace( "\r", '', $pattern );
            if( !trim( $pattern ) )
            {
                return;
            }
            
            $boltPattern = Elite_Vafwheel_Model_BoltPattern::create( $pattern );
            if( !is_array( $boltPattern ) )
            {
                $boltPattern = array( $boltPattern );
            }
            foreach( $boltPattern as $each )
            {
                $wheelProduct->addBoltPattern( $each );
            }
        }
        
    }
}
