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
class VF_Level_IdentityMap
{
    protected $levels = array();
    
    static function getInstance()
    {
        static $instance;
        if(is_null($instance))
        {
            $instance = new VF_Level_IdentityMap;
        }
        return $instance;
    }
    
    /** TEST ONLY */
    static function reset()
    {
        self::getInstance()->doReset();
    }
    
    /** TEST ONLY */
    function doReset()
    {
        $this->levels = array();
    }
    
    function add($level)
    {
        array_push($this->levels,$level);
    }
    
    function remove($level)
    {
        
    }
    
    function has($level,$id)
    {
        foreach($this->levels as $level)
        {
            if($level->getType() == $level && $level->getId() == $id )
            {
                return true;
            }
        }
        return false;
    }
    
    function get($level,$id)
    {
        foreach($this->levels as $level)
        {
            if($level->getType() == $level && $level->getId() == $id )
            {
                return $level;
            }
        }
    }
}