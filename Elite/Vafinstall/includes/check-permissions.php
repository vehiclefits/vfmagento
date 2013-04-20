<fieldset>
    <legend>Permissions</legend>
    <table width="100%">
        <?php
        foreach( $pathEnumerator->paths() as $path )
        {
            ?>
            <tr>
                <td><?=$path?> is writable</td>
                <td align="center" style="color:white;width:150px;background-color: <?=is_writable( $path ) ? 'green' : 'red'?>;"><?=is_writable( $path ) ? 'OK' : 'PROBLEM'?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</fieldset>