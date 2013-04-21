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
require_once('../../../../Mage.php');
Mage::app('admin')->setUseSessionInUrl(false);


 
    umask(0);
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $count = 0;
 
    $file = fopen('categories.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) { $count++;
      //$line is an array of the csv elements
 
      if (!empty($line[0]) && !empty($line[1])) { 
 
          $data['general']['path'] = $line[0];
          $data['general']['name'] = $line[1];
          $data['general']['meta_title'] = "";
          $data['general']['meta_description'] = "";
          $data['general']['is_active'] = "";
          $data['general']['url_key'] = "";
          $data['general']['display_mode'] = "PRODUCTS";
          $data['general']['is_anchor'] = 0;
 
          $data['category']['parent'] = $line[0]; // 3 top level
          $storeId = 0;
 
          createCategory($data,$storeId);
          sleep(0.5);
          unset($data);
        }
 
    }  
 
 
  function createCategory($data,$storeId) {
 
      echo "Starting {$data['general']['name']} [{$data['category']['parent']}] ...";
 
      $category = Mage::getModel('catalog/category');
      $category->setStoreId($storeId);
 
      # Fix must be applied to run script
      #http://www.magentocommerce.com/boards/appserv/main.php/viewreply/157328/
      
          if (is_array($data)) {
              $category->addData($data['general']);
 
              if (!$category->getId()) {
 
                  $parentId = $data['category']['parent'];
                  if (!$parentId) {
                      if ($storeId) {
                          $parentId = Mage::app()->getStore($storeId)->getRootCategoryId();
                      }
                      else {
                          $parentId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
                      }
                  }
                  $parentCategory = Mage::getModel('catalog/category')->load($parentId);
                  $category->setPath($parentCategory->getPath());
 
              }
 
                    /**
                     * Check "Use Default Value" checkboxes values
                     */
                    if ($useDefaults = $data['use_default']) {
                        foreach ($useDefaults as $attributeCode) {
                            $category->setData($attributeCode, null);
                        }
                    }              
 
              $category->setAttributeSetId($category->getDefaultAttributeSetId());
 
              if (isset($data['category_products']) &&
                  !$category->getProductsReadonly()) {
                  $products = array();
                  parse_str($data['category_products'], $products);
                  $category->setPostedProducts($products);
              }
 
              try {
                  $category->save();
                  echo "Suceeded <br /> ";
              }
              catch (Exception $e){
                      echo "Failed <br />";
 
              }
          }      
 
  }