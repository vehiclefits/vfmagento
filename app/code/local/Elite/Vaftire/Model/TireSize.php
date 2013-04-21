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