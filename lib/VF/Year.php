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
class VF_Year extends VF_Year_Abstract
{
    protected $year;
    
    function __construct($year)
    {
        $this->year = $year;
    }
    
    function isValid()
    {
        if(!is_numeric($this->year))
        {
            return false;
        }
        if(strlen($this->year) == 2 || strlen($this->year) == 4)
        {
            return true;
        }
        return false;
    }
    
    function value()
    {
        if(!$this->isValid())
        {
            throw new VF_Year_Exception('Trying to work with invalid year [' . $this->year . ']');
        }
        
        if(strlen($this->year) != 2 || !$this->Y2KMode )
        {
            return $this->year;
        }
        if( $this->year < $this->threshold)
        {
            $this->year = '20' . $this->year;
        }
        else
        {
            $this->year = '19' . $this->year;
        }
        return $this->year;
    }
}