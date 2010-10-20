<?php
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
        return $this->code;
    }
    
    /**
    * @return string $color hex value of the color
    */
    function getColor()
    {
        return $this->color;
    }
    
    /**
    * @return string $name manufacturer's name for the color
    */
    function getName()
    {
        return $this->name;
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