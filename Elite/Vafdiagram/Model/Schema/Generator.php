<?php
class Elite_Vafdiagram_Model_Schema_Generator extends Ne8Vehicle_Schema_Generator
{
    function generator()
    {
        return 'CREATE TABLE IF NOT EXISTS `elite_product_servicecode` (
				  `product_id` int(100) NOT NULL,
				  `service_code` varchar(100) NOT NULL,
				  PRIMARY KEY (`product_id`,`service_code`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				
				ALTER TABLE  `elite_import` ADD  `service_code` VARCHAR( 100 ) NOT NULL;
				';
    }
}