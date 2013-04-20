<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
$db->query("CREATE TABLE `elite_product_tire` (
    `entity_id` INT( 50 ) NOT NULL ,
    `section_width` INT( 3 ) NOT NULL ,
    `aspect_ratio` INT( 3 ) NOT NULL ,
    `diameter` INT( 3 ) NOT NULL ,
    UNIQUE (
    `entity_id`
    )
) ENGINE = INNODB ;");