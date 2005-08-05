<?php
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
        $this->csvFile = TESTFILES . '/paint-definitions.csv';
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
