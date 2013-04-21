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
class Elite_Vafnote_Model_Catalog_Product
{
    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;
    
    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap )
    {
        $this->wrappedProduct = $productToWrap;
    }
    
    function addNote( VF_Vehicle $vehicle, $noteCode )
    {
        $mappingId = $this->getMappingId($vehicle);
        $note = $this->noteFinder()->findByCode($noteCode);
        $this->noteFinder()->insertNoteRelationship($mappingId,$note->id);
    }
    
    function numberOfNotes(VF_Vehicle $vehicle)
    {
        return count($this->notes($vehicle));
    }
    
    function notesCodes(VF_Vehicle $vehicle)
    {
        $codes = array();
        foreach($this->notes($vehicle) as $note)
        {
        	$codes[] = $note->code;
        }
        return $codes;
    }
    
    
    function notes(VF_Vehicle $vehicle)
    {
        $mappingId = $this->getMappingId($vehicle);
        return $this->noteFinder()->getNotes($mappingId);
    }
    
    function noteFinder()
    {
        return new Elite_Vafnote_Model_Finder;
    }
    
    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedProduct,$methodName);
        return call_user_func_array( $method, $arguments );
    }
}