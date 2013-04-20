<fieldset>
    <legend>Copy designs, skin, javascript, css</legend>
    <input type="checkbox" name="checkall" onclick="jQuery('.designcheck').attr( 'checked', jQuery(this).attr('checked') )" /> Check ALL
    <strong>Please read carefully</strong>, <i>Always back up ALL files</i>:<br />
    <?php
    foreach( $pathEnumerator->tasks() as $copyTask )
    {
        echo '<input type="checkbox" class="designcheck" checked="checked" value="' . md5($copyTask[0]) . '" name="copy[]" />';
        echo 'Copy ' . $copyTask[2] . ' (from [' . $copyTask[0] . '] to [' . $copyTask[1] . '])<br />';
    }   

    $copyr = new Elite_Vafinstall_RecursiveCopy();  
    if( isset( $_REQUEST['submit'] ) )
    {  
        echo '<pre>';
            $c = 0;
            foreach( $pathEnumerator->tasks() as $copyTask )
            {
                $key = md5($copyTask[0]);
                if( isset($_POST['copy']) &&  is_array( $_POST['copy'] ) && in_array( $key, $_POST['copy'] ) )
                {
                    $c++;
                    $copyr->main( $copyTask[0], $copyTask[1] );
                }
            }
            echo "\n";
        echo '</pre>';
        if( $c > 0 )
        {
            echo '<br /><b style="color:green">Ok!</b>';
        }
    }
    ?>
</fieldset>