<?php
require_once('../Vaf/bootstrap-tests.php');
class Format
{
    const MAKE = 0;
    const MODEL = 1;
    const TRIM = 2;
    const YEAR_START = 3;
    const YEAR_END = 4;
    
    const BOLT_PATTERN = 5;
    const HUB = 6;
    const OFFSET = 7;
    const THREAD = 8;
    const THREAD_TYPE = 9;
    
    const TIRE_SIZE_PLUSSIZED = 10;
    const TIRE_SIZE = 11;
    
    protected $reader;
    
    function main()
    {
        $row = $this->getRow();
        $lastRow = $row;
        $return = $this->formatRow($row) . "\n";

        $i = 0;
        while( $row = $this->getRow() )
        {
            if( preg_match('#plus#', $row[self::TIRE_SIZE_PLUSSIZED] ) )
            {
                continue;
            }
            if(empty($row[self::MAKE]))
            {
                $row[self::MAKE]                = $lastRow[self::MAKE];
                $row[self::MODEL]               = $lastRow[self::MODEL];
                $row[self::TRIM]                = $lastRow[self::TRIM];
                $row[self::YEAR_START]          = $lastRow[self::YEAR_START];
                $row[self::YEAR_END]            = $lastRow[self::YEAR_END];
                $row[self::BOLT_PATTERN]        = $lastRow[self::BOLT_PATTERN];
                $row[self::HUB]                 = $lastRow[self::HUB];
                $row[self::OFFSET]              = $lastRow[self::OFFSET];
                $row[self::THREAD]              = $lastRow[self::THREAD];
                $row[self::THREAD_TYPE]         = $lastRow[self::THREAD_TYPE];
            }
            
            $i++;
            $lastRow = $row;
            $return .= $this->formatRow($row) . "\n";
            
        }
        
        return $return;
    }
    
    function formatRow($row)
    {
        foreach($row as $index => $value)
        {
            $row[$index] = '"' . str_replace('"','""',$value) . '"';
        }
        return implode(',',$row);
    }
    
    function getRow()
    {
        return $this->reader()->getRow();
    }
    
    function reader()
    {
        if(is_null($this->reader))
        {
            $this->reader = new Csv_Reader('E:\dev\vaf\app\code\local\Elite\tasks\tire-format\bolt-and-tires-v6.csv');
        }
        return $this->reader;
    }
}

$format = new Format;
file_put_contents('tire-format/formatted.csv', $format->main() );