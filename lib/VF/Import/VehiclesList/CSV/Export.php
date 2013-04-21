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

class VF_Import_VehiclesList_CSV_Export extends VF_Import_VehiclesList_BaseExport
{

    function export($stream)
    {
	$this->schema = $this->schema();

	fwrite($stream, $this->cols());
	fwrite($stream, "\n");
	$this->rows($stream);
    }

    protected function cols()
    {
	$return = '';
	foreach ($this->schema->getLevels() as $level)
	{
	    $insertComma = $level != $this->schema->getLeafLevel();
	    $return .= $this->col($level, $insertComma);
	}
	return $return;
    }

    protected function col($name, $insertComma = true)
    {
	return $name . ( $insertComma ? "," : "" );
    }

    protected function rows($stream)
    {
	$rowResult = $this->rowResult();
	while ($row = $rowResult->fetch(Zend_Db::FETCH_OBJ))
	{
	    fwrite($stream, $this->definitionCells($row));
	    fwrite($stream, "\n");
	}
    }

    protected function definitionCells($row)
    {
	$return = '';
	foreach ($this->schema->getLevels() as $level)
	{
	    $insertComma = $level != $this->schema->getLeafLevel();
	    $return .= $this->col($row->$level, $insertComma);
	}
	return $return;
    }

}