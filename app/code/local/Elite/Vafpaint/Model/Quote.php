<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

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
	if (isset($_POST['paint']))
	{
	    if ('other' != $_POST['paint'])
	    {
		$item->setElitePaint($_POST['paint']);
	    } else
	    {
		$item->setElitePaintOther($_POST['vafPaintCustom']);
	    }
	}
	// elite paint

	$item->setQuote($this);
	if (!$item->getId())
	{
	    $this->getItemsCollection()->addItem($item);
	    Mage::dispatchEvent('sales_quote_add_item', array('quote_item' => $item));
	}
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
	foreach ($this->getAllItems() as $item)
	{
	    // start elite paint
	    if (isset($_POST['paint']))
	    {
		if ($item->getElitePaint() != $_POST['paint'])
		{
		    return false;
		}
	    }
	    // end elite paint
	    if ($item->representProduct($product))
	    {
		return $item;
	    }
	}
	return false;
    }

}
