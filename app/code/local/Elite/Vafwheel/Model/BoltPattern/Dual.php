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
class Elite_Vafwheel_Model_BoltPattern_Dual  extends Elite_Vafwheel_Model_BoltPattern 
{
    /** @var Elite_Vafwheel_Model_BoltPattern */
    protected $left, $right;
    
    /**
    * DUAL FORMAT
    * Total Lug Count x bolt distance A / bolt distance B
    * ex. 10 x 100/114.3  
    * dual bolt pattern, if string contains slash, lug nut count should be divided by 2 ( represents total count ). Slash seperates distance
    * So this would be either 5 lug 100mm or 5 lug 114.3 ( wheel fits both )
    */
    function __construct( $formattedString )
    {
        $array = preg_split( '#x#', $formattedString, 2 );        
        for( $i=0; $i<=1; $i++ )
        {
            $array[ $i ] = trim( $array[ $i ] );
        }
        $lug_count = $array[ 0 ];
        $bolt_distance = $array[ 1];
        
        if( $lug_count % 2 != 0 )
        {
            throw new Exception( 'dual bolt pattern but odd # lug count' );
        }
        $lug_count = $lug_count / 2;
        
        $bolt_distance = preg_split( '#/#', $bolt_distance );
        
        $this->left = Elite_Vafwheel_Model_BoltPattern::createFromValues( $lug_count, $bolt_distance[0] );
        $this->right = Elite_Vafwheel_Model_BoltPattern::createFromValues( $lug_count, $bolt_distance[1] );
        
    }
    
    function getPatterns()
    {
        return array( $this->left, $this->right ); 
    }
}