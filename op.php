<?php

error_reporting(0);
    $file = file_get_contents("test.css");
    $tableau = explode("}", $file);
    $op = array();
    foreach ($tableau as $key => $value) {
        $boom = explode('{', $value);
        $cible = trim($boom[0]);
        $op[$cible] .=$boom[1];
}

$longueur_old=strlen($file);

function printcss($array){
   $echo ;
    foreach ($array as $key => $value) {
        // TODO modifier la première clé
        // TODO séparer les :
        // écraser instruction avec le plus ancien
        if($key != ' ' || $key != ''){
            $echo .= ''.$key . '{';
        $echo .= $value . '}';
      // $echo .= '<br/><br/>';
        }
        
}


return $echo;
}
?>
