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
class VF_Import_VehiclesList_BaseExport
{
    function schema()
    {
        return new VF_Schema();
    }
    
    protected function rowResult()
    {
        $select = $this->getReadAdapter()->select()
            ->from( array('d' => $this->schema()->definitionTable()) );    
        foreach( $this->schema()->getLevels() as $level )
        {
            $table = $this->schema()->levelTable($level);
            $condition = sprintf('%s.id = d.%s_id', $table, $level );
            $select
                ->joinLeft( $table, $condition, array($level=>'title') )
                ->where('d.' . $level . '_id != 0');
        }
        return $this->query($select);
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}