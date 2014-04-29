<?php

/**
 * checks if the form is posted
 */
function setCss() {
   if(checkPost()){
       return $_POST['lecss'];
   }
}
function checkPost() {
    if(isset($_POST['lecss']) && $_POST['lecss'] != ''){
        return true;
    }
}

function cleaner($str) {
    $cible = str_replace(PHP_EOL, '', $str);
    $cible = trim(str_replace('\n', '', $cible));
    $cible = trim(str_replace('<br/>', '', $cible));
    return $cible;
}

/**
 * 
 * @param type $css
 */
function cssToArray($css) {
    $tab = explode("}", $css);
    return $tab;
}

/**
 *  remove everything between css comments
 * @param type $css
 */
function removeComments($css) {

    return preg_replace("!/\*.*?\*/!ms", "", $css);
}

/**
 * convertit une chaine de css en tableau optimisé
 * @param type $css
 */
function optimise($css) {
    $tableau = cssToArray($css);
    $op;
    $watch = array();
    $GLOBALS['ecrasement'] = 0;

    foreach ($tableau as $key => $value) {
        $boom = explode('{', $value);
        if ($boom[0] != null) {
            $selecteur = cleaner($boom[0]);
            // écraser instruction avec le plus ancien
            $explode = explode(':', cleaner($boom[1]));
            // si l'instruction est déjà présente pour ce sélecteur, l'écraser
            if (!isset($watch[$selecteur][$explode[0]])) {
                $watch[$selecteur][$explode[0]] = $explode[1];
                $GLOBALS['ecrasement'] ++;
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
    $echo = '';
    foreach ($array as $key => $value) {

        if ($key != ' ' || $key != '') {
            $echo .= '' . $key . '{';

            foreach ($value as $k => $v) {
                $value .= '' . $k . ':' . $v;
            }
            $echo .= str_replace("Array", '', $value) . '}';
            $echo .= '<br/><br/>';
        }
    }

    if ($options == 1) {
        $echo = str_replace(';', ';<br/>', $echo);
        $echo = nl2br($echo);
    }
    else{
        $echo = removeComments($echo);
    }
    return $echo;
}

/**
 * enlève les retours à la ligne
 * @param type $file
 * @return type
 */
function opFromFile($file) {
    return printcss(optimise(trim($file)), 0);
}

?>
