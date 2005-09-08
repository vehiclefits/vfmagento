<?php
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
        return $this->getOffset();
    }
    
    function offsetMax()
    {
        return $this->getOffset();
    }
    
    function __toString()
    {
        return $this->getLugCount().'x'.$this->getDistance();
    }
    
}