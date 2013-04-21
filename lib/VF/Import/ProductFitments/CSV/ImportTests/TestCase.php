<?php
abstract class VF_Import_ProductFitments_CSV_ImportTests_TestCase extends VF_Import_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    const SKU = 'sku';
    
    function mappingsImport($csvData)
    {
        return $this->mappingsImporterFromData($csvData)->import();
    }
          
    function mappingsImportFromFile($file)
    {
        return $this->mappingsImporterFromFile($file)->import();
    }    
    
    function mappingsImporterFromData($csvData)
    {
        $file = TEMP_PATH . '/mappings.csv';
        file_put_contents( $file, $csvData );
        return $this->mappingsImporterFromFile($file);
    }
    
    function mappingsImporterFromFile($csvFile)
    {
        return new VF_Import_ProductFitments_CSV_Import_TestSubClass($csvFile);
    }
    
    function getFitForSku( $sku, $schema = null )
    {
        if( is_null( $schema ) )
        {
            $schema = new VF_Schema;
        }
        
        $sql = sprintf(
            "SELECT `entity_id` from `test_catalog_product_entity` WHERE `sku` = %s",
            $this->getReadAdapter()->quote( $sku )
        );
        $r = $this->query( $sql );
        $product_id = $r->fetchColumn();
        $r->closeCursor();
        
        $sql = sprintf(
            "SELECT `%s_id` from `elite_1_mapping` WHERE `entity_id` = %d AND `universal` = 0",
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
        $finder = new VF_Vehicle_Finder( $schema );
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
            "SELECT `id` from `elite_1_mapping` WHERE `entity_id` = %d",
            $product_id
        );
        $r = $this->query( $sql );
        $id = $r->fetchColumn();
        $r->closeCursor();
        
        return $id;
    }

    function exportProductFitments()
    {
	$stream = fopen("php://temp", 'w');

	$exporter = new VF_Import_ProductFitments_CSV_ExportTests_TestSub();
	$exporter->export($stream);
	rewind($stream);

	$data = stream_get_contents($stream);
	return $data;
    }
}

class VF_Import_ProductFitments_CSV_Import_TestSubClass extends VF_Import_ProductFitments_CSV_Import
{
    function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}
