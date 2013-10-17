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
class Elite_Vaf_Model_Catalog_Product extends Mage_Catalog_Model_Product
{

    protected $vf_product;

    function __construct()
    {
        $this->vf_product = new VF_Product;
        parent::__construct();
    }

    function VFProduct()
    {
        return $this->vf_product;
    }

    function setData($key, $value = null)
    {
        if(is_array($key)) {
            if(isset($key['id'])) {
                $this->setId($key['id']);
            }
            if(isset($key['entity_id'])) {
                $this->setId($key['entity_id']);
            }
        } elseif ('id'==$key || 'entity_id'==$key) {
            $this->vf_product->setId($value);
        }
        return parent::setData($key, $value);
    }

    function setId($id)
    {
        $this->vf_product->setId($id);
        return parent::setId($id);
    }

    function getMinimalPrice()
    {
        if (!$this->currentlySelectedFit()) {
            return parent::getMinimalPrice();
        }
        $selection = $this->currentlySelectedFit();
        $vehicle = $selection->getFirstVehicle();
        if (!$vehicle) {
            return parent::getMinimalPrice();
        }
        $customPrice = $this->customPrice($vehicle);
        if (!$customPrice) {
            return parent::getMinimalPrice();
        }
        return $customPrice;
    }

    function getFinalPrice($qty = null)
    {
        if (!$this->currentlySelectedFit()) {
            return parent::getFinalPrice($qty);
        }
        $selection = $this->currentlySelectedFit();
        $vehicle = $selection->getFirstVehicle();
        if (!$vehicle) {
            return parent::getFinalPrice($qty);
        }
        $customPrice = $this->customPrice($vehicle);
        if ($customPrice) {
            return $customPrice;
        }
        return parent::getFinalPrice($qty);
    }

    function getPrice()
    {
        $this->setFitFromGlobalIfNoLocalFitment();
        if ($this->currentlySelectedFit()->isEmpty()) {
            return parent::getPrice();
        }

        $vehicle = $this->currentlySelectedFit()->getFirstVehicle();
        $customPrice = $this->customPrice($vehicle);
        if ($customPrice) {
            return $customPrice;
        }
        return parent::getPrice();
    }

    function getFormatedPrice()
    {
        if ($this->currentlySelectedFit() && $customPrice = $this->customPrice($this->currentlySelectedFit())) {
            return $customPrice;
        }
        return parent::getPrice();
    }

    function getConfig()
    {
        return $this->vf_product->getConfig();
    }

    function setConfig(Zend_Config $config)
    {
        return $this->vf_product->setConfig($config);
    }

    function getFitModels()
    {
        return $this->vf_product->getFitModels();
    }

    /** Get a result set for the fits for this product */
    function getFits()
    {
        return $this->vf_product->getFits();
    }

    function customPrice($vehicle)
    {
        return $this->vf_product->customPrice($vehicle);
    }

    function getOrderBy()
    {
        return $this->vf_product->getOrderBy();
    }

    public static function getJoins()
    {
        return vf_product::getJoins();
    }

    /**
     * Add one or more fitment(s) described by an array of level IDs
     *
     * Examples -  add make 5 and all its children:
     * array( 'make' => 5 )
     *
     *  ...   is the same as:
     * array( 'make' => 5, 'model' => 0 )
     *
     * ... or add a individual fit:
     * array( 'make' => 5, 'model' => 3, 'year' => 4 )
     *
     * ... is the same as
     * array( 'year' => 4 )
     *
     * @param array fitToAdd - fitment to add represented as an array keyed by level name [string]
     * @return integer ID of fitment row created
     */
    function addVafFit(array $fitToAdd)
    {
        return $this->vf_product->addVafFit($fitToAdd);
    }

    function vehicleFinder()
    {
        return $this->vf_product->vehicleFinder();
    }

    function insertMapping(VF_Vehicle $vehicle)
    {
        return $this->vf_product->insertMapping($vehicle);
    }

    function deleteVafFit($mapping_id)
    {
        return $this->vf_product->deleteVafFit($mapping_id);
    }

    /** @return boolean */
    function isUniversal()
    {
        return $this->vf_product->isUniversal();
    }

    /** @param boolean */
    function setUniversal($universal)
    {
        return $this->vf_product->setUniversal($universal);
    }

    function getName()
    {
        return $this->vf_product->getName(parent::getName());
    }

    function setFitFromGlobalIfNoLocalFitment()
    {
        return $this->vf_product->setFitFromGlobalIfNoLocalFitment();
    }

    function rewritesOn()
    {
        return $this->vf_product->rewritesOn();
    }

    function globalRewritesOn()
    {
        return $this->vf_product->globalRewritesOn();
    }

    function setCurrentlySelectedFit($fit)
    {
        return $this->vf_product->setCurrentlySelectedFit($fit);
    }

    function currentlySelectedFit()
    {
        return $this->vf_product->currentlySelectedFit();
    }

    function fitsSelection()
    {
        return $this->vf_product->fitsSelection();
    }

    function fitsVehicle($vehicle)
    {
        return $this->vf_product->fitsVehicle($vehicle);
    }

    function isInEnabledCategory(Elite_Vaf_Model_Catalog_Category_Filter $filter)
    {
        $categoryids = $this->getCategoryIds();
        return $this->vf_product->isInEnabledCategory($filter, $categoryids);
    }

    function getMappingId(VF_Vehicle $vehicle)
    {
        return $this->vf_product->getMappingId($vehicle);
    }

    /**
     * Create duplicate
     *
     * @return Mage_Catalog_Model_Product
     */
    function duplicate()
    {
        $schema = new VF_Schema();
        $vehicleFinder = new VF_Vehicle_Finder($schema);
        $leaf = $schema->getLeafLevel() . '_id';

        $newProduct = parent::duplicate();
        foreach ($this->getFits() as $fit) {
            
            // 2.x has a bug that it inserts blank fitments, which prevents duplicating products here. Simple workaround for 2.x
            if(!$fit->$leaf) {
                continue;
            }

            $levelIDs = array();
            foreach($schema->getLevels() as $level) {
                $levelIDs[$level.'_id'] = $fit->{$level.'_id'};
            }

            $vehicle = $vehicleFinder->findOneByLevelIds($levelIDs);
            if(is_object($vehicle)) {
                $newProduct->insertMapping($vehicle);
            }

        }
        if ($this->isUniversal()) {
            $newProduct->setUniversal(true);
        }
        return $newProduct;
    }

    /**
     * @param Elite_Vaf_Model_Abstract - if is an "aggregrate" of fits ( iterate and add it's children )
     */
    function doAddFit($entity)
    {
        return $this->vf_product->doAddFit($entity);
    }

    function createFitFromRow($row)
    {
        return $this->vf_product->createFitFromRow($row);
    }

    function doGetFits($productId)
    {
        return $this->vf_product->doGetFits($productId);
    }

    function getSchema()
    {
        return $this->vf_product->getSchema();
    }

    /** @return Zend_Db_Statement_Interface */
    function query($sql)
    {
        return $this->vf_product->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        return $this->vf_product->getReadAdapter();
    }
}
