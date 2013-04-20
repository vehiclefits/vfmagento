<?php
class Elite_Vaflogo_Block_List extends Mage_Core_Block_Abstract
{
    function _toHtml()
    {
	$return = '<ul>';
	$make = new VF_Level('make');
	foreach($make->listAll() as $eachMake)
	{
	    $return .= '<li><a href="?make=' . $eachMake->getId() . '"><img src="/logos/' . strtoupper($eachMake->getTitle()) . '.jpg" /></a></li>';
	}
	$return .= '</ul>';
	return $return;
    }
}