<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class VF_Import_Abstract
{
	protected $entityIds = array(); 
	
	protected $file;
	
	/** @var Csv_Reader */
    protected $reader;
    
    /** @var array Field positions keyed by the field's names */
    protected $fieldPositions;
    
    /** @var Zend_Log */
    protected $log;
    
    function __construct( $file )
    {
        $this->file = $file;
        $this->reader = new Csv_Reader( $this->file );
    }
    
    function getFieldPosition( $fieldName )
    {
        $positions = $this->getFieldPositions();
        if(isset($positions[$fieldName]))
        {
            return $positions[$fieldName];
        }
        if(isset($positions[str_replace(' ','_',$fieldName)]))
        {
            return $positions[str_replace(' ','_',$fieldName)];
        }
        if(isset($positions[str_replace('_',' ',$fieldName)]))
        {
            return $positions[str_replace('_',' ',$fieldName)];
        }
        return false;
    }

    /** @return array Field positions keyed by the field's names */
    function getFieldPositions()
    {
        if( is_array( $this->fieldPositions ))
        {
            return $this->fieldPositions;
        }
        $row = $this->doGetFieldPositions();
        if(false == $row)
        {
            return false;
        }
        $this->fieldPositions = array_flip($row);
        foreach( $this->fieldPositions as $label => $position )
        {
            unset( $this->fieldPositions[ $label ] );
            $this->fieldPositions[ trim($label) ] = $position;
        }

        return $this->fieldPositions;
    }

    function doGetFieldPositions()
    {
        return $this->getReader()->getRow();
    }

    function schema()
    {
        return $this->getSchema();
    }

    function getSchema()
    {
        if(isset($this->schema))
        {
            return $this->schema;
        }
        $schema = new VF_Schema();
        $schema->setConfig($this->getConfig());
        return $this->schema = $schema;
    }
    
    /** @return Csv_Reader */
    function getReader()
    {
        return $this->reader;
    }
    
    function getFieldValue( $fieldName, $row )
    {
        $position = $this->getFieldPosition($fieldName);
        if( false === $position )
        {
            return false;
        }
        return isset( $row[$position] ) ? trim($row[$position]) : '';
    }
    
    /**
    * @var string sku
    * @return mixed | integer entity_id of corresponding product row | false if sku is invalid
    */
    function productId($sku)
    {
        if( isset($this->entityIds[$sku] ))
        {
			return $this->entityIds[$sku];
        }
        $sql = sprintf(
            "SELECT * FROM %s WHERE sku = %s LIMIT 1",
            $this->getProductTable(),
            $this->getReadAdapter()->quote($sku)
        );
        
        $result = $this->query($sql);
        $product_row = $result->fetchObject();
        $result->closeCursor();
        
        if( !$product_row )
        {
            return false;
        }
        $entity_id = (int)$product_row->entity_id;
        $this->entityIds[$sku] = $entity_id;
        return $entity_id;
    }
    
     /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
    
    /** @return Zend_Db_Statement_Interface */
    function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    function getProductTable()
    {
        $resource = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product;
        $table = $resource->getTable( 'catalog/product' );
        return $table;
    }
    
    function log($message, $logLevel=null)
    {
        if(!$logLevel)
        {
            $logLevel = Zend_Log::INFO;
        }
        if(!$this->getLog())
        {
            return;
        }
        $this->getLog()->log($message, $logLevel);
    }
    
    /** @return Zend_log */
    function getLog()
    {
        return $this->log;
    }
    
    function setLog( Zend_Log $log )
    {
        $this->log = $log;
    }
}