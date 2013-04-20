<?php
class VF_Import_Combiner
{
    protected $error;
    protected $schema;
    protected $config;
    
    function __construct(VF_Schema $schema, $config)
    {
        $this->schema = $schema;
        $this->config = $config;
    }
    
    function getCombinations( $values )
    {
        $values = $this->trimSpaces($values);
        
        foreach( $this->getSchema()->getLevels() as $level )
        {
            $values = $this->explodeRangesAndEnumerations($level,$values);
            if(false === $values)
            {
                return array();
            }
        }
        
        $combinations = $this->getPowerSetCombinations($values);
        $combinations = $this->explodeWildcardCombinations($combinations);
                    
        return $combinations;
    }
    
    function explodeRangesAndEnumerations($level, $values)
    {
        if( $this->isStartEndRange($values,$level) )
        {
            $values = $this->explodeRanges($values, $level);
        }
        else if( $this->isCommaList($values,$level))
        {
            $values[$level] = $this->convertValuesListToArray( $values[$level] );
        }
        else
        {
            $values[$level] = $this->convertValueToArray( $values[$level] );
        }
        
        return $values;
    }
    
    function trimSpaces($values)
    {
        foreach($values as $key => $value)
        {
            $values[$key] = trim($value);
        }
        return $values;
    }

    function getPowerSetCombinations($values)
    {
        $combiner = new VF_Import_ArrayCombiner();
        $combiner->setTraits($values);
        $combinations = $combiner->getCombinations();
        
        // put them back in correct order (root through leaf level)
        foreach($combinations as $key => $combination)
        {
            $combinations[$key] = array();
            foreach( $this->getSchema()->getLevels()  as $level )
            {
                $combinations[$key][$level] = trim($combination[$level]);
            }
        }
        return $combinations;
    }
    
    function explodeWildcardCombinations($combinations)
    {
        $result = array();
        foreach($combinations as $key => $combination)
        {
            // blow out {{all}} tokens
            $valueExploder = new VF_Import_ValueExploder();
            $result = array_merge( $result, $valueExploder->explode($combination) );
        }
        return $result;
    }
    
    function isCommaList($values,$level)
    {
        return preg_match('#,#',$values[$level]);
    }
    
    function convertValueToArray( $val )
    {
        return array($val);
    }
    
    function convertValuesListToArray( $inputString )
    {
        $token = '#~#comma#~#';
        $string = str_replace(',,', $token, $inputString);
        $array = explode(',', $string);
        foreach($array as $key => $val)
        {
            $array[$key] = str_replace($token, ',', $val);
        }
        return $array;
    }
    
    function isStartEndRange($values,$level)
    {
        if(isset($values[$level.'_range']))
        {
            return true;
        }
        return isset($values[$level.'_start']) && isset($values[$level.'_end']);
    }
    
    function explodeRanges($values,$level)
    {
        $exploder = new VF_Import_RangeExploder($this->getConfig());
        $values = $exploder->explodeRanges($values,$level);
        if($exploder->getError())
        {
            $this->error = $exploder->getError();
            return false;
        }
        return $values;
    }
    
    function getSchema()
    {
        return $this->schema;
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