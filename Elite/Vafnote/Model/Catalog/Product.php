<?php
class Elite_Vafnote_Model_Catalog_Product
{
    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;
    
    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap )
    {
        $this->wrappedProduct = $productToWrap;
    }
    
    function addNote( Elite_Vaf_Model_Vehicle $vehicle, $noteCode )
    {
        $mappingId = $this->getMappingId($vehicle);
        $note = $this->noteFinder()->findByCode($noteCode);
        $this->noteFinder()->insertNoteRelationship($mappingId,$note->id);
    }
    
    function numberOfNotes(Elite_Vaf_Model_Vehicle $vehicle)
    {
        return count($this->notes($vehicle));
    }
    
    function notesCodes(Elite_Vaf_Model_Vehicle $vehicle)
    {
        $codes = array();
        foreach($this->notes($vehicle) as $note)
        {
        	$codes[] = $note->code;
        }
        return $codes;
    }
    
    
    function notes(Elite_Vaf_Model_Vehicle $vehicle)
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