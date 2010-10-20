<?php
class Elite_Vaftire_Model_Schema_Generator extends Ne8Vehicle_Schema_Generator
{
    function generator()
    {
        return 'CREATE TABLE IF NOT EXISTS `elite_product_tire` (
              `entity_id` int(50) NOT NULL,
              `section_width` int(3) NOT NULL,
              `aspect_ratio` int(3) NOT NULL,
              `diameter` int(3) NOT NULL,
              `tire_type` int(1) NOT NULL,
              UNIQUE KEY `entity_id` (`entity_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
            
            CREATE TABLE IF NOT EXISTS `elite_vehicle_tire` (
			  `leaf_id` int(50) NOT NULL,
			  `section_width` int(3) NOT NULL,
			  `aspect_ratio` int(3) NOT NULL,
			  `diameter` int(3) NOT NULL,
			  `tire_type` int(1) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
            
            ALTER TABLE `elite_vehicle_tire` ADD UNIQUE (
            `leaf_id` ,
            `section_width` ,
            `aspect_ratio` ,
            `diameter` ,
            `tire_type`
            );
            '; 
    }
}