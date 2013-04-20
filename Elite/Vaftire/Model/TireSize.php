<?php
/// written like this: 205/55/16
// section width/aspect ratio/diameter
class Elite_Vaftire_Model_TireSize
{
    const SECTION_WIDTH = 1;
    const ASPECT_RATIO = 2;
    const OUTSIDE_DIAMETER = 3;
    
    /** @var integer Section Width */
    protected $sectionWidth;
    
    /** @var integer Aspect Ratio */
    protected $aspectRatio;
    
    /** @var integer Diameter */
    protected $diameter;
    
    function __construct($sectionWidth,$aspectRatio,$diameter)
    {
        $this->sectionWidth = $sectionWidth;
        $this->aspectRatio = $aspectRatio;
        $this->diameter = $diameter;
    }
    
    static function create($formattedString)
    {
        preg_match('#([0-9]+)/([0-9]+)-([0-9]+)#', $formattedString, $matches );
        if(!count($matches))
        {
            throw new Elite_Vaftire_Model_TireSize_InvalidFormatException('missing section width');
        }
        return new Elite_Vaftire_Model_TireSize($matches[self::SECTION_WIDTH], $matches[self::ASPECT_RATIO], $matches[self::OUTSIDE_DIAMETER] );
    }
    
    function sectionWidth()
    {
        return $this->sectionWidth;
    }
    
    function aspectRatio()
    {
        return $this->aspectRatio;
    }
    
    function diameter()
    {
        return $this->diameter;
    }
    
    function __toString()
    {
        return sprintf('%s/%s-%s', $this->sectionWidth(), $this->aspectRatio(), $this->diameter() );
    }
    
}