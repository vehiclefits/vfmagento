<?php
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