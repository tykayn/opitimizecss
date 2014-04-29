<?php
    $file = file_get_contents($filepath);
//    $file = str_replace(PHP_EOL, '', $file);
    $op = array();
    $optimised = "";
    $optimised = opFromFile($file)  ;
    $longueur_old = strlen($file);
    $longueur_new = strlen($optimised);
    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
    
//    $file= nl2br($file );
    echo '
        
        <div  class="row">
        <div class="span12">
        
            <div class="span5">
                <h2>Feuille pas optimisée:</h2>
                <div id="unoptimised"  class="css">
                    <pre>
                        '.  $file .'</pre>
                </div>
                <div class="stats" >
                 '.  $longueur_old .' caractères.</div>
            </div>
            <div  class="span5 ">
                <h2> Feuille optimisée et rangée:</h2>
                
                <div id="optimised" class="css" >
                    <pre> '.$optimised.'></pre>
                </div>
                <div class="stats" >
                '.  $longueur_new .' caractères. gain: '.  $gain_compression .'. réécritures: '. $GLOBALS['ecrasement']  .'
                    </div>
            </div>
            </div>
        </div>
        <hr/>';

?>

        