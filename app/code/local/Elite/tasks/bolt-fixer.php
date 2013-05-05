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
require_once( dirname( __FILE__ ) . '/../Vaf/TestSuite.php' );

class Y2kFix
{
    const MAKE = 0;
    const MODEL = 1;
    const TRIM = 3;
    const WITH = 4;
    const YEAR_RANGE = 5;
    const BOLTPATTERN = 6;
    
    function main()
    {
        $csvReader = new Csv_Reader('E:\dev\vafrepo\databases\jeffrey-bolts.csv');
        $i=0;
        $csv = '';
        while( $row=$csvReader->getRow() )
        {
            $newRow = array( 0 => $row[self::MAKE], 1 => $row[self::MODEL], 2 => $row[self::TRIM], 3 => $row[self::YEAR_RANGE],4 => $row[self::BOLTPATTERN] );
            //if($row[self::MAKE]=='Audi'&&$row[self::MODEL]=='A4') debugbreak();
            $newRow[3] = explode("-",$newRow[3]);
            
            $newRow[3][0] = $this->fixYears($newRow[3][0]);
            if(isset($newRow[3][1]))
            {
                $newRow[3][1] = $this->fixYears($newRow[3][1]);
            }
            else
            {
                $newRow[3][1] = '';
            }
            if(!$newRow[3][1])
            {
                $newRow[3][1] = $newRow[3][0];
            }
            
            $csv .= '"' . $newRow[0] . '","' . $newRow[1] . '","' . $newRow[2] .  '","' . $newRow[3][0] .  '","' . $newRow[3][1] .  '","' . $newRow[4] . "\"\n";
        }
        file_put_contents('E:\dev\vafrepo\databases\bolts-v4.csv',$csv);
    }
    
    function fixYears($year)
    {
        if(strlen($year) == 2 )
        {
            if( $year < 11 ) // if before '11'
            {
                $year = '20' . $year; // prolly means <2011
            }
            else
            {
                $year = '19' . $year; // otherwise it prolly means >=1911
            }
        }
        return $year;
    }
}

$utility = new Y2kFix();
$utility->main();