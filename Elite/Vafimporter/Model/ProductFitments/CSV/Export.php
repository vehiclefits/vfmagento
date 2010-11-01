<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_Export extends Elite_Vafimporter_Model_VehiclesList_CSV_Export
{
	/** @var Elite_Vaf_Model_Schema */
	protected $schema;
	
	protected function cols()
	{
		$return = $this->col( 'sku' );
		$return .= $this->col( 'universal' );
        $return .= parent::cols();
		$return .= $this->doCols();
		return $return;
	}
	
	protected function rows()
	{
		$return = '';
		$rowResult = $this->rowResult();
		$i = 0;
		foreach( $rowResult->fetchAll(Zend_Db::FETCH_OBJ) as $row )
		{
			$i++;
			$return .= $this->col( $row->sku );
			$return .= $this->col( $row->universal );
			$return .= $this->definitionCells($row);
			$return .= $this->doRow($row);
			$return .= "\n";
		}
		return $return;
	}
	
	protected function rowResult()
	{
		$select = $this->getReadAdapter()->select()
			->from( 'elite_Fitment', array( 'id','universal' ) );	
		foreach( $this->schema->getLevels() as $level )
		{
			$table = 'elite_level_'.$level;
			$condition = sprintf('%s.id = elite_Fitment.%s_id', $table, $level );
			$select->joinLeft( $table, $condition, array($level=>'title') );
		}
		$select->joinLeft( array('p'=>$this->getProductTable()), 'p.entity_id = elite_Fitment.entity_id', array('sku') );
		return $this->query($select);
	}
	
    protected function getProductTable()
    {
        $resource = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product;
        $table = $resource->getTable( 'catalog/product' );
        return $table;
    }
    
    private function doCols()
    {
        if( file_exists( ELITE_PATH  . '/Vafnote/Observer/Exporter/Fitments.php' ) )
        {
            $exporter = new Elite_Vafnote_Observer_Exporter_Fitments_CSV();
            return $exporter->doCols();
        }
    }
    
    private function doRow($row)
    {
        if( file_exists( ELITE_PATH  . '/Vafnote/Observer/Exporter/Fitments.php' ) )
        {
            $exporter = new Elite_Vafnote_Observer_Exporter_Fitments_CSV;
            return $exporter->doRow($row);
        }
    }
}
