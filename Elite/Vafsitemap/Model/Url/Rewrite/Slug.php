<?php
class Vafsitemap_Model_Url_Rewrite_Slug
{
	/**
    * @param string vehicle slug string "honda~civic~2002"
    * @return Elite_Vaf_Model_Vehicle
    */
    function slugToVehicle($vehicleSlug)
    {
        return $this->findVehicle($vehicleSlug);
    }
    
    function findVehicle($vehicleSlug)
    {
		$levels = $this->levelsArray($vehicleSlug);
        return $this->finder()->findOneByLevels($levels);
    }
    
    function levelsArray($vehicleSlug)
    {
		$vehicleSlug = explode('~',$vehicleSlug);
		$levels = array();
        foreach($this->getSchema()->getLevels() as $level)
        {
            $levels[$level] = current($vehicleSlug);
            next($vehicleSlug);
        }
        return $levels;
    }
    
    function getSchema()
    {
        return new Elite_Vaf_Model_Schema;
    }
    
    function finder()
    {
		return new Elite_Vaf_Model_Vehicle_Finder( new Elite_Vaf_Model_Schema() );
    }
}