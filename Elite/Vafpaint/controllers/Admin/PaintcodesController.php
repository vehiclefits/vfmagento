<?php
class Elite_Vafpaint_Admin_PaintcodesController extends Mage_Adminhtml_Controller_Action
{ 
    
    function importAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('vaf/paintcodes');
        
        $block = $this->getLayout()->createBlock('adminhtml/paint_paintcodes', 'paint/paintcodes' );
        $this->_addContent( $block );
        $this->renderLayout();
    }

}