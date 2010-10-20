<?php
class Csv_Reader_String extends Csv_Reader
{
    /**
     * 
     */
    function __construct($string, Csv_Dialect $dialect = null) {
    
        if (is_null($dialect)) $dialect = new Csv_Dialect;
        $this->dialect = $dialect;
        $this->handle = fopen("php://temp", 'w+');
        fwrite($this->handle, $string);
        unset($string);
        if ($this->handle === false) throw new Csv_Exception_FileNotFound('File does not exist or is not readable: "' . $path . '".');
        $this->rewind();
    
    }
}