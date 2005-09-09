<?php
class VF_Import_ProductFitments_CSV_ExportTests_TestSub extends VF_Import_ProductFitments_CSV_Export
{
    protected function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}