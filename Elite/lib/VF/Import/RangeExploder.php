<?php
class VF_Import_RangeExploder
{
    protected $config;
    protected $error;
    
    function __construct($config)
    {
        $this->config = $config;
    }
    
    function explodeRanges($values,$level)
    {
        if( isset($values[$level.'_range']))
        {
            $val = $values[$level.'_range'];
            unset($values[$level.'_range']);
            list($start,$end) = $this->explodeRangesOneColumn($val);
        }
        else
        {
            $start_value = $values[$level.'_start'];
            $end_value = $values[$level.'_end'];
            unset($values[$level.'_start']);
            unset($values[$level.'_end']);
            list($start,$end) = $this->explodeRangesTwoColumns($start_value, $end_value);
        }
        
        $this->fixYears($start,$end);
        for( $currentValue = $start; $currentValue <= $end; $currentValue++ )
        {
            $values[$level][] = str_pad($currentValue,2,'0',STR_PAD_LEFT);
        }
        
        return $values;
    }
    
    function fixYears( &$start, &$end )
    {
        if( $start > $end )
        {
            $newStart = $start;
            $newEnd = $end;
            
            $start = $newEnd;
            $end = $newStart;
        }
        
        if( $start && !$end )
        {
            $end = $start;
        }
        
        if( !$start && $end )
        {
            $start = $end;
        }
    }
    
    function explodeRangesOneColumn($val)
    {
        $range = $this->yearRange($val);
            
        if( !$range->isValid() )
        {
            $this->error = 'Invalid Year Range: [' . $val . ']';
            return false;
        }
        
        $start = $range->start();
        $end = $range->end();
        return array($start,$end);
    }
    
    function explodeRangesTwoColumns($start_value,$end_value)
    {
        $startYear = $this->year($start_value);
        $endYear = $this->year($end_value);
        
        if( !$startYear->isValid() && !$endYear->isValid() )
        {
            $this->error = 'Invalid Year Range: [' . $start_value . '] & [' . $end_value . ']';
            return false;
        }
        
        $start = $this->yearValue($startYear);
        $end = $this->yearValue($endYear);
        return array($start, $end);
    }
    
    function year($value)
    {
        $year = new VF_Year($value);
        if(isset($this->getConfig()->importer->Y2KMode) && false === $this->getConfig()->importer->Y2KMode)
        {
            $year->setY2KMode(false);
        }
        if($this->getConfig()->importer->Y2KThreshold)
        {
            $year->setThreshold($this->getConfig()->importer->Y2KThreshold);
        }
        return $year;
    }
    
    function yearRange($value)
    {
        $range = new VF_Year_Range($value);
        if(isset($this->getConfig()->importer->Y2KMode) && false === $this->getConfig()->importer->Y2KMode)
        {
            $range->setY2KMode(false);
        }
        if($this->getConfig()->importer->Y2KThreshold)
        {
            $range->setThreshold($this->getConfig()->importer->Y2KThreshold);
        }
        return $range;
    }
    
    function yearValue($year)
    {
        if($year->isValid())
        {
            return $year->value();
        }
        return null;
    }
    
    function getConfig()
    {
        return $this->config;
    }
    
    function getError()
    {
        return $this->error;
    }
}