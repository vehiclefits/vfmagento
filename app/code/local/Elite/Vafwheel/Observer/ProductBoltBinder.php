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
        $VFproduct = new VF_Product();
        $VFproduct->setId($product->getId());

        $wheelProduct = new VF_Wheel_Catalog_Product($VFproduct);
        $wheelProduct->removeBoltPatterns();
        
        /** @todo get under test */
        if( isset($_FILES['boltpatterncsv']) && $_FILES['boltpatterncsv']['tmp_name'] && $_FILES['boltpatterncsv']['error'] == 0 )
        {
            $importer = new VF_Wheel_Catalog_Product_Import( $_FILES['boltpatterncsv']['tmp_name'] );
            $importer->import();
        }
        else
        {
            
            $patterns = $controller->getRequest()->getParam( 'wheel_side_pattern' ) ? $controller->getRequest()->getParam( 'wheel_side_pattern' ) : $controller->getRequest()->getParam( 'multipatterns' );
            $patterns = explode( "\n", $patterns );
            foreach( $patterns as $k => $pattern )
            {
                $pattern = str_replace( "\r", '', $pattern );
                if( !trim( $pattern ) )
                {
                    return;
                }

                $boltPattern = VF_Wheel_BoltPattern::create( $pattern );
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
}
