<?php
    $file = $_POST['lecss'];
    $filepath ="formulaire";
    $op = array();
    $optimised = "";
    $optimised = opFromFile($file)  ;
    $longueur_old = strlen($file);
    $longueur_new = strlen($optimised);
    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
require('demohtml.php');

?>