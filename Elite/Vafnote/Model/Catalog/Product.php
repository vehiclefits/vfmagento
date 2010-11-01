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
        $FitmentId = $this->getFitmentId($vehicle);
        $note = $this->noteFinder()->findByCode($noteCode);
        $this->noteFinder()->insertNoteRelationship($FitmentId,$note->id);
    }
    
    function numberOfNotes(Elite_Vaf_Model_Vehicle $vehicle)
    {
        $FitmentId = $this->getFitmentId($vehicle);
        return count($this->noteFinder()->getNotes($FitmentId));
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