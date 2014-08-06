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

    $css = removeComments($css);
    $tab = explode("}", $css);
    $newtab = array();
//var_dump( $tab);
    foreach ($tab as $key => $value) {
        // tableau des propriétés à combiner pour le sélecteur en cours

        $boom = explode('{', $value);
        $selecteur = trim(cleaner($boom[0]));

        if ($selecteur != null && count($boom) > 1) {
            $instructions = $boom[1];
            // si le sélecteur a des virgules,
            // copier les instructions pour chaque partie entre les virgules.

            if (hasComma($selecteur)) {
//                var_dump($selecteur);
                $selec = explode(',', trim($selecteur));
                sort($selec);
                $selec = trim(join(',', $selec));
//                var_dump($selec);
                if (isset($newtab[$selec])) {
                    $newtab[$selec] .= $instructions;
                    unset($tab[$key]);
                } else {
                    $newtab[$selec] = $selec . '{' . $instructions;
                }
            }
        }
    }
//    var_dump( $newtab);
//    var_dump($newtab);
    // fusion des tableaux
    $tab = array_merge($tab, $newtab);


    return $tab;
}

/**
 *  remove everything between css comments
 * @param type $css
 */
function removeComments($css) {

    $str = preg_replace("!/\*.*?\*/!ms", "", $css);
    $str = preg_replace("# ,#", ",", $str);

    return $str;
}

/**
 * propriétés que l'on peut combiner en une écriture raccourcie.
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
    return $str;
}

/**
 * détecte les sélecteurs a virgule et leur donne des valeurs identiques. 
 * @param type $tab
 * @return array
 */
function commaTab($tab) {
    return $tab;
}

/**
 * savoir si un sélecteur présente des virgules
 * @param type $selecteur
 * @return boolean
 */
function hasComma($selecteur) {
    $boom = explode(',', $selecteur);
    if (count($boom) > 1) {
        return true;
    } else {
        return false;
    }
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

        if ($selecteur != null && isset($boom[1])) {
            $instructions = $boom[1];




//            var_dump($selecteur);
            // quand il y a plus d'une propriété/valeur
            $paires = explode(';', cleaner($instructions));

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
                    }
//                    var_dump($selecteur . '_' .$propriete . '_ : ' . $instruction );
                    // si l'instruction est déjà présente pour ce sélecteur, l'écraser
                    if (!isset($watch[$selecteur][$propriete]) && $instruction != '') {


                        $GLOBALS['ecrasement'] ++;
                    }
                    $watch[$selecteur][$propriete] = $instruction;
                }
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
                $value .= '' . $k . ':' . $v . ';';
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
 * donne une chaine css optimisée à partir d'une chaine de css.
 * @param string $file
 * @return string
 */
function opFromFile($file) {
    return printcss(optimise(trim($file)), 0);
}

/**
 * donne un tableau des couleurs utilisées dans une feuille de style.
 * @param type $file css file content
 * @return array of colours
 */
function getColours($file) {
    $matches = array();

    $pattern = "/#[0-9a-f]{3,6}/i";
    $array = preg_match_all($pattern, trim($file), $matches);

    return $matches;
}
/**
 * 
 * @param type $matches
 */
function ePalette($file) {
    echo makePalette(getColours($file));
}
function makePalette($matches) {
    $rendu = "palette: <div class='palette'>";
    $pal = array_unique($matches[0]);
    sort($pal);
    foreach ($pal as $key => $value) {
        $rendu .="<div class='color_tile' style='background: $value'>$value</div>";
    }
    $rendu .="</div>";
    return $rendu;
}

?>