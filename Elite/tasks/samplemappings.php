<?php
require_once( dirname( __FILE__ ) . '/../../../../Mage.php' );
require_once( dirname( __FILE__ ) . '/../Vaf/bootstrap.php' );
Mage::app();

class SampleData
{
    protected $seedCsv;
    protected $fields;
    
    protected $i = 0;
    
    const SKU = 5;
    const name = 7;
    const urlKey = 13;
    const urlPath = 14;
    const productName = 591;
    
    function main()
    {
        $this->seedCsv = new Csv_Reader('products.csv');
        $newCsv = '';
        $newCsv .= "sku,make,model,year\n";
        for( $this->i = 1; $this->i <= 300; $this->i++ )
        {
             $line = "";
             $line .= 'YJSU-20';
             $line .= ",";
             $line .= 'make' . rand(1,25);
             $line .= ",";
             $line .= 'model' . rand(1,25);
             $line .= ",";
             
             $year = rand(1950,2010);
             $line .= $year;
            
            $newCsv .= $line . "\n";
        }
        $file = 'E:\dev\vaf\app\code\local\Elite\tasks\sampleFitments.csv';
        file_put_contents($file,$newCsv);
        $importer = new Elite_Vafimporter_Model_ProductFitments_CSV_Import($file);
        $importer->import();
        echo 'data imported';
    }

    function newSku()
    {
        return 'sku'.$this->i;
    }
    
    function newName()
    {
        return 'product'.$this->i;
    }
    
    function newUrlKey()
    {
        return 'product'.$this->i;
    }

}

$cli = new SampleData();
$cli->main();