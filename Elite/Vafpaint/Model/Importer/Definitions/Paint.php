<?php
class Elite_Vafpaint_Model_Importer_Definitions_Paint extends Elite_Vafimporter_Model_VehiclesList_CSV_Import
{
    function importRow($row)
    {   
        $this->row_number++;
        $this->oldImportRow($row);
    }
    
    /**
    * @param array $row
    * @param VF_Vehicle|boolean the vehicle, false if none (for example, when setting a product as universal)
    */
    function doImportRow( $row, $vehicle )
    {
         $paint = new Elite_Vafpaint_Model_Paint( $row[3], $row[4], $row[5]  );
         $this->addPaintCode( $vehicle, $paint );
    }
    
    function addPaintCode( VF_Vehicle $vehicle, Elite_Vafpaint_Model_Paint $paint )
    {
        $schema = new VF_Schema();
        $sql = sprintf(
            "
            REPLACE INTO
                `elite_mapping_paint`
            ( `mapping_id`, `code`, `name`, `color` )
                VALUES
            ( %d, %s, %s, %s )
            ",
            (int)$vehicle->getLevel( $schema->getLeafLevel() )->getId(),
            $this->getReadAdapter()->quote( $paint->getCode() ),
            $this->getReadAdapter()->quote( $paint->getName() ),
            $this->getReadAdapter()->quote( $paint->getColor() )
        );
        $this->query($sql);
    }
    
}