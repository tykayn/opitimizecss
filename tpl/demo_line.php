<?php
    $file = file_get_contents($filepath);
    
//    var_dump($filepath);
//    $file = str_replace(PHP_EOL, '', $file);
    $op = array();
    $optimised = "";
    $optimised = opFromFile($file)  ;
    $longueur_old = strlen($file);
    $longueur_new = strlen($optimised);
    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
    
require('demohtml.php');

?>

        