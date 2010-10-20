<?php
class Elite_Vafpaint_Model_Quote extends Mage_Sales_Model_Quote
{
	/**
     * Adding new item to quote
     *
     * @param   Mage_Sales_Model_Quote_Item $item
     * @return  Mage_Sales_Model_Quote
     */
    function addItem(Mage_Sales_Model_Quote_Item $item)
    {
        // elite paint
    	if( isset( $_POST['paint'] ))
    	{
    		if( 'other' != $_POST['paint'] )
    		{
        		$item->setElitePaint( $_POST['paint'] );
			}
			else
			{
				$item->setElitePaintOther( $_POST['vafPaintCustom'] );
			}
            
		}
		// elite paint
		
        $item->setQuote($this);
        if (!$item->getId()) {
            $this->getItemsCollection()->addItem($item);
            Mage::dispatchEvent('sales_quote_add_item', array('quote_item' => $item));
        }
        $this->save();
        return $this;
    }
    
    /**
     * Retrieve quote item by product id
     *
     * @param   int $productId
     * @return  Mage_Sales_Model_Quote_Item || false
     */
    function getItemByProduct($product)
    {
        foreach ($this->getAllItems() as $item) {
        	// start elite paint
        	if( isset($_POST['paint']) )
	        {
				if( $item->getElitePaint() != $_POST['paint'] )
				{
					return false;
				}
	        }
	        // end elite paint
            if ($item->representProduct($product)) {
                return $item;
            }
        }
        return false;
    }

}
