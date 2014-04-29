<?php

/**
 * checks if the form is posted
 */
function setCss() {
    if (checkPost()) {
        return $_POST['lecss'];
    }
}

function checkPost() {
    if (isset($_POST['lecss']) && $_POST['lecss'] != '') {
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
 * 
 */
$GLOBALS['compressibles'] = array(
    'margin-top',
    'margin-bottom',
    'margin-left',
    'margin-right',
    'padding-top',
    'padding-bottom',
    'padding-left',
    'padding-right',
    'border-top',
    'border-bottom',
    'border-left',
    'border-right'
);

function combine($mix) {
//    var_dump('mix');
//    var_dump($mix);
    if (
            isset($mix['top']) &&
            isset($mix['right']) &&
            isset($mix['bottom']) &&
            isset($mix['left'])
    ) {
    //écriture en 1 éléments, tous les cotés pareils
        if (
                $mix['top'] == $mix['bottom'] && $mix['top'] == $mix['right'] && $mix['top'] == $mix['left']
        ) {
            $str = $mix['top'];
        }
        
        //écriture en deux éléments: vertical , latéral.
        elseif (
                $mix['top'] == $mix['bottom'] &&
                $mix['right'] == $mix['left']
        ) {
            $str = $mix['top'] . ' ' . $mix['right']
            ;
        }
        
        //écriture en trois éléments: haut , latéral, bas.
        elseif (
                $mix['right'] == $mix['left'] &&
                $mix['top'] != $mix['bottom']
        ) {
            $str = $mix['top'] . ' ' . $mix['right'] . ' ' . $mix['bottom'];
        }
         else {
            //écriture en 4 éléments, tous différents
            $str = $mix['top'] . ' ' .
                    $mix['right'] . ' ' .
                    $mix['bottom'] . ' ' .
                    $mix['left'] . ' '
            ;
        }
    } else {
        if (!isset($mix['top'])) {
            $mix['top'] = '';
        }
        if (!isset($mix['right'])) {
            $mix['right'] = '';
        }

        if (!isset($mix['bottom'])) {
            $mix['bottom'] = '';
        }
        if (!isset($mix['left'])) {
            $mix['left'] = '';
        }

        $str = $mix['top'] . ' ' .
                $mix['right'] . ' ' .
                $mix['bottom'] . ' ' .
                $mix['left'] . ' '
        ;
    }
    return $str . ';';
}

/**
 * convertit une chaine de css en tableau optimisé
 * @param type $css
 * @return array
 */
function optimise($css) {
    $tableau = cssToArray($css);
    sort($tableau);
    $op;
    $watch = array();
    $GLOBALS['ecrasement'] = 0;

    /**
     * passer en examen chaque bloc d'instruction
     */
    foreach ($tableau as $key => $value) {
        $mix = array();
        $boom = explode('{', $value);
        if ($boom[0] != null) {
            $selecteur = trim(cleaner($boom[0]));
            // quand il y a plus d'une propriété/valeur
            $paires = explode(';', cleaner($boom[1]));
            foreach ($paires as $p) {
                if ($p != '') {

                    // écraser instruction avec le plus ancien
                    $explode = explode(':', $p);
                    $propriete = trim($explode[0]);
                    $instruction = trim($explode[1]);
                    // si la propriété est compressible, la combiner
                    if (in_array($propriete, $GLOBALS['compressibles'])) {
                        $details = explode('-', $propriete);
                        $propriete = $propCompressed = $details[0];
                        '';

                        $side = $details[1];
                        // créer un tableau avec les cotés de la prorpiété,
                        //  pour ensuite les combiner
                        $mix[$side] = $instruction;
                        if (!isset($watch[$selecteur][$propCompressed])) {
                            $watch[$selecteur][$propCompressed] = '';
                        }
//                        continue;
                    } else {
                        // si l'instruction est déjà présente pour ce sélecteur, l'écraser
                        if (!isset($watch[$selecteur][$propriete]) && $instruction != '') {
                            $watch[$selecteur][$propriete] = $instruction;
                            $GLOBALS['ecrasement'] ++;
                        }
                    }
                }
            }
            if(count($mix) > 0){
                $watch[$selecteur][$propriete] = combine($mix);
            }
            
        }
    }
//       var_dump($watch);
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
    } else {
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
