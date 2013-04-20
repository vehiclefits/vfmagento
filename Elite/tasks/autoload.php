<?php
function __autoload($class_name) {
    echo $class_name; exit();
    $file = str_replace( '_', '/', $class_name . '.php' );
    if( 'Mage.php' == $file )
    {
        throw new Exception();
    }
    

    require_once $file;
}

new Test_Josh;
