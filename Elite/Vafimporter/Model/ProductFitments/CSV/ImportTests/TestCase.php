<?php
abstract class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase extends Elite_Vafimporter_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    const SKU = 'sku';
    
    function FitmentsImport($csvData)
    {
        return $this->FitmentsImporterFromData($csvData)->import();
    }
          
    function FitmentsImportFromFile($file)
    {
        return $this->FitmentsImporterFromFile($file)->import();
    }    
    
    function FitmentsImporterFromData($csvData)
    {
        $file = TESTFILES . '/Fitments.csv';
        file_put_contents( $file, $csvData );
        return $this->FitmentsImporterFromFile($file);
    }
    
    function FitmentsImporterFromFile($csvFile)
    {
        return new Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass($csvFile);
    }
    
    function getFitForSku( $sku, $schema = null )
    {
        if( is_null( $schema ) )
        {
            $schema = new Elite_Vaf_Model_Schema;
        }
        
        $sql = sprintf(
            "SELECT `entity_id` from `test_catalog_product_entity` WHERE `sku` = %s",
            $this->getReadAdapter()->quote( $sku )
        );
        $r = $this->query( $sql );
        $product_id = $r->fetchColumn();
        $r->closeCursor();
        
        $sql = sprintf(
            "SELECT `%s_id` from `elite_Fitment` WHERE `entity_id` = %d AND `universal` = 0",
            $schema->getLeafLevel(),
            $product_id
        );
        $r = $this->query( $sql );
        $leaf_id = $r->fetchColumn();
        $r->closeCursor();
        
        if( !$leaf_id )
        {
            return false;
        }
        $finder = new Elite_Vaf_Model_Vehicle_Finder( $schema );
        return $finder->findByLeaf( $leaf_id );
    }

    function getFitIdForSku( $sku )
    {
        $sql = sprintf(
            "SELECT `entity_id` from `test_catalog_product_entity` WHERE `sku` = %s",
            $this->getReadAdapter()->quote( $sku )
        );
        $r = $this->query( $sql );
        $product_id = $r->fetchColumn();
        $r->closeCursor();
        
        $sql = sprintf(
            "SELECT `id` from `elite_Fitment` WHERE `entity_id` = %d",
            $product_id
        );
        $r = $this->query( $sql );
        $id = $r->fetchColumn();
        $r->closeCursor();
        
        return $id;
    }
}

class Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass extends Elite_Vafimporter_Model_ProductFitments_CSV_Import
{
    function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}
