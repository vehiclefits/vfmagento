<?php
class Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{


    protected function _prepareLayout()
    {
       
        $return = parent::_prepareLayout();  
        $contents = $this->getLayout()->createBlock( 'adminhtml/catalog_product_edit_tab_vaf' );
        $contents = $contents->toHtml();
        $this->addTab('vaf', array(
            'label'     => Mage::helper('catalog')->__('Vehicle Fits'),
            'content' => $contents
        ));

       
        return $return;
    }
   
}
