<?php
class Elite_Vaflogo_Block_Logo extends Mage_Core_Block_Abstract
{
	function _toHtml()
	{
		if( Elite_Vaf_Helper_Data::getInstance()->getConfig()->logo->disable )
        {
            return;
        }
        if(!$this->selectionPart())
        {
			return;
        }
        $pathSuffix = $this->selectionToken().'.PNG';
		return '<img class="vafLogo" src="/logos/' . $pathSuffix .'" style="width:100%" />';
		
	}
	
	function selectionPart()
	{
		$vehicle = Elite_Vaf_Helper_Data::getInstance()->getFit();
		if( !$vehicle )
		{
			return false;
		}
		$make = $vehicle->getLevel('make');
		if(!$make)
		{
			return false;
		}
		return $make->__toString();
	}
	
	function selectionToken()
	{
		$selectionPart = $this->selectionPart();
		return basename(strtoupper(str_replace(' ', '-',$selectionPart)));
	}
}