<?php
class Elite_Vafimporter_Admin_VafdefinitionsimporterController extends Mage_Adminhtml_Controller_Action
{ 
	protected $id;
    protected $entity;
    
    /** @var string */
    protected $messages = '';
    
    /** @var Elite_Vafimporter_Model_VehiclesList */
    protected $importer;
    
    /** @var string class name of importer to be used */
    protected $importerClass = '';
    
    function indexAction()
    {
        $this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()->createBlock('adminhtml/vafimporter_definitions', 'vafimporter/definitions' );
        $block->messages = $this->messages;
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function myIndexAction()
    {        
		if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
            try
            {
				$this->importer = $this->importer();
				$this->import();
			}
			catch( Exception $e )
			{
				$this->messages .= '<br />' . $e->getMessage();
			}
        }
    }
    
    function importer()
    {
        if( 'XML' == $_REQUEST['format'] )
        {
            $class = 'Elite_Vafimporter_Model_VehiclesList_XML_Import';
        }
        else
        {
            $class = 'Elite_Vafimporter_Model_VehiclesList_CSV_Import';
        }
        return new $class( $_FILES['file']['tmp_name'] ); 
    }
    
    function import()
    {
        // profiling
        $profiler = new My_Zend_Db_Profiler;
        Elite_Vaf_Helper_Data::getInstance()->getReadAdapter()->setProfiler($profiler);
        $profiler->setEnabled(true);
        
        try
        {
            $this->importer->import();
        }
        catch(Exception $e)
        {
            return $this->formatMessage('An exception occurred: ' . $e->getMessage() . '<br />' . $e->getTraceAsString());
        }
        
        if( isset($_REQUEST['format']) && 'XML' == $_REQUEST['format'] )
        {
            /** @todo put more meaningful stuff */
            $this->formatMessage('Done.');
        }
        else
        {
            $this->formatMessages();   
        }
        
        // profiling
        $totalTime    = $profiler->getTotalElapsedSecs();
      $queryCount   = $profiler->getTotalNumQueries();
      $longestTime  = 0;
      $longestQuery = null;

      foreach ($profiler->getQueryProfiles() as $query) {
//          echo $query->getQuery() . "<br /><br />";
          if ($query->getElapsedSecs() > $longestTime) {
              $longestTime  = $query->getElapsedSecs();
              $longestQuery = $query->getQuery();
          }
      }
      $this->formatMessage( '<strong>Performance Report</strong>' );
      $this->formatMessage( 'Executed ' . $queryCount . ' queries in ' . number_format($totalTime < 0 ? 0.001 : $totalTime,3) . ' seconds');
      $avg = $totalTime / $queryCount;
      $this->formatMessage( 'Average query length: ' . number_format($avg < 0 ? 0 : $avg ,2) . ' seconds');
      $perSec = $queryCount / $totalTime;
      $this->formatMessage( 'Queries per second: ' . $perSec < 0 ? 'n/a' : number_format( $perSec,2) );
      $this->formatMessage( 'Longest query length: ' . number_format($longestTime,1) . ' seconds' );
    }
    
    /** @todo move to importer model */
    protected function formatMessages()
    {
        $schema = new Elite_Vaf_Model_Schema();
            
        $this->formatMessage( '<strong>Vehicles List Import Results</strong>' );
        $this->formatMessage( number_format($this->importer->getCountAddedVehicles()) . ' Vehicles Added' );
        foreach( $schema->getLevels() as $level )
        {
            $this->formatMessage( number_format($this->importer->getCountAddedByLevel($level)) . ' ' . $level . 's Added' );
        }
        if( $this->importer->getCountSkippedDefinitions() > 0 )
        {
            $this->formatMessage( number_format( $this->importer->getCountSkippedDefinitions() ) . ' vehicles skipped because they already existed, your csv contained overlapping ranges or duplicate vehicles.' );
        }
        $this->doFormatMessages();
    }
    
    protected function doFormatMessages()
    {
    }
    
    protected function formatMessage( $message )
    {
        $this->messages .= $message . '<br />';
    }
    
    protected function getSaveUrl()
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/*', array(
            '_current'=>true, 'back'=>null
        ));
        return $url;
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
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
}

class My_Zend_Db_Profiler extends Zend_Db_Profiler
{
    /**
     * Starts a query.  Creates a new query profile object (Zend_Db_Profiler_Query)
     * and returns the "query profiler handle".  Run the query, then call
     * queryEnd() and pass it this handle to make the query as ended and
     * record the time.  If the profiler is not enabled, this takes no
     * action and immediately returns null.
     *
     * @param  string  $queryText   SQL statement
     * @param  integer $queryType   OPTIONAL Type of query, one of the Zend_Db_Profiler::* constants
     * @return integer|null
     */
    public function queryStart($queryText, $queryType = null)
    {
//        file_put_contents('/var/www/query.log',$queryText."\n\n",FILE_APPEND);
        return parent::queryStart($queryText, $queryType);
    }
}