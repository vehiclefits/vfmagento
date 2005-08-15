<?php
class Elite_Vafsitemap_Admin_VafsitemapController extends Mage_Adminhtml_Controller_Action
{ 
    
    function exportAction()
    {
    	$this->checkVersion();
        
        if( isset($_REQUEST['go']) )
        {
        	if( isset($_REQUEST['format']) && 'csv' == $_REQUEST['format'] )
            {
                $sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_GoogleBase(Elite_Vaf_Helper_Data::getInstance()->getConfig());
                
                $basePath = Mage::getBaseDir() . '/var/vaf-sitemap-csv';
                if(file_exists($basePath))
                {
                    $this->recursiveDelete($basePath);
                }
                mkdir($basePath);
                
                $csv = $sitemap->csv($_GET['store']);
                file_put_contents($basePath.'/google-base.csv',$csv);
                echo 'Sitemap created to ' . $basePath; exit();
            }
            else
            {
                $sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_XML();
                $size = $sitemap->getCollectionSize();
                $files = array();
                $chunkSize = 50000;
                $basePath = Mage::getBaseDir() . '/var/vaf-sitemap-xml';
                if(file_exists($basePath))
                {
                    $this->recursiveDelete($basePath);
                }
                mkdir($basePath);
                
                for( $i=0; $i<=$size; $i+=$chunkSize )
                {
                    $xml = $sitemap->xml($_GET['store'], $i==0?0:$i+1, $i+$chunkSize );
                    $file = $basePath.'/'.floor($i/$chunkSize).'.xml';
                    array_push($files,basename($file));
                    file_put_contents($file, $xml);
                }
                file_put_contents($basePath.'/sitemap-index.xml',$sitemap->sitemapIndex($files));
                echo 'Sitemap created to ' . $basePath; exit();
			}

        }
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/export');
        
        $block = $this->getLayout()->createBlock('adminhtml/template', 'vafsitemap_export' )->setTemplate('vafsitemap/export.phtml');
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    protected function checkVersion()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }
    }
    
    /**
     * Delete a file or recursively delete a directory
     *
     * @param string $str Path to file or directory
     */
    function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                $this->recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
}
