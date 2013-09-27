<?php


class Elite_Vaf_Singleton extends VF_Singleton
{
    /** @return Elite_Vaf_Singleton */
    static function getInstance($new = false) // test only
    {
        if (is_null(self::$instance) || $new) {
            self::$instance = new Elite_Vaf_Singleton;
        }
        return self::$instance;
    }

    function flexibleSearch()
    {
        $search = parent::flexibleSearch();
        if ($this->shouldEnableVafWheelModule()) {
            $search = new Elite_Vafwheel_Model_FlexibleSearch($search);
        }
        if ($this->shouldEnableVaftireModule()) {
            $search = new Elite_Vaftire_Model_FlexibleSearch($search);
        }
        if ($this->shouldEnableVafwheeladapterModule()) {
            $search = new Elite_Vafwheeladapter_Model_FlexibleSearch($search);
        }
        return $search;
    }

    function ensureDefaultSectionsExist($config)
    {
        parent::ensureDefaultSectionsExist($config);
        $this->ensureSectionExists($config, 'modulestatus');
    }

    function storeFitInSession()
    {
        $search = $this->flexibleSearch();
        $mapping_id = $search->storeFitInSession();

        if ($this->shouldEnableVaftireModule()) {
            $tireSearch = new Elite_Vaftire_Model_FlexibleSearch($search);
            $tireSearch->storeTireSizeInSession();
        }
        if ($this->shouldEnableVafWheelModule()) {
            $wheelSearch = new Elite_Vafwheel_Model_FlexibleSearch($search);
            $wheelSearch->storeSizeInSession();
        }
        if ($this->shouldEnableVafwheeladapterModule()) {
            $wheeladapterSearch = new Elite_Vafwheeladapter_Model_FlexibleSearch($search);
            $wheeladapterSearch->storeAdapterSizeInSession();
        }
        return $mapping_id;
    }

    public function shouldEnableVafWheelModule()
    {
        if (!$this->getConfig()->modulestatus->enableVafwheel) {
            return false;
        }
        if (!file_exists(ELITE_PATH . '/Vafwheel')) {
            throw new Exception(sprintf(
                "You tried to enable Vafwheel however it does not exist in %s",
                ELITE_PATH . '/Vafwheel'
            ));
        }
        return true;
    }

    public function shouldEnableVaftireModule()
    {
        if (!$this->getConfig()->modulestatus->enableVaftire) {
            return false;
        }
        if (!file_exists(ELITE_PATH . '/Vaftire')) {
            throw new Exception(sprintf(
                "You tried to enable Vaftire however it does not exist in %s",
                ELITE_PATH . '/Vaftire'
            ));
        }
        return true;
    }


    public function shouldEnableVafwheeladapterModule()
    {
        if (!$this->getConfig()->modulestatus->enableVafwheeladapter) {
            return false;
        }
        if (!file_exists(ELITE_PATH . '/Vafwheeladapter')) {
            throw new Exception(sprintf(
                "You tried to enable Vafwheeladapter however it does not exist in %s",
                ELITE_PATH . '/Vafwheeladapter'
            ));
        }
        return true;
    }

    public function getRequest()
    {
        if (defined('ELITE_TESTING')) {
            return parent::getRequest();
        }
        // get Magento request
        if (class_exists('Mage', false)) {
            if ($controller = Mage::app()->getFrontController()) {
                return $controller->getRequest();
            } else {
                throw new Exception(Mage::helper('core')->__("Can't retrieve request object"));
            }
        }


    }

}