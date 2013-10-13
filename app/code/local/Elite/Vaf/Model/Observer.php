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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_Observer extends Mage_Core_Model_Abstract
{
    function bootstrap($event)
    {
        $elite_path = Mage::getBaseDir() . '/app/code/local/Elite';
        defined('ELITE_PATH') or define('ELITE_PATH', $elite_path); // put path to app/code/local/Elite
        defined('ELITE_CONFIG_DEFAULT') or define('ELITE_CONFIG_DEFAULT', ELITE_PATH . '/Vaf/config.default.ini');
        defined('ELITE_CONFIG') or define('ELITE_CONFIG', ELITE_PATH . '/Vaf/config.ini');
        defined('MAGE_PATH') or define('MAGE_PATH', Mage::getBaseDir());
        require('Elite/vendor/autoload.php');
        
        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        VF_Singleton::getInstance()->setReadAdapter($read);
        VF_Singleton::getInstance()->setProcessURL('/vaf/ajax/process?');
    }

    function catalogProductEditAction($event)
    {
        $product = Mage::registry('current_product');
        if (!is_object($product)) {
            return;
        }

        $controller = $event->getControllerAction();
        $request = $controller->getRequest();
        $this->removeFitments($request, $product);
        $this->updateUniversal($product);
        $this->updateRelated($product);
        $this->addNewFitments($request, $product);
        $this->dispatchProductEditEvent($controller, $product);
    }

    function removeFitments($request, $product)
    {
        $schema = new VF_Schema();
        if (is_array($request->getParam('vaf-delete')) && count($request->getParam('vaf-delete')) >= 1) {
            foreach ($request->getParam('vaf-delete', array()) as $fit) {
                $fit = explode('-', $fit);
                $level = $fit[0];
                $fit = $fit[1];
                if ($level == $schema->getLeafLevel()) {
                    $product->deleteVafFit($fit);
                }
            }
        }
    }

    function updateUniversal($product)
    {
        if (isset($_POST['universal']) && $_POST['universal']) {
            $product->setUniversal(true);
        } else {
            $product->setUniversal(false);
        }
    }

    function updateRelated($product)
    {
        if (file_exists(ELITE_PATH . '/Vafrelated')) {
            $relatedProduct = new Elite_Vafrelated_Model_Catalog_Product($product);
            if (isset($_POST['related']) && $_POST['related']) {
                $relatedProduct->setShowInRelated(true);
            } else {
                $relatedProduct->setShowInRelated(false);
            }
        }
    }

    function addNewFitments($request, $product)
    {
        if (is_array($request->getParam('vaf')) && count($request->getParam('vaf')) >= 1) {
            foreach ($request->getParam('vaf') as $fit) {
                if (strpos($fit, ':') && strpos($fit, ';')) {
                    // new logic
                    $params = explode(';', $fit);
                    $newParams = array();
                    foreach ($params as $key => $value) {
                        $data = explode(':', $value);
                        if (count($data) <= 1) {
                            continue;
                        }
                        $newParams[$data[0]] = $data[1];
                    }
                    $product->addVafFit($newParams);
                } else {
                    //legacy logic
                    $fit = explode('-', $fit);
                    $level = $fit[0];
                    $fit = $fit[1];
                    $product->addVafFit(array($level => $fit));
                }
            }
        }
    }

    function doTabs($event)
    {
        $block = $event->block;
        $suffix = 'Catalog_Product_Edit_Tabs';
        $blockClass = get_class($block);
        if (strpos($blockClass, $suffix) != 0) {
            $contents = $block->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_vaf');
            $contents = $contents->toHtml();
            $block->addTab('vaf', array(
                'label' => Mage::helper('catalog')->__('Vehicle Fits'),
                'content' => $contents
            ));
        }
    }

    function deleteModelBefore($event)
    {
        $product = $event->object;
        if (get_class($product) != 'Elite_Vaf_Model_Catalog_Product') {
            return;
        }
        $this->query(
            sprintf(
                "DELETE FROM `elite_1_mapping` WHERE `entity_id` = %d",
                (int)$product->getId()
            )
        );
    }

    /** array('order'=>$order, 'quote'=>$this->getQuote()) */
    function checkoutSaveOrder($event)
    {
        $fit_id = VF_Singleton::getInstance()->getFitId();
        if ($fit_id) {
            $event->order->setEliteFit($fit_id);
        }
    }

    protected function dispatchProductEditEvent($controller, $product)
    {
        Mage::dispatchEvent('elite_vaf_product_edit', array(
            'controller' => $controller,
            'product' => $product
        ));
    }

    /** @return Zend_Db_Statement_Interface */
    protected function query($sql)
    {
        return $this->getReadAdapter()->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return VF_Singleton::getInstance()->getReadAdapter();
    }
}