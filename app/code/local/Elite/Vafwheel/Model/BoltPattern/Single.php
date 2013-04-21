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
class Elite_Vafwheel_Model_BoltPattern_Single  extends Elite_Vafwheel_Model_BoltPattern 
{
    /** @var integer */
    protected $lug_count;
    
    /** @var float ( in millimeters ) */
    protected $bolt_distance;
    
    /** @var float OE offset */
    protected $offset;
    
    /**
    * SINGLE FORMAT
    * Lug Count x Bolt Distance 
    * ex. 5 x 135
    * 5 lug nuts, 135mm distance
    */
    function __construct( $formattedString, $offset=null )
    {
        $array = preg_split( '#x#i', $formattedString, 2 );        
        if( count( $array ) != 2 )
        {
            throw new Exception( 'Invalid formatting of bolt pattern [' . $formattedString . ']'  );
        }
        for( $i=0; $i<=1; $i++ )
        {
            $array[ $i ] = trim( $array[ $i ] );
        }
        $this->lug_count = $array[ 0 ];
        $this->bolt_distance = $array[ 1];
        $this->offset = $offset;
    }
    
    function getDistance()
    {
        return $this->bolt_distance;
    }
    
    function getLugCount()
    {
        return $this->lug_count;
    }
    
    function getOffset()
    {
        return $this->offset;
    }
    
    function offsetMin()
    {
        return $this->getOffset() - $this->offsetThreshold();
    }
    
    function offsetMax()
    {
        return $this->getOffset() + $this->offsetThreshold();
    }
    
    function offsetThreshold()
    {
        return 5;
    }
    
    function __toString()
    {
        return $this->getLugCount().'x'.$this->getDistance();
    }
    
}