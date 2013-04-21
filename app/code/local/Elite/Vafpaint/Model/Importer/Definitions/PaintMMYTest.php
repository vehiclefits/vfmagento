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
class Elite_Vafpaint_Model_Importer_Definitions_PaintMMYTest extends Elite_Vaf_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    const NEWLINE = "\n";

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'make,model,year,Code,Name,Color(hex)' . self::NEWLINE;
        $this->csvData .= 'Acura, Integra, 1986,  B-26MZ,  Avignon Blue Metallic Clearcoat, #9CBBCC' . self::NEWLINE;
        $this->csvData .= 'Acura, Integra, 1986,  B-38,  Capitol Blue, #061D72' . self::NEWLINE;
        $this->csvFile = TEMP_PATH . '/paint-definitions.csv';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = new Elite_Vafpaint_Model_Importer_Definitions_Paint( $this->csvFile );
        $importer->import();
    }
    
    function testImport1()
    {
        $year = $this->findLeafFromFullPathMMY( 'Acura', 'Integra', '1986' );
        $actual = $this->findPaints( $year->getId() );
        $actual = $actual[0];
        $expected = new stdClass;
        $expected->code = 'B-26MZ';
        $expected->name = 'Avignon Blue Metallic Clearcoat';
        $expected->color = '#9CBBCC';
        $this->assertEquals( $expected, $actual );
    }
    
    function testImport2()
    {
        $year = $this->findLeafFromFullPathMMY( 'Acura', 'Integra', '1986' );
        $actual = $this->findPaints( $year->getId() );
        $actual = $actual[1];
        $expected = new stdClass;
        $expected->code = 'B-38';
        $expected->name = 'Capitol Blue';
        $expected->color = '#061D72';
        $this->assertEquals( $expected, $actual );
    }  
    
    /** @todo use production method */
    protected function findPaints( $yearId )
    {
        $r = $this->query(
            sprintf(
                "
                SELECT
                    code,name,color
                FROM
                    elite_mapping_paint
                WHERE
                    mapping_id = %d
                ",
                (int)$yearId
            )
        );
        $return = array();
        while( $row = $r->fetchObject() )
        {
            array_push( $return, $row );
        }
        return $return;
    }
    

}
