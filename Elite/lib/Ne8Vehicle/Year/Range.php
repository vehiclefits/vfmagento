<?php
class Ne8Vehicle_Year_Range extends Ne8Vehicle_Year_Abstract
{
    protected $range;
    
    function __construct($range)
    {
        $this->range = $range;
    }
    
    function isValid()
    {
        $array = $this->asArray();
        if(1!=count($array) && 2!=count($array))
        {
            return false;
        }
        if( !$this->startIsValid() && !$this->endIsValid())
        {
            return false;
        }
        if(
            ( $this->startInput() && !$this->startYear()->isValid() ) ||
            ( $this->endInput() && !$this->endYear()->isValid() )
        )
        {
            return false;
        }
        return true;
    }
    
    function startIsValid()
    {
         if( strlen($this->startInput()) == 4 || strlen($this->startInput()) == 2 )
         {
             return true;
         }
         return false;
    }
        
    function endIsValid()
    {
         if( strlen($this->endInput()) == 4 || strlen($this->endInput()) == 2 )
         {
             return true;
         }
         return false;
    }
    
    function start()
    {
        if(!$this->startYear()->isValid() && $this->endYear()->isValid())
        {
            return $this->end();
        }
        return $this->startYear()->value();
    }
    
    function end()
    {
        if(!$this->endYear()->isValid() && $this->startYear()->isValid())
        {
            return $this->start();
        }
        return $this->endYear()->value();
    }
    
    function startYear()
    {
        $year = new Ne8Vehicle_Year($this->startInput());
        $year->setY2KMode($this->Y2KMode);
        $year->setThreshold($this->threshold);
        return $year;
    }
    
    function endYear()
    {
        $year = new Ne8Vehicle_Year($this->endInput());
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