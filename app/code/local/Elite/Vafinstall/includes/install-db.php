<fieldset>
    <legend>Database</legend>
    Type name of levels seperated by comma: <input type="text" name="levels" value="<?=( isset( $_REQUEST['levels'] ) ? $_REQUEST['levels'] : 'make,model,year' )?>" /> (ex. "make,model, year")
    <br />
    <input type="checkbox" name="generateDb" value="1" checked="checked" /> Generate Database SQL
    <br />
    <input type="checkbox" name="runDb" value="1" /> Run Database SQL
    <?php
    if( isset( $_REQUEST['levels'] ) && isset( $_REQUEST['runDb'] ) )
    {
        $generator = new VF_Schema_Generator();
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
                return;
            }
            try{
                $helper->getReadAdapter()->query( $statement );
            }catch(Exception$e){
                echo'ERROR: '.$e->getMessage();
            }
        }
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
        
        echo '<br /><textarea onClick="javascript:this.focus();this.select();" cols="100" rows="10">' . $sql . '</textarea>';
        echo '<br /><b style="color:green">Ok!</b></textarea>';
        echo '<br />Now copy and paste this into the SQL tab of your phpmyadmin. Drop any existing "elite_" tables first (but not before backing them up)<br />';
    }
    ?>
</fieldset>