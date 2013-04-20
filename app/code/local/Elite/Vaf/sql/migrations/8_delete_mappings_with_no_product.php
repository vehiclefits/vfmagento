<?php
class Vaf8
{
    function deleteMappingsWithoutProduct()
    {
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
        $db->query("delete from elite_mapping where entity_id = 0");
    }
}
Vaf8::deleteMappingsWithoutProduct();
