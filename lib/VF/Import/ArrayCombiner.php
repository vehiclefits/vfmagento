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
class VF_Import_ArrayCombiner
{
    protected $traits;         
    protected $allCombinations = array(array());         
    
    function setTraits( $traits )
    {
        $this->traits = $traits;
    }
    
    function getCombinations()  {
        
        foreach( $this->keys() as $key )
        {
            foreach($this->allCombinations as $previousCombination )
            {    
                foreach( $this->traits[$key] as $value )
                {
                    $currentCombination = $previousCombination;
                    $currentCombination[$key] = $value;
                    $this->addCombination($currentCombination);
                }   
            }      
        }
        $this->removePartials();
        return array_values($this->allCombinations);
    }
    
    function keys()
    {
        return array_keys( $this->traits );
    }
    
    function valueAtIndex($key,$i)
    {
        return $this->traits[$key][$i];
    }
    
    function valueCount($key)
    {
        return count( $this->traits[$key] );
    }
    
    function addCombination($combination)
    {
        if( !$this->hasComination($combination) )
        {
            array_push($this->allCombinations,$combination);
        }
    }
    
    function hasComination( $compare )
    {
        foreach( $this->allCombinations as $combination )
        {
             if( $compare ===  $combination )
             {
                 return true;
             }
        }
        return false;
    }
    
    function removePartials()
    {
        foreach($this->allCombinations as $key => $combination)
        {
            if($this->isPartial($combination))
            {
                unset($this->allCombinations[$key]);
            }
        }
    }
    
    function isPartial($combination)
    {
        return( count($combination) != count($this->keys()) );
    }
}