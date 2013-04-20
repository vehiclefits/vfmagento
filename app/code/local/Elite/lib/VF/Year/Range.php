<?php
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