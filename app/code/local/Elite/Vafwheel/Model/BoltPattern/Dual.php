<?php
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