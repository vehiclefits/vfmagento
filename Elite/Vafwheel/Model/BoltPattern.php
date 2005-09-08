<?php
class Elite_Vafwheel_Model_BoltPattern
{
    /**
    * SINGLE FORMAT
    * Lug Count x Bolt Distance 
    * ex. 5 x 135
    * 5 lug nuts, 135mm distance
    * 
    * DUAL FORMAT
    * Total Lug Count x bolt distance A / bolt distance B
    * ex. 10 x 100/114.3  
    * dual bolt pattern, if string contains slash, lug nut count should be divided by 2 ( represents total count ). Slash seperates distance
    * So this would be either 5 lug 100mm or 5 lug 114.3 ( wheel fits both )
    * 
    * All distances in mm
    */
    public static function create( $formattedString, $offset=null )
    {
        if( strpos( $formattedString, '/' ) )
        {
            $dual = new Elite_Vafwheel_Model_BoltPattern_Dual( $formattedString );
            return $dual->getPatterns();
        }
        else
        {
            return new Elite_Vafwheel_Model_BoltPattern_Single( $formattedString, $offset );
        }        
        
    }
    
    function createFromValues( $lug_count, $bolt_distance )
    {
        return new Elite_Vafwheel_Model_BoltPattern_Single( $lug_count . 'x' . $bolt_distance) ;
    }
    
}