<?php
echo '
<div  class="row">

    <div class="span12">

        <div class="span5">

            <h2>Entrée: '.$filepath.'</h2>
            <span class="stats" >
                '.  $longueur_old .' caractères.
            </span>
            <div id="unoptimised"  class="css">
                <pre class="lang-css prettyprint">'.  $file .'</pre>
            </div>
        </div>
        <div  class="span5 ">
            <h2> Sortie:</h2>
            <span class="stats" >
                '.  $longueur_new .' caractères. gain: '.  $gain_compression .'. réécritures: '. $GLOBALS['ecrasement']  .'
            </span>
            <div id="optimised" class="css" >
                <pre class="lang-css prettyprint"> '.$optimised.' </pre>
            </div>

        </div>
    </div>
</div>
<hr/>    
';
?>





