<?php

class Vafsitemap_Model_Url_Rewrite_Slug
{
    protected $config;
    
    function setConfig($config)
    {
	$this->config = $config;
    }
    
    function getConfig()
    {
	return $this->config;
    }
    
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
	$vehicle = $this->finder()->findOneByLevels($levels, true);
	return $vehicle;
    }

    function levelsArray($vehicleSlug)
    {
	$vehicleSlug = explode('~', $vehicleSlug);
	$levels = array();
	foreach ($this->levels() as $level)
	{
	    $levels[$level] = current($vehicleSlug);
	    next($vehicleSlug);
	}
	return $levels;
    }

    function levels()
    {
	if($this->getConfig())
	{
	    $rewriteLevels = $this->getConfig()->seo->rewriteLevels;
	    if ($rewriteLevels)
	    {
		$rewriteLevels = explode(',', $rewriteLevels);
		return $rewriteLevels;
	    }
	}
	return $this->getSchema()->getLevels();
    }

    function getSchema()
    {
	return new Elite_Vaf_Model_Schema;
    }

    function finder()
    {
	return new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
    }

}