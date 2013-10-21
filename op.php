<?php

/**
 * convertit une chaine de css en tableau optimisé
 * @param type $css
 */
function optimise($css) {
    $tableau = explode("}", $css);
    $op;
    foreach ($tableau as $key => $value) {
        $boom = explode('{', $value);
        if ($boom[0] != null) {
            $cible = str_replace(PHP_EOL, '', $boom[0]);
            $cible = trim(str_replace('\n', '', $cible));

            $op[$cible] .= trim($boom[1]);
        }


        var_dump($cible);
    }
    return $op;
}

$longueur_old = strlen($file);

/**
 * convertit le tableau de css optimisé en chaine de css
 * @param type $array
 * @return string
 */
function printcss($array) {

    print_r($array);
    $echo;
    foreach ($array as $key => $value) {
        // TODO modifier la première clé
        // TODO séparer les :
        // écraser instruction avec le plus ancien
        if ($key != ' ' || $key != '') {
            $echo .= '' . $key . '{';
            $echo .= $value . '}';
            $echo .= '<br/><br/>';
//            $echo .= ''.$value.'}';
        }
    }


    return $echo;
}

?>
