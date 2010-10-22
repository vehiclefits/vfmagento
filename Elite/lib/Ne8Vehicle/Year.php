<?php
class Ne8Vehicle_Year extends Ne8Vehicle_Year_Abstract
{
    protected $year;
    
    function __construct($year)
    {
        $this->year = $year;
    }
    
    function isValid()
    {
        return is_numeric($this->year) && (strlen($this->year) == 2 || strlen($this->year) == 4);
    }
    
    function value()
    {
        if(!$this->isValid())
        {
            throw new Ne8Vehicle_Year_Exception('Trying to work with invalid year [' . $this->year . ']');
        }
        
        if(strlen($this->year) == 2 && $this->Y2KMode )
        {
            if( $this->year < $this->threshold)
            {
                $this->year = '20' . $this->year;
            }
            else
            {
                $this->year = '19' . $this->year;
            }
        }
        return $this->year;
    }
}