<?php
class Vaf20
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('ALTER TABLE `elite_product_servicecode` DROP PRIMARY KEY ');
        $db->query('ALTER TABLE `elite_product_servicecode` ADD PRIMARY KEY ( `product_id` , `service_code` , `category1_id` , `category2_id` , `category3_id` , `category4_id` , `illustration_id` , `callout` ) ');
    }
}
Vaf20::run();