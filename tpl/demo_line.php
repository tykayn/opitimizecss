<?php
    $file = file_get_contents($filepath);
    $file = str_replace(PHP_EOL, '', $file);
    $op = array();
    $optimised = "";
    $optimised = printcss(optimise(trim($file)), 0);
    $longueur_old = strlen($file);
    $longueur_new = strlen($optimised);
    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
    echo '
        <hr/><div  class="row-fluid">
            <div class="span5 well">
                <h2>Feuille pas optimisée: '.  $longueur_old .'</h2>
                <div id="unoptimised"  class="css">
                    <pre>
                        '.  nl2br($file, true) .'</pre>
                </div>
            </div>
            <div  class="span5 well">
                <h2> Feuille optimisée et rangée: '.  $longueur_new .'. gain: '.  $gain_compression .'. réécritures: '. $GLOBALS['ecrasement']  .'</h2>
                <div id="optimised" class="css" >
                    <pre> '.$optimised.'></pre>
                </div>
            </div>
        </div>';

?>

        