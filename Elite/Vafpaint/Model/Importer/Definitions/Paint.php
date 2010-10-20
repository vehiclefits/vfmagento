<?php
class Elite_Vafpaint_Model_Importer_Definitions_Paint extends Elite_Vafimporter_Model_VehiclesList_CSV_Import
{

    /**
    * @param array $row
    * @param Elite_Vaf_Model_Vehicle|boolean the vehicle, false if none (for example, when setting a product as universal)
    */
    function doImportRow( $row, $vehicle )
    {
         $paint = new Elite_Vafpaint_Model_Paint( $row[3], $row[4], $row[5]  );
         $this->addPaintCode( $vehicle, $paint );
    }
    
    function addPaintCode( Elite_Vaf_Model_Vehicle $vehicle, Elite_Vafpaint_Model_Paint $paint )
    {
        $schema = new Elite_Vaf_Model_Schema();
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