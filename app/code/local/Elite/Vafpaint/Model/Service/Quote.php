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

// in mage 1.3 it was called - app/code/core/Mage/checkout/model/type/onepage.php
class Elite_Vafpaint_Model_Service_Quote extends Mage_Sales_Model_Service_Quote
{

    /** @deprecated after Magento 1.4.0.1 */
    function submit()
    {
	return $this->submitOrder();
    }

    public function submitOrder()
    {
	$version = Mage::getVersionInfo();
	if (1 <= $version['major'] && 4 <= $version['minor'] && $version['revision'] <= 1)
	{
	    return parent::submitOrder();
	}

	$this->_deleteNominalItems();
	$this->_validate();
	$quote = $this->_quote;
	$isVirtual = $quote->isVirtual();

	$transaction = Mage::getModel('core/resource_transaction');
	if ($quote->getCustomerId())
	{
	    $transaction->addObject($quote->getCustomer());
	}
	$transaction->addObject($quote);

	$quote->reserveOrderId();
	if ($isVirtual)
	{
	    $order = $this->_convertor->addressToOrder($quote->getBillingAddress());
	} else
	{
	    $order = $this->_convertor->addressToOrder($quote->getShippingAddress());
	}
	$order->setBillingAddress($this->_convertor->addressToOrderAddress($quote->getBillingAddress()));
	if (!$isVirtual)
	{
	    $order->setShippingAddress($this->_convertor->addressToOrderAddress($quote->getShippingAddress()));
	}
	$order->setPayment($this->_convertor->paymentToOrderPayment($quote->getPayment()));

	foreach ($this->_orderData as $key => $value)
	{
	    $order->setData($key, $value);
	}

	foreach ($quote->getAllItems() as $item)
	{
	    $orderItem = $this->_convertor->itemToOrderItem($item);
	    if ($item->getParentItem())
	    {
		$orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
	    }

	    // elite paint
	    $this->setItemPaint($orderItem, $item);

	    $order->addItem($orderItem);
	}

	$transaction->addObject($order);
	$transaction->addCommitCallback(array($order, 'place'));
	$transaction->addCommitCallback(array($order, 'save'));

	/**
	 * We can use configuration data for declare new order status
	 */
	Mage::dispatchEvent('checkout_type_onepage_save_order', array('order' => $order, 'quote' => $quote));
	Mage::dispatchEvent('sales_model_service_quote_submit_before', array('order' => $order, 'quote' => $quote));
	try
	{
	    $transaction->save();
	    $this->_inactivateQuote();
	    Mage::dispatchEvent('sales_model_service_quote_submit_success', array('order' => $order, 'quote' => $quote));
	} catch (Exception $e)
	{
	    Mage::dispatchEvent('sales_model_service_quote_submit_failure', array('order' => $order, 'quote' => $quote));
	    throw $e;
	}
	Mage::dispatchEvent('sales_model_service_quote_submit_after', array('order' => $order, 'quote' => $quote));
	$this->_order = $order;
	return $order;
    }

    protected function setItemPaint($orderItem, $item)
    {
	$orderItem->setElitePaint($item->getElitePaint());
	$orderItem->setElitePaintOther($item->getElitePaintOther());
    }

}