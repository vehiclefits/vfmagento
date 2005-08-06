<?php
class Vaf18
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('DROP TABLE elite_import');
        $db->query('
CREATE TABLE IF NOT EXISTS `elite_import` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `make` varchar(255) NOT NULL,
  `make_id` int(50) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(50) NOT NULL,
  `year` varchar(255) NOT NULL,
  `year_id` int(50) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `universal` int(1) DEFAULT \'0\',
  `existing` int(1) NOT NULL,
  `line` int(255) NOT NULL,
  `mapping_id` int(255) NOT NULL,
  `note_message` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
          
        
    }
}
Vaf18::run();

