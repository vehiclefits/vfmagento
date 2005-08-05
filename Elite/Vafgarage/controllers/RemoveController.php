<?php
class Elite_Vafgarage_RemoveController extends Mage_Core_Controller_Front_Action
{    
    
    function removeAction()
    {
    	if(isset($_SESSION['garage']))
    	{
    		$_SESSION['garage']->removeVehicle($this->levels());
    	}
    	$this->_redirectReferer();
    }
    
    function levels()
    {
    	$params = $this->getRequest()->getParam('vehicle');
    	$params = explode("-",$params);
    	$schema = new Elite_Vaf_Model_Schema;
    	$levels = array();
    	foreach($schema->getLevels() as $level)
    	{
    		$levels[$level] = current($params);
    		next($params);
    	}
    	return $levels;
    }

}