<?php
class Elite_Vafimporter_Model_Settings extends Zend_Form
{
    function init()
    {
        $this->addElement('text','foo', array(
            'label'=>'foo'
        ));
    }
}