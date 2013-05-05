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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vafpaint_Model_Paint
{
    /** @var string */
    protected $code;
    
    /** @var string */
    protected $name;
    
    /** @var string */
    protected $color;
    
    /** @var integer */
    protected $id;
    
    /**
    * @param string $code manufacturer's code for the color
    * @param string $name manufacturer's name for the color
    * @param string $color hex value of the color
    * @param integer id
    * 
    * @return Elite_Vaf_Model_Paint
    */
    function __construct( $code, $name, $color, $id = 0 )
    {
        $this->code = $code;
        $this->name = $name;
        $this->color = $color;
        $this->id = $id;
    }
    
    /**
    * @return string $code manufacturer's code for the color
    */
    function getCode()
    {
        return trim($this->code);
    }
    
    /**
    * @return string $color hex value of the color
    */
    function getColor()
    {
        return trim($this->color);
    }
    
    /**
    * @return string $name manufacturer's name for the color
    */
    function getName()
    {
        return trim($this->name);
    }
    
    /**
    * @return integer id
    */
    function getId()
    {
        return $this->id;
    }
    
    function render()
    {
		return '<div style="background-color:' . $this->getColor() . '; width:90px; height:30px;"></div>' . "\n" .
			'<br />' . $this->getName() . ' (' . $this->getCode() . ')';
    }
}