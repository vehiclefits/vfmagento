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
class Elite_Vaf_Admin_VehicleslistController extends Mage_Adminhtml_Controller_Action
{
    /** @var Zend_Config */
    protected $config;

    protected $block;

    function preDispatch()
    {
        if(preg_match('#localhost#',$_SERVER['HTTP_HOST']) && file_exists(sys_get_temp_dir().'/vf-ajax-tests')) {
            return;
        }
        return parent::preDispatch();
    }

    function indexAction()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }

        $this->loadLayout();
        $this->_setActiveMenu('vaf');

        $this->block = $this->getLayout()->createBlock('adminhtml/vaf_definitions', 'vaf' );
        $this->doIndexAction();
        $this->_addContent( $this->block );
        $this->renderLayout();
    }

    function doIndexAction()
    {
        $this->block->setTemplate( 'vf/vaf/entity.phtml' );

        $this->block->entity = $this->getEntity();

        $this->block->rs = call_user_func_array( array( $this->getEntity(), 'listAll' ), array($this->requestLevels()) );
        $this->block->label = $this->getLabel();
        $this->block->add_url = $this->getAddUrl();
        $this->block->request_levels = $this->requestLevels();
    }

    function deleteAction()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }

        $this->loadLayout();
        $this->_setActiveMenu('vaf');

        $this->block = $this->getLayout()->createBlock('adminhtml/vaf_definitions', 'vaf' );
        $this->doDeleteAction();
        $this->_addContent( $this->block );
        $this->renderLayout();
    }

    function doDeleteAction()
    {
        $id = $this->getRequest()->getParam( 'delete' );

        $params = $this->requestLevels();
        $params[ $this->getEntity()->getType()] = $id;

        foreach($this->schema()->getLevels() as $level)
        {
            if(!isset($params[$level]))
            {
                $params[$level] = 0;
            }
        }

        $vehicle = $this->vehicleFinder()->findByLevelIds($params, true);
        if(!count($vehicle))
        {
            $this->redirectAfterDelete();
            exit();
        }

        $vehicle = $vehicle[0];

        if( $this->getRequest()->getParam( 'confirm' ) )
        {
            $vehicle->unlink();
            $this->redirectAfterDelete();
            exit();
        }

        $this->block->model = $vehicle->getLevel($this->getEntity()->getType());
        $this->block->setTemplate( 'vf/vaf/delete.phtml' );
    }

    function redirectAfterDelete()
    {
        header( 'Location:' . $this->getListUrl2($this->getEntity()->getType()) . '?' . http_build_query($this->requestLevels()));
    }

    function saveAction()
    {
        $schema = new VF_Schema($this->getRequest()->getParam('schema'));
        $dataToSave = $this->requestLevels();
        $vehiclesFinder = new VF_Vehicle_Finder($schema);
        $vehicle = $vehiclesFinder->findOneByLevelIds($dataToSave,VF_Vehicle_Finder::INCLUDE_PARTIALS);
        if($vehicle){
            $dataToSave = $vehicle->toTitleArray();
        } else {
            $dataToSave = array();
        }

        $dataToSave[$this->getRequest()->getParam('entity')] = $this->getRequest()->getParam('title');
        $vehicle = VF_Vehicle::create($schema, $dataToSave);
        $vehicle->save();

        if ($this->getRequest()->isXmlHttpRequest()) {
            echo $vehicle->getValue($this->getRequest()->getParam('entity'));
            exit();
        }
        $this->doSave();
    }

    function mergeAction()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }

        $this->loadLayout();
        $this->_setActiveMenu('vaf');

        $this->block = $this->getLayout()->createBlock('adminhtml/vaf_definitions', 'vaf' );
        $this->block->setTemplate( 'vf/vaf/merge.phtml' );

        if(isset($_POST['master']))
        {
            $master = $this->masterLevel();
            $slave = $this->slaveLevels();

            $merge = new Elite_Vaf_Model_Merge($slave, $master);
            $merge->execute();

            header('location:' . $this->getListUrl2($_REQUEST['entity']) . http_build_query($this->requestLevels()) );
            exit();
        }

        $this->block->level = $_REQUEST['entity'];
        $this->block->slaveLevels = $this->slaveLevels();

        $this->_addContent( $this->block );
        $this->renderLayout();

    }

    function splitAction()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }

        $this->loadLayout();
        $this->_setActiveMenu('vaf');

        $this->block = $this->getLayout()->createBlock('adminhtml/vaf_definitions', 'vaf' );
        $this->block->setTemplate( 'vf/vaf/split.phtml' );

        if(isset($_POST['submit']))
        {
            $titles = explode(',', $_POST['new_titles']);
            $vehicle = $this->vehicleFinder()->findOneByLevelIds($this->requestLevels(), VF_Vehicle_Finder::INCLUDE_PARTIALS);
            $split = new Elite_Vaf_Model_Split($vehicle, $_POST['entity'], $titles);
            $split->execute();
            header('location:' . $this->getListUrl2($_REQUEST['entity']) );
            exit();
        }

        $params = $this->requestLevels();
        $params[$this->getRequest()->getParam('entity')] = $this->getRequest()->getParam('id');
        $this->block->vehicle = $this->vehicleFinder()->findOneByLevelIds($params, VF_Vehicle_Finder::INCLUDE_PARTIALS);
        if(!$this->block->vehicle)
        {
            header('location:' . $this->getListUrl2($_REQUEST['entity']) );
        }
        $this->_addContent( $this->block );
        $this->renderLayout();

    }

    function productAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('vaf');

        $this->block = $this->getLayout()->createBlock('adminhtml/vaf_definitions', 'vaf' );
        $this->block->setTemplate( 'vf/vaf/product.phtml' );

        $this->block->products = VF_Singleton::getInstance()->getProductIds();

        $this->_addContent( $this->block );
        $this->renderLayout();
    }

    function levelFinder()
    {
        return new VF_Level_Finder();
    }

    function masterLevel()
    {
        $params = $this->requestLevels();
        $params[$_REQUEST['entity']] = $_REQUEST['master'];
        $vehicle = $this->vehicleFinder()->findByLevelIds($params,true);
        $masterLevel = array($_REQUEST['entity'], $vehicle[0]);

        return $masterLevel;
    }

    function slaveLevels()
    {
        $slaveLevels = array();
        foreach($_POST['selected'] as $selected)
        {
            $params = $this->requestLevels();
            $params[$_REQUEST['entity']] = $selected;
            $vehicle = $this->vehicleFinder()->findByLevelIds($params,true);
            if(!count($vehicle))
            {
                continue;
            }
            array_push($slaveLevels, array($_REQUEST['entity'], $vehicle[0]));
        }
        return $slaveLevels;
    }

    protected function doSave()
    {
        header( 'Location:' . $this->getListUrl( $this->getEntity()->getType(), $this->getId() ) );
        exit();
    }

    protected function getListUrl( $entityType, $id )
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/index', array(
            'entity' => $entityType,
            'id' => $id
        )) . '?' . http_build_query($this->requestLevels());
        return $url;
    }

    protected function getListUrl2( $entityType )
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/index', array(
            'entity' => $entityType
        ));
        return $url;
    }

    protected function getAddUrl()
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/save', array(
            'id' => $this->getCurrentId()
        )) . '?' . http_build_query($this->requestLevels());
        return $url;
    }

    function getCurrentId()
    {
        return $this->getRequest()->getParam( 'id' );
    }

    protected function getLabel()
    {
        return $this->getEntity()->getLabel();
    }

    protected function getType()
    {
        return $this->getEntity()->getType();
    }

    protected function getParentTitle()
    {
        if( $this->getId() && $this->getEntity()->getPrevLevel() )
        {
            $entity = new VF_Level( $this->getEntity()->getPrevLevel(), $this->getId() );
            return $entity->getTitle();
        }
    }

    protected function hasParentTitle()
    {
        return (bool)$this->getParentTitle();
    }

    function getEntity()
    {

        $entity = $this->getRequest()->getParam( 'entity' );
        if( empty( $entity ) )
        {
            $entity = $this->getDefaultLevel();
        }
        return new VF_Level( $entity );
    }

    function getId()
    {
        return $this->getRequest()->getParam( 'id', 0 );
    }

    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {

            $this->config = VF_Singleton::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }

    function getDefaultLevel()
    {
        $schema = new VF_Schema;
        $schema->setConfig( $this->getConfig() );
        return $schema->getRootLevel();
    }

    function schema()
    {
        return new VF_Schema();
    }

    function requestLevels()
    {
        $params = array();
        foreach($this->schema()->getLevels() as $level)
        {
            if($this->getRequest()->getParam($level))
            {
                $params[$level] = $this->getRequest()->getParam($level);
            }
        }
        return $params;
    }

    function vehicleFinder()
    {
        return new VF_Vehicle_Finder(new VF_Schema());
    }
}