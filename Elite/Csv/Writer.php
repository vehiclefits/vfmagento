<?php
/**
 * CSV Utils
 * 
 * This is a csv writer - basically it writest a csv file from an array
 * Please read the LICENSE file
 * @copyright Luke Visinoni <luke.visinoni@gmail.com>
 * @author Luke Visinoni <luke@mc2design.com>
 * @package Csv
 * @license GNU Lesser General Public License
 * @version 0.1
 */
require_once 'Csv/Dialect.php';
require_once 'Csv/Exception.php';
require_once 'Csv/Exception/CannotAccessFile.php';
/**
 * Provides an easy-to-use interface for writing csv-formatted text files. It
 * does not make use of the PHP5 function fputcsv. It provides quite a bit of
 * flexibility. You can specify just about everything about how it writes csv
 * @package Csv
 * @subpackage Csv_Writer
 */
class Csv_Writer
{
    /**
     * The filename of the file we're working on
     * @var string
     * @access protected
     */
    protected $filename;
    /**
     * Holds an instance of Csv_Dialect - tells writer how to write
     * @var Csv_Dialect 
     * @access protected
     */
    protected $dialect;
    /**
     * Holds the file resource
     * @var resource
     * @access protected
     */
    protected $handle;
    /**
     * Contains the in-menory data waiting to be written to disk
     * @var array
     * @access protected
     */
    protected $data = array();
    /**
     * Class constructor
     *
     * @param resource|string Either a valid filename or a valid file resource
     * @param Csv_Dialect A Csv_Dialect object
     * @todo: Allow the user to pass in a file handle (this way they can specify
     *        to append rather than overwrite or visa versa)
     */
    function __construct($file, $dialect = null) {
    
        if (is_null($dialect)) $dialect = new Csv_Dialect();
        if (is_resource($file))
            $this->handle = $file;
        else
            $this->filename = $file;
        
        $this->dialect = $dialect;
    
    }
    /**
     * Get the current Csv_Dialect object
     *
     * @returns Csv_Dialect object
     * @access public
     */
    function getDialect() {
    
        return $this->dialect;
    
    }
    /**
     * Change the dialect this csv reader is using
     *
     * @param Csv_Dialect the current Csv_Dialect object
     * @access public
     */
    function setDialect(Csv_Dialect $dialect) {
    
        $this->dialect = $dialect;
    
    }
    /**
     * Get the filename attached to this writer (unless none was specified)
     *
     * @return string|null The filename this writer is attached to or null if it
     *         was passed a resource and no filename
     * @todo Add a functions file so that you can use convenience functions like
     *       get('variable', 'default')
     */
    function getPath() {
    
        return $this->filename;
    
    }
    /**
     * Write a single row to the file
     *
     * @param array An array representing a row of data to be written
     * @access public
     */
    function writeRow(Array $row) {
    
        $this->data[] = $row;
    
    }
    /**
     * Write multiple rows to file
     *
     * @param array An two-dimensional array representing rows of data to be written
     * @access public
     */
    function writeRows($rows) {
    
        //if ($rows instanceof Csv_Writer) $rows->reset();
        foreach ($rows as $row) {
            $this->writeRow($row);
        }
    
    }
    /**
     * Writes the data to the csv file according to the dialect specified
     * This method is called by close()
     *
     * @access protected
     */
    protected function writeData() {
    
        $rows = array();
        foreach ($this->data as $row) {
            $rows[] = implode($this->formatRow($row), $this->dialect->delimiter);
        }
        $output = implode($rows, $this->dialect->lineterminator);
        fwrite($this->handle, $output);
    
    }
    /**
     * Accepts a row of data and returns it formatted according to $this->dialect
     * This method is called by writeData()
     * 
     * @param array An array of data to be formatted for output to the file
     * @access protected
     * @return array The formatted array (formatting determined by dialect)
     */
    protected function formatRow(Array $row) {
    
        foreach ($row as &$column) {
            switch($this->dialect->quoting) {
                case Csv_Dialect::QUOTE_NONE:
                    // do nothing... no quoting is happening here
                    break;                
                case Csv_Dialect::QUOTE_ALL:
                    $column = $this->quote($this->escape($column));
                    break;                
                case Csv_Dialect::QUOTE_NONNUMERIC:
                    if (preg_match("/[^0-9]/", $column))
                        $column = $this->quote($this->escape($column));
                    break;
                case Csv_Dialect::QUOTE_MINIMAL:
                default:
                    if ($this->containsSpecialChars($column)) 
                        $column = $this->quote($this->escape($column));
                    break;            
            }
        }
        return $row;
    
    }
    /**
     * Escapes a column (escapes quotechar with escapechar)
     *
     * @param string A single value to be escaped for output
     * @return string Escaped input value
     * @access protected
     */
    protected function escape($input) {
    
        return str_replace(
            $this->dialect->quotechar,
            $this->dialect->escapechar . $this->dialect->quotechar,
            $input
        );
    
    }
    /**
     * Quotes a column with quotechar
     *
     * @param string A single value to be quoted for output
     * @return string Quoted input value
     * @access protected
     */
    protected function quote($input) {
    
        return $this->dialect->quotechar . $input . $this->dialect->quotechar;
    
    }
    /**
     * Returns true if input contains quotechar, delimiter or any of the characters in lineterminator
     *
     * @param string A single value to be checked for special characters
     * @return boolean True if contains any special characters
     * @access protected
     */
    protected function containsSpecialChars($input) {
    
        $special_chars = str_split($this->dialect->lineterminator, 1);
        $special_chars[] = $this->dialect->quotechar;
        $special_chars[] = $this->dialect->delimiter;
        foreach ($special_chars as $char) {
            if (strpos($input, $char)) return true;
        }
    
    }
    /**
     * 
     * Closes out this file (can be called explicitly, but is called automatically by __destruct())
     *
     * @access public
     * @return null
     * @throws Csv_Exception_CannotAccessFile If unable to create or write to the file
     */
    function close() {
    
        if (!is_resource($this->handle)) {
            $this->handle = @fopen($this->filename, 'wb');
        }
        
        if ($this->handle) {        
            $this->writeData();
            fclose($this->handle);
            $this->data = array(); // data has been written, so empty it
            return;        
        }
        // if parser reaches this, the file couldnt be created
        throw new Csv_Exception_CannotAccessFile(sprintf('Unable to create/access file: "%s".', $this->filename));
    
    }
    /**
     * When the object is destroyed, if there is still data waiting to be written to disk, write it
     *
     * @access public
     */
    function __destruct() {
    
        if (!empty($this->data)) $this->close();
    
    }
}