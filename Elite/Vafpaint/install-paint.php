<?php
require_once( 'app/Mage.php' );
require_once( 'app/code/local/Elite/Vaf/Model/Schema/Generator.php' );
Mage::app();
$helper = Elite_Vaf_Helper_Data::getInstance();
$generator = new Elite_Vafpaint_Model_Schema_Generator;

$sql = $generator->install();
foreach( explode(';',$sql) as $statement )
{
    if(!trim($statement))
    {
        return;
    }
    try{
        $helper->getReadAdapter()->query( $statement );
    }catch(Exception$e){
        echo'DEBUG MODE:'.$e->getMessage();
    }
}
echo 'installed paint';
?>