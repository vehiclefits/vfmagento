<?php

/** The association between a product ID and a definition */
class VF_Mapping implements VF_Configurable
{

    protected $product_id, $vehicle;
    /** @var Zend_Config */
    protected $config;

    function __construct($product_id, VF_Vehicle $vehicle)
    {
        $this->product_id = $product_id;
        $this->vehicle = $vehicle;
    }

    function getConfig()
    {
        if (!$this->config instanceof Zend_Config)
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
        $this->config = $config;
    }

    function vehicle()
    {
        return $this->vehicle;
    }

    function save()
    {
        if (!(int) $this->product_id)
        {
            throw new Exception('Trying to insert a mapping with no product ID');
        }
        $schema = new VF_Schema;
        $schema->setConfig($this->getConfig());
        $levels = $schema->getLevels();

        $select = $this->getReadAdapter()->select()
                        ->from('elite_mapping', array('id'));
        foreach ($this->vehicle->toValueArray() as $level => $id)
        {
            $select->where($this->inflect($level) . '_id = ?', $id);
        }
        $select->where('entity_id = ?', $this->product_id);

        $id = (int) $select->query()->fetchColumn();
        if (0 !== $id)
        {
            return $id;
        }

        $columns = '';
        $values = '';
        foreach ($levels as $level)
        {
            $columns .= '`' . $this->inflect($level) . '_id`,';
            $values .= $this->inflect($this->vehicle->getLevel($level)->getId());
            $values .= ',';
        }
        $query = sprintf(
                        '
            INSERT INTO
                `elite_mapping`
            (
                ' . $columns . '
                `entity_id`
            )
            VALUES
            (
                ' . $values . '
                %d
            )
            ',
            (int) $this->product_id
        );
        $r = $this->query($query);
        return $this->getReadAdapter()->lastInsertId();
    }

    /** @return Zend_Db_Statement_Interface */
    protected function query($sql)
    {
        return $this->getReadAdapter()->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

    function inflect($identifier)
    {
        return str_replace(' ', '_', $identifier);
    }

}