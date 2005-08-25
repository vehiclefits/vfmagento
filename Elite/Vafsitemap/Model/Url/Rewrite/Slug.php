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
     * @return VF_Vehicle
     */
    function slugToVehicle($vehicleSlug)
    {
	return $this->findVehicle($vehicleSlug);
    }

    function findVehicle($vehicleSlug)
    {
	$levels = $this->levelsArray($vehicleSlug);
	$vehicle = $this->finder()->findOneByLevels($levels, VF_Vehicle_Finder::EXACT_ONLY);
	return $vehicle;
    }

    function levelsArray($vehicleSlug)
    {
	$vehicleSlug = explode('~', $vehicleSlug);
	$levels = array();
	foreach ($this->levels() as $level)
	{
	    $levels[$level] = urldecode(current($vehicleSlug));
	    next($vehicleSlug);
	}

	return $levels;
    }

    function levels()
    {
	return $this->getSchema()->getRewriteLevels();
    }

    function getSchema()
    {
	$schema = new VF_Schema;
	if(!is_null($this->getConfig()))
	{
	    $schema->setConfig($this->getConfig());
	}
	return $schema;
    }

    function finder()
    {
	return new VF_Vehicle_Finder(new VF_Schema());
    }

}