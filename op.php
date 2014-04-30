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
        } else {
            //écriture en 4 éléments, tous différents
            $str = $mix['top'] . ' ' .
                    $mix['right'] . ' ' .
                    $mix['bottom'] . ' ' .
                    $mix['left'] . ' '
            ;
        }
    } elseif (
            !isset($mix['top']) &&
            !isset($mix['right']) &&
            !isset($mix['left']) &&
            !isset($mix['bottom'])
    ) {
        $str = '0';
    } else {
        if (!isset($mix['top'])) {
            $mix['top'] = '0';
        }
        if (!isset($mix['right'])) {
            $mix['right'] = '0';
        }

        if (!isset($mix['bottom'])) {
            $mix['bottom'] = '0';
        }
        if (!isset($mix['left'])) {
            $mix['left'] = '0';
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
 * @param array $css
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
        // tableau des propriétés à combiner pour le sélecteur en cours
        $mix = array();
        $boom = explode('{', $value);
        $selecteur = trim(cleaner($boom[0]));
        if ($selecteur != null) {


//            var_dump($selecteur);
            // quand il y a plus d'une propriété/valeur
            $paires = explode(';', cleaner($boom[1]));
            foreach ($paires as $p) {
                if ($p != '') {

                    // séparer propriété et sa valeur
                    $explode = explode(':', $p);
                    //si pas d'instruction, ne pas prendre en compte la propriété.
                    if (!isset($explode[1])) {
                        continue;
                    }
                    $propriete = trim($explode[0]);
                    $instruction = trim($explode[1]);
                    // si la propriété est compressible, la combiner
                    if (in_array($propriete, $GLOBALS['compressibles'])) {

                        //reprendre le tableau de mix s'il existe dans un sélecteur précédent.
                        if (!isset($watch[$selecteur]['compressed'])) {
                            $watch[$selecteur]['compressed'] = '';
                        } else {
                            $mix = $watch[$selecteur]['compressed'];
                        }
                        $details = explode('-', $propriete);
                        $propriete = $propCompressed = $details[0];
                        '';

                        $side = $details[1];
                        // créer un tableau avec les cotés de la prorpiété,
                        //  pour ensuite les combiner
                        $mix[$propriete][$side] = $instruction;
//                        var_dump($propriete);


                        $watch[$selecteur]['compressed'] = $mix;

//                        continue;
                    }
                    // si l'instruction est déjà présente pour ce sélecteur, l'écraser
                    if (!isset($watch[$selecteur][$propriete]) && $instruction != '') {
                        $watch[$selecteur][$propriete] = $instruction;
                        $GLOBALS['ecrasement'] ++;
                    }
                }
            }
//            var_dump($mix);
            if (count($mix) > 0) {
                $watch[$selecteur][$propriete] = combine($mix);
            }
        }
    }

//    var_dump(  $watch ); 
    $watch = combineProp($watch);
    return $watch;
}

/**
 * après un optimise(), combine les propriétés compressibles
 * @param array $tab tableau de sélecteurs
 * @return type
 */
function combineProp($tab) {

    /**
     * passer en examen chaque bloc d'instruction
     */
    foreach ($tab as $k => $v) {
        if (isset($v['compressed'])) {
            // si le sélecteur a une partie compressible, 
            // lui assigner des propriétés de valeur combinée 
            foreach ($v['compressed'] as $key => $value) {
//                var_dump($v['compressed'] );
                $comb = combine($value);
                $v[$key] = $comb;
//                var_dump( $k.' combine ' . $key . '  = ' . $comb ); 
//                unset($v['compressed'][$key]);
                $tab[$k] = $v;
            }
        }
        // enlever la propriété 'compressed' qui est en fait un tableau de propriétés compressibles
        unset($tab[$k]['compressed']);
    }
    return $tab;
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
                $value .= '' . $k . ':' . $v.';';
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
