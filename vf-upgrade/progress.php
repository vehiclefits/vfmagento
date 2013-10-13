<?php
$mageRoot = str_replace('vf-upgrade', '', dirname($_SERVER['SCRIPT_FILENAME']));
if(file_exists($mageRoot.'var/vf-upgrade-progress.txt')) {
    readfile($mageRoot.'var/vf-upgrade-progress.txt');
}