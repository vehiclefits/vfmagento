<?php
class Elite_Vafdiagram_Model_Schema_Generator extends VF_Schema_Generator
{
    function generator()
    {
        return 'CREATE TABLE IF NOT EXISTS `elite_product_servicecode` (
				  `product_id` int(100) NOT NULL,
				  `service_code` varchar(100) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				
				ALTER TABLE  `elite_import` ADD  `service_code` VARCHAR( 100 ) NOT NULL;
				
				ALTER TABLE  `elite_definition` ADD  `service_code` VARCHAR( 100 ) NOT NULL;
				
				ALTER TABLE `elite_product_servicecode` ADD `category1_id` INT( 10 ) NOT NULL ,
ADD `category2_id` INT( 10 ) NOT NULL ,
ADD `category3_id` INT( 10 ) NOT NULL ,
ADD `category4_id` INT( 10 ) NOT NULL ;

				ALTER TABLE `elite_product_servicecode` ADD `illustration_id` VARCHAR( 10 )  NULL;
				
				ALTER TABLE  `elite_product_servicecode` ADD  `callout` INT( 3 ) NOT NULL;
				ALTER TABLE `elite_product_servicecode` ADD PRIMARY KEY ( `product_id` , `service_code` , `category1_id` , `category2_id` , `category3_id` , `category4_id` , `illustration_id` , `callout` ) ;
				';
    }
}