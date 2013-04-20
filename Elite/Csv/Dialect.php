<?php
/**
 * CSV Utils - Dialect
 * 
 * This is a Csv Dialect - it tells readers and writers the format of a csv file
 * Please read the LICENSE file
 * @copyright Luke Visinoni <luke.visinoni@gmail.com>
 * @author Luke Visinoni <luke@mc2design.com>
 * @package Csv
 * @license GNU Lesser General Public License
 * @version 0.1
 */

/**
 * Tells readers and writes the format of a csv file
 * @package Csv
 */
class Csv_Dialect
{
    /**
     * Instructs Csv_Writer to quote only columns with special characters such as the
     * delimiter character, quote character or any of the characters in line terminator
     */
    const QUOTE_MINIMAL = 0;
    /**
     * Instructs Csv_Writer to quote all columns
     */
    const QUOTE_ALL = 1;
    /**
     * Instructs Csv_Writer to quote all columns that aren't numeric
     */
    const QUOTE_NONNUMERIC = 2;
    /**
     * Instructs Csv_Writer to quote no columns
     */
    const QUOTE_NONE = 3;
    /**
     * @var string The character used to seperate fields in a csv file
     */
    public $delimiter = ",";
    /**
     * @var string The character used to quote columns
     */
    public $quotechar = '"';
    /**
     * @var string The character used to escape the quotechar if it appears in a column
     */
    public $escapechar = "\\";
    /**
     * @var string This is a remnant of me copying functionality from python's csv module
     * @todo Implement this
     */
    public $doublequote;
    /**
     * @var string This is a remnant of me copying functionality from python's csv module
     * @todo Implement this
     */
    public $skipinitialspace;
    /**
     * @var boolean Set to true to ignore blank lines when reading
     */
    public $skipblanklines = true;
    /**
     * @var string The character(s) used to terminate a line in the csv file
     */
    public $lineterminator = "\r\n";
    /**
     * @var integer Set to any of the self::QUOTE_* constants above
     */
    public $quoting = self::QUOTE_NONE;
    
    function __construct($options = null) {
    
        if (is_array($options)) {
            //pr($options);
            $properties = array();
            foreach ($this as $property => $value) $properties[$property] = $value;
            foreach (array_intersect_key($options, $properties) as $property => $value) {
                $this->{$property} = $value;
            }
        }
     
    }
}