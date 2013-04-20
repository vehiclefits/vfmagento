<?php
/**
 * CSV Utils
 * 
 * This is a csv reader - basically it reads a csv file into an array
 * Please read the LICENSE file
 * @copyright Luke Visinoni <luke.visinoni@gmail.com>
 * @author Luke Visinoni <luke@mc2design.com>
 * @package Csv
 * @license GNU Lesser General Public License
 * @version 0.1
 */
require_once 'Csv/Dialect.php';
require_once 'Csv/Exception/FileNotFound.php';
/**
 * Provides an easy-to-use interface for reading csv-formatted text files. It
 * makes use of the function fgetcsv. It provides quite a bit of flexibility.
 * You can specify just about everything about how it should read a csv file
 * @todo Research the ArrayIterator class and see if it is the best choice for
 *       this and if I'm even using it correctly. There are quite a few methods 
 *       that are inherited that may or may not work. It would be cool if we
 *       could use 
 * @package Csv
 * @subpackage Csv_Reader
 */
class Csv_Reader implements Iterator, Countable
{
    /**
     * Maximum row size
     * @todo Should this be editable? maybe change it to a public variable
     */
    const MAX_ROW_SIZE = 4096;
    /**
     * Path to csv file
     * @var string
     * @access protected
     */
    protected $path;
    /**
     * Tells reader how to read the file
     * @var Csv_Dialect
     * @access protected
     */
    protected $dialect;
    /**
     * A handle that points to the file we are reading
     * @var resource
     * @access protected
     */
    protected $handle;
    /**
     * The currently loaded row
     * @var array
     * @access public
     * @todo: Should this be public? I think it might have been required for ArrayIterator to work properly
     */
    public $current;
    /**
     * This is the current line position in the file we're reading 
     * @var integer
     */
    protected $position = 0;
    /**
     * Number of lines skipped due to malformed data
     * @var integer
     * @todo This may be flawed - be sure to test it thoroughly
     */
    protected $skippedlines = 0;
    /**
     * Class constructor
     *
     * @param string Path to csv file we want to open
     * @param string The character(s) used to seperate columns in the csv file
     * @param boolean If set to false, don't treat the first row as headers - defaults to true
     * @throws Csv_Exception
     */
    function __construct($path, Csv_Dialect $dialect = null/*, $skip_empty_rows = false*/) {
    
        if (is_null($dialect)) $dialect = new Csv_Dialect;
        $this->dialect = $dialect;
        // open the file
        $this->setPath($path);
        $this->handle = fopen($this->path, 'rb');
        if ($this->handle === false) throw new Csv_Exception_FileNotFound('File does not exist or is not readable: "' . $path . '".');
        $this->rewind();
    
    }
    /**
     * Get the current Csv_Dialect object
     *
     * @return The current Csv_Dialect object
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
     * Set the path to the csv file
     *
     * @param string The full path to the file we want to read
     * @access protected
     */
    protected function setPath($path) {
    
        $this->path = realpath($path);
    
    }
    /**
     * Get the path to the csv file we're reading
     *
     * @return string The path to the file we are reading
     * @access public
     */
    function getPath() {
    
        return $this->path;
    
    }
    /**
     * Removes the escape character in front of our quote character
     *
     * @param string The input we are unescaping
     * @param string The key of the item
     * @todo Is the second param necssary? I think it is because array_walk
     */
    protected function unescape(&$item, $key) {
    
        $item = str_replace($this->dialect->escapechar.$this->dialect->quotechar, $this->dialect->quotechar, $item);
    
    }
    /**
     * Returns the current row and calls next()
     * 
     * @access public
     */
    function getRow() {
    
        $return = $this->current();
        $this->next();
        return $return;
    
    }
    /**
     * Loads the current row into memory
     * 
     * @access protected
     * @todo I can't get fgetcsv to choke on anything, so throwing an exception here may not be possible
     */
    protected function loadRow() {
    
        if (!$this->current = fgetcsv($this->handle, self::MAX_ROW_SIZE, $this->dialect->delimiter, $this->dialect->quotechar)) {
            //sthrow new Csv_Exception('Invalid format for row ' . $this->position);
        }
        if (
            $this->dialect->escapechar !== ''
            && $this->dialect->escapechar !== $this->dialect->quotechar
            && is_array($this->current)
        ) array_walk($this->current, array($this, 'unescape'));
        // if this row is blank and dialect says to skip blank lines, load in the next one and pretend this never happened
        if ($this->dialect->skipblanklines && is_array($this->current) && count($this->current) == 1 && $this->current[0] == '') {
            $this->skippedlines++;
            $this->next();
        }
    
    }
    /**
     * Get number of lines that were skipped
     * @todo probably should return an array with actual data instead of just the amount
     */
    function getSkippedLines() {
    
        return $this->skippedlines;
    
    }
    /**
     * Returns csv data as an array
     * @todo if first param is set to true the header row is used as keys
     */
    function toArray() {
    
        $return = array();
        foreach ($this as $row) {
            $return[] = $row;
        }
        // be kinds, please rewind
        $this->rewind();
        return $return;
    
    }
    /**
     * Get total rows
     *
     * @return integer The number of rows in the file (not includeing line-breaks in the data)
     * @todo Make sure that this is aware of line-breaks in data as opposed to end of row
     * @access public
     */
    function close() {
    
        if (is_resource($this->handle)) fclose($this->handle);
    
    }
    /**
     * Destructor method - Closes the file handle
     * 
     * @access public
     */
    function __destruct() {

        $this->close();

    }
    
    /**
     * The following are the methods required by php's Standard PHP Library - Iterator, Countable Interfaces
     */
    
    /**
     * Advances the internal pointer to the next row and returns it if valid, otherwise it returns false
     * 
     * @access public
     * @return boolean|array An array of data if valid, or false if not
     */
    function next() {
    
        $this->position++;
        $this->loadRow(); // loads the current row into memory
        return ($this->valid()) ? $this->current : false;
    
    }
    /**
     * Tells whether or not the current row is valid - called after next and rewind
     * 
     * @access public
     * @return boolean True if the current row is valid
     */
    function valid() {
    
        if (is_resource($this->handle))
            return (boolean) !feof($this->handle);
        
        return false;
    
    }
    /**
     * Returns the current row 
     * 
     * @access public
     * @return array An array of the current row's data
     */
    function current() {
    
        return $this->current;
    
    }
    /**
     * Moves the internal pointer to the beginning
     * 
     * @access public
     */
    function rewind() {
    
        rewind($this->handle);
        $this->position = 0;
        $this->loadRow(); // loads the current (first) row into memory 
    
    }
    /**
     * Returns the key of the current row (position of pointer)
     * 
     * @access public
     * @return integer
     */
    function key() {
    
        return (integer) $this->position;
    
    }
    /**
     * Returns the number of rows in the csv file
     * 
     * @access public
     * @return integer
     * @todo Should this remember the position the file was in or something?
     */
    function count() {
    
        $lines = 0;
        foreach ($this as $row) $lines++;
        $this->rewind();
        return (integer) $lines;
    
    }
}