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
class Elite_Vaf_Admin_VfdataController extends Mage_Adminhtml_Controller_Action
{
    /** @var Zend_Config */
    protected $config;

    protected $block;

    function indexAction()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade()) {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }

        $this->loadLayout();
        $this->_setActiveMenu('vaf');

        $this->block = $this->getLayout()
            ->createBlock('core/template', 'vaf');
        $this->doIndexAction();
        $this->_addContent( $this->block );
        $this->renderLayout();
    }

    function doIndexAction()
    {
        $config = $this->getConfig();
        $this->block->setTemplate('vf/vaf/vfdata.phtml');
        $form = $this->form();
        $this->block->form = $form;

        if($this->getRequest()->getParam('download')) {
            $download_url = 'http://data.vehiclefits.com/api/download?token='.$config->vfdata->api_token;
            $local_file = sys_get_temp_dir().'/'.uniqid();
            $local_stream = fopen($local_file,'w');

            $download_stream = fopen($download_url, 'r');
            while (!feof($download_stream)) {
                $buffer = fread($download_stream, 512);  // use a buffer of 512 bytes
                fwrite($local_stream, $buffer);
            }
            fclose($download_stream);
            fclose($local_stream);

            $importer = new VF_Import_VehiclesList_CSV_Import($local_file);
            $importer->import();
            $this->block->downloaded=true;
            return;
        }

        if($this->getRequest()->getParam('upload')) {
            $upload_url = 'http://data.vehiclefits.com/api/upload?token='.$config->vfdata->api_token;

            $local_file = sys_get_temp_dir().'/'.uniqid();
            $local_stream = fopen($local_file,'w');

            $exporter = new VF_Import_VehiclesList_CSV_Export();
            $exporter->export($local_stream);

            $ch = curl_init($upload_url );
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, file_get_contents($local_file));
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec( $ch );
            $this->block->uploaded=$response;
        }

        if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())) {
            $config->vfdata->api_token = $form->getValue('api_token');
            $writer = new Zend_Config_Writer_Ini(array('config'   => $config,
                'filename' => ELITE_CONFIG));
            echo $writer->write();
        }
    }

    function form()
    {
        $form = new Zend_Form;
        $form->setView(new Zend_View);
        $form->addElement('text','api_token',array(
            'label'=>'API Token',
            'required'=>true,
            'value'=>$this->getConfig()->vfdata->api_token
        ));
        $form->addElement('submit','save',array(
            'label'=>'Save'
        ));
        return $form;
    }

    function getConfig()
    {
        if (!$this->config instanceof Zend_Config) {
            $this->config = VF_Singleton::getInstance()->getConfig();
        }
        return $this->config;
    }

}