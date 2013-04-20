<?php
class Elite_Vaf_Model_Settings_Product extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','requireVehicleBeforeCart', array(
            'label'=>'requireVehicleBeforeCart',
            'description'=> 'Require the user to choose a vehicle before adding product to cart

    Set to true to require the user to choose a vehicle before adding product to cart. If enabled users will be presented with an intermediate page, and asked to choose their vehicle from a list of compatable vehicles before adding the product to the cart. The default behavior is for this to be turned off, unless you set it to true.*[1][2]

*[1] Will only affect categories that are enabled. Will only affect product that are in enabled categories. If product is in both a blacklisted & whitelisted category, it will be treated as if it is whitelisted.
*[2] Will only occur if the product actually has fitments mapped to it, if not there would be no possible choices and it would not make sense to show it.',
            'value' => $this->getConfig()->product->requireVehicleBeforeCart ? 'true' : 'false'
        ));       
        $this->addElement('submit','save', array('label'=>'Save'));
        
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

}