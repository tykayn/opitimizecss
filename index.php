
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Demo d'optimisation</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" media="all" href="style.css" />

    </head>
    <?php
    require("op.php");
    
//print_r($tableau);
    $optimised = "";
    $optimised = printcss( $tableau );
    $longueur_new = strlen($optimised);
    ?>

    <body>
        <div class="span5">
            Feuille pas optimisée: <?php echo $longueur_old; ?>
            <div id="unoptimised"  class="css">
                <pre>
<?php echo nl2br($file); ?></pre>
            </div>
        </div>
        <div  class="span5">
            Feuille optimisée et rangée: <?php echo $longueur_new; ?>
            
            <div id="optimised" class="css" >
<pre><?php echo $optimised; ?></pre>

            </div>
            <div id="log" class="css" >
<pre><?php print_r($tableau); ?></pre>
            </div>
        </div>
    </body>
</html>


