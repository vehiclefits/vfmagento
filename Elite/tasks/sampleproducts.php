<?php
require_once( dirname( __FILE__ ) . '/../Vaf/TestSuite.php' );

class SampleData
{
    protected $seedCsv;
    protected $fields;
    
    protected $i = 0;
    
    const price = 19;
    const description = 28;
    const short_description = 29;
    const category = 4;
    const SKU = 5;
    const name = 7;
    const urlKey = 13;
    const urlPath = 14;
    const productName = 591;
    
    function main()
    {
        
        $outputHandle = fopen('sampleProducts.csv','w');
        
        $this->seedCsv = fopen('products.csv','r');
        $fields = $this->fields();
        fputcsv($outputHandle,$fields);
        
        $seedRow = $this->row();
        $newCsv = '';
        $newCsv .= implode(',',$fields)."\n";
        
        $products = new Csv_Reader('ekow-new.csv');
        while($row = $products->getRow())
        {
            $newRow = $seedRow;
            
            // images
            $newRow[11] = '/' . $row[5] . '.jpg';
            $newRow[12] = '/' . $row[5] . '.jpg';
            $newRow[13] = '/' . $row[5] . '.jpg';
            
            $newRow[self::SKU] = $row[9];
            $newRow[self::name] = $row[7];
            $newRow[self::description] = $row[8];
            $newRow[self::short_description] = $row[8];
            $newRow[self::price] = $row[10];
            if( $row[4])
            {
                $category = $row[4];
            }
            else if($row[3])
            {
                $category = $row[3];
            }
            else if($row[2])
            {
                $category = $row[2];
            }
            else if($row[1])
            {
                $category = $row[1];
            }
            $newRow[self::category] = $category;
    
            fputcsv($outputHandle,$newRow);
        }
        
        echo 'data created to sampleProducts.csv';
    }
    
    function generateUniqueValues($row)
    {
        $row[self::SKU] = $this->newSku();
        $row[self::name] = $this->newName();
        $row[self::urlKey] = $this->newUrlKey();
        $row[self::urlPath] = $this->newUrlKey().'.html';
        $row[self::productName] = $this->newName();
        return $row;
    }
    
    function fields()
    {
        if( isset($this->fields))
        {
            return $this->fields;
        }
        return $this->fields = fgetcsv($this->seedCsv);
    }
    
    function row()
    {
        return fgetcsv($this->seedCsv);
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
