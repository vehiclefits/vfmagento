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

class Elite_Vafsitemap_Model_Url_Rewrite_Slug
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
        $vehicle = $this->finder()->findOneByLevels($levels, VF_Vehicle_Finder::INCLUDE_PARTIALS);
        return $vehicle;
    }

    function levelsArray($vehicleSlug)
    {
        $vehicleSlug = explode('~', $vehicleSlug);
        $levels = array();
        foreach ($this->levels() as $level) {
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
        if (!is_null($this->getConfig())) {
            $schema->setConfig($this->getConfig());
        }
        return $schema;
    }

    function finder()
    {
        return new VF_Vehicle_Finder(new VF_Schema());
    }

}