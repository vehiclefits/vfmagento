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
class VF_Year_Range extends VF_Year_Abstract
{
    protected $range;
    
    function __construct($range)
    {
        $this->range = $range;
    }
    
    function isValid()
    {
        $array = $this->asArray();
        if(1 != count($array) && 2 != count($array))
        {
            return false;
        }
        if( !$this->startIsValid() && !$this->endIsValid())
        {
            return false;
        }
        if( $this->startInput() && !$this->startIsValid() )
        {
            return false;
        }
        if( $this->endInput() && !$this->endIsValid() )
        {
            return false;
        }
        return true;
    }
    
    function startIsValid()
    {
         return $this->startYear()->isValid();
    }
        
    function endIsValid()
    {
         return $this->endYear()->isValid();
    }
    
    function start()
    {
        if(!$this->startIsValid() && $this->endIsValid())
        {
            return $this->end();
        }
        return $this->startYear()->value();
    }
    
    function end()
    {
        if(!$this->endIsValid() && $this->startIsValid())
        {
            return $this->start();
        }
        return $this->endYear()->value();
    }
    
    function startYear()
    {
        return $this->year($this->startInput());
    }
    
    function endYear()
    {
        return $this->year($this->endInput());
    }
    
    function year($input)
    {
        $year = new VF_Year($input);
        $year->setY2KMode($this->Y2KMode);
        $year->setThreshold($this->threshold);
        return $year;
    }
    
    function startInput()
    {
        $array = $this->asArray();
        return isset($array[0]) ? trim($array[0]) : null;
    }
    
    function endInput()
    {
        $array = $this->asArray();
        return isset($array[1]) ? trim($array[1]) : null;
    }
    
    function asArray()
    {
        return explode('-',$this->range);
    }
    
}