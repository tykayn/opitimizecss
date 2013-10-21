
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
    error_reporting(0);
    $file = file_get_contents("test.css");
    $file = str_replace(PHP_EOL, '', $file);
    $op = array();
    
    require("op.php");
    
//var_dump($tableau);
    $optimised = "";
    $optimised = printcss( optimise( trim($file) ) );
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
                    
        </div>
        <div  class="span5">
            Logs
            <div id="log" class="css" >
<pre><?php // var_dump($optimised); ?></pre>
<pre><?php  var_dump($tableau); ?></pre>
            </div>
            
        </div>
    </body>
</html>


