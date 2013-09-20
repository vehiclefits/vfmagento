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
?>
<fieldset>
    <legend>Database</legend>
    Type name of levels separated by comma: <input type="text" name="levels" value="<?php echo ( isset( $_REQUEST['levels'] ) ? $_REQUEST['levels'] : 'make,model,year' )?>" /> (ex. "make,model, year")
    <br />
    <input id="generateDB" type="checkbox" name="generateDb" value="1" checked="checked" /> Generate Database SQL
    <br />
    <input id="runDB" type="checkbox" name="runDb" value="1" /> Run Database SQL
    <?php
    if( isset( $_REQUEST['levels'] ) && isset( $_REQUEST['runDb'] ) )
    {
        $generator = new VF_Schema_Generator();
        $generator->dropExistingTables();
        $sql = $generator->generator( explode(',', $_REQUEST['levels'] ) );

        if( file_exists(ELITE_PATH.'/Vafpaint') )
        {
            $generator = new Elite_Vafpaint_Model_Schema_Generator();
            $sql .= $generator->install();
        }

        if( file_exists(ELITE_PATH.'/Vafgarage') )
        {
            $generator = new Elite_Vafgarage_Model_Schema_Generator();
            $sql .= $generator->install();
        }

        foreach( explode(';',$sql) as $statement )
        {
            if(!trim($statement))
            {
                continue;
            }
            try{
                $helper->getReadAdapter()->query( $statement );
            }catch(Exception$e){
                echo'<br /><span style="color:red;">ERROR: '.$e->getMessage().' in SQL: ' . $statement .'</span>';
            }
        }
        echo '<br /><b style="color:green">Ok! Database created!</b>';

    }
    else if( isset( $_REQUEST['levels'] ) && isset( $_REQUEST['generateDb'] ) )
    {
        $generator = new VF_Schema_Generator();
        $sql = $generator->generator( explode(',', $_REQUEST['levels'] ) );
        if( file_exists(ELITE_PATH.'/Vafpaint') )
        {
            $generator = new Elite_Vafpaint_Model_Schema_Generator();
            $sql .= $generator->install();
        }
        
        echo '<br /><textarea id="query_text" onClick="javascript:this.focus();this.select();" cols="100" rows="10">' . $sql . '</textarea>';
        echo '<br /><b style="color:green">Ok!</b></textarea>';
        echo '<br />Now copy and paste this into the SQL tab of your phpmyadmin. Drop any existing "elite_" tables first (but not before backing them up)<br />';

        echo '<script type="text/javascript" src="/skin/adminhtml/default/default/vf/jquery-1.7.1.min.js"></script>';
        echo '<script type="text/javascript">parent.jQuery("body").trigger("foo");</script>';
    }
    ?>
</fieldset>