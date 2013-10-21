<?php

function cleaner($str) {
    $cible = str_replace(PHP_EOL, '', $str);
    $cible = trim(str_replace('\n', '', $cible));
    $cible = trim(str_replace('<br/>', '', $cible));
    return $cible;
}

/**
 * convertit une chaine de css en tableau optimisé
 * @param type $css
 */
function optimise($css) {
    $tableau = explode("}", $css);
    $op;
    $watch = array();

    foreach ($tableau as $key => $value) {
        $boom = explode('{', $value);
        if ($boom[0] != null) {
            $selecteur = cleaner($boom[0]);
            // écraser instruction avec le plus ancien
            $explode = explode(':', cleaner($boom[1]));
            // si l'instruction est déjà présente pour ce sélecteur, l'écraser
            if (!isset($watch[$cible][$explode[0]])) {
                $watch[$selecteur][$explode[0]] = $explode[1];
            }
        }
    }
 //   var_dump($watch);
    return $watch;
}

/**
 * convertit le tableau de css optimisé en chaine de css
 * @param type $array
 * @param int $options
 * @return string
 */
function printcss($array, $options = 1) {
    $echo;
    foreach ($array as $key => $value) {

        if ($key != ' ' || $key != '') {
            $echo .= '' . $key . '{';
            
            foreach ($value as $k => $v) {
                $value .= '' . $k . ':' . $v;
            }
            $echo .= str_replace("Array", '',$value)  . '}';
            $echo .= '<br/><br/>';
        }
    }

    if ($options == 1) {
        $echo = str_replace(';', ';<br/>', $echo);
        $echo = nl2br($echo);
    }
    return $echo;
}

?>
