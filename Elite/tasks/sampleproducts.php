<?php
require_once( dirname( __FILE__ ) . '/../Vaf/TestSuite.php' );

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
        $fields = $this->fields();
        $row = $this->row();
        $newCsv = '';
        $newCsv .= implode(',',$fields)."\n";
        for( $this->i = 1; $this->i <= 4; $this->i++ )
        {
            $newRow = $this->generateUniqueValues($row);
            foreach($newRow as $k => $value )
            {
				$newRow[$k] = '"' . $value . '"';
            }
            $newCsv .= implode(',',$newRow)."\n";
            
        }
        file_put_contents('sampleProducts.csv',$newCsv);
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
        return $this->fields = $this->seedCsv->getRow();
    }
    
    function row()
    {
        return $this->seedCsv->getRow();
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
