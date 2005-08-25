<?php
class Elite_Vafimporter_Model_ValueExploder
{
    protected $i;
    protected $input;
    protected $exploderToken = '{{all}}';
    protected $wildCardToken = '*';
    
    function explode( $input )
    {
        $this->input = $input;
        if(!$this->hasWildCards())
        {
            return array($input);
        }
        
        $this->result = array();
        $this->i = 0;
        
        $this->replaceAllWithWildcard();
        
        $result = array();
        $finder = new VF_Vehicle_Finder($this->getSchema());
        foreach( $finder->findByLevels($this->input) as $vehicle )
        {
            array_push($result,$vehicle->toTitleArray());
        }
        return $result;
    }
    
    function replaceAllWithWildcard()
    {
        foreach( $this->getSchema()->getLevels() as $level )
        {
            if( $this->isExploderToken($level) )
            {
                $this->input[$level] = '*';
            }
        }
    }
    
    function hasWildCards()
    {
        foreach( $this->getSchema()->getLevels() as $level )
        {
            if( $this->isExploderToken($level) || false !== strpos($this->input[$level], $this->wildCardToken ) )
            {
                return true;
            }
        }
        return false;
    }
    
    function isExploderToken($level)
    {
        return $this->exploderToken == $this->input[$level];
    }  
    
    function getSchema()
    {
        return new VF_Schema();
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}