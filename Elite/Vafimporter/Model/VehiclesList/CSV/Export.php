<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_Export extends Elite_Vafimporter_Model_VehiclesList_BaseExport
{
	function export()
	{
		$this->schema = $this->schema();
		
		$return = $this->cols();
		$return .= "\n";
		$return .= $this->rows();
		
		return $return;
	}
	
	protected function cols()
	{
		$return = '';
		foreach( $this->schema->getLevels() as $level )
		{
			$insertComma = $level != $this->schema->getLeafLevel();
			$return .= $this->col( $level, $insertComma );
		}
		return $return;
	}
	
	protected function col( $name, $insertComma = true )
	{
		return $name . ( $insertComma ? "," : "" );
	}
	
	protected function rows()
	{
		$return = '';
		$rowResult = $this->rowResult();
		while( $row = $rowResult->fetch(Zend_Db::FETCH_OBJ) )
		{
			$return .= $this->definitionCells($row);
			$return .= "\n";
		}
		return $return;
	}
	
	protected function definitionCells($row)
	{
		$return = '';
		foreach( $this->schema->getLevels() as $level )
		{
			$insertComma = $level != $this->schema->getLeafLevel();
			$return .= $this->col( $row->$level, $insertComma );
		}
		return $return;
	}

}