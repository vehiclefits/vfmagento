<?php
class Elite_Vafsitemap_Model_DashBruteForce
{
    function bruteForce($input)
    {
        $input = $this->castArray($input);
        foreach($input as $eachInput)
        {
            if( false !== strpos($eachInput, '-'))
            {
                foreach($this->replacements($eachInput) as $addition)
                {
                    array_push($input, $addition);
                }
            }
        }
        return $input;
    }
    
    function replacements($inputString)
    {
        $return = array();
        $totalSlots = $this->numberOfSlots($inputString);
        array_push( $return, str_replace('-', ' ', $inputString)); // all slots replaced
        
        $inputStringAsArray = explode('-', $inputString);
        $slotCombinations = $this->slotCombinations($totalSlots);
        foreach($slotCombinations as $slotCombination )
        {
            print_r($inputStringAsArray);
            print_r($slotCombination);
        }
        return $return;
    }
    
    function castArray($input)
    {
        if(!is_array($input))
        {
            $input = array($input);
        }
        return $input;
    }
    
    function numberOfSlots($inputString)
    {
        preg_match_all('#-#', $inputString, $matches );
        return count($matches[0]);
    }
    
    function slotCombinations($totalSlots)
    {
        $return = array();
        $slots = $this->slots($totalSlots);
        
        $combiner = new Elite_Vafimporter_Model_ArrayCombiner;
        $combiner->setTraits($slots);
        $slotCombinations = $combiner->getCombinations();
        foreach($slotCombinations as $slotCombination )
        {
            if( $totalSlots == count($slotCombination))
            {
                array_push($return,$slotCombination);
            }
        }
        return $return;
    }
    
    function slots($totalSlots)
    {
        $return = array();
        for($slotNum = 0; $slotNum < $totalSlots; $slotNum++ )
        {
            $return['slot'.$slotNum] = array(' ', '-');
        }
        return $return;
    }
}