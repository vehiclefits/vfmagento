<?php
abstract class VF_Year_Abstract
{
    protected $threshold = 25;
    protected $Y2KMode = true;
    
    function setThreshold($threshold)
    {
        $this->threshold = $threshold;
    }
    
    function setY2KMode($bool)
    {
        $this->Y2KMode = $bool;
    }
}