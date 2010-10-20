<?php
require_once 'Csv/Dialect.php';
class Csv_Dialect_Excel extends Csv_Dialect
{
    public $delimiter = ',';
    public $quotechar = '"';
    public $escapechar = '\\';
    // public $doublequote = true;
    // public $skipinitialspace = false;
    public $lineterminator = '\r\n';
    public $quoting = Csv_Dialect::QUOTE_MINIMAL;
}