
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Demo d'optimisation CSS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" media="all" href="style.css" />

    </head>
    <?php
    error_reporting(E_ALL);
    //TODO get the POST data if send by user
    $filepath = "test.css";
    $file = file_get_contents($filepath);
    $file = str_replace(PHP_EOL, '', $file);
    $op = array();

    require("op.php");

//var_dump($tableau);
    $optimised = "";
    $optimised = printcss(optimise(trim($file)), 0);
    $longueur_old = strlen($file);
    $longueur_new = strlen($optimised);
    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
    ?>

    <body>
        <h1>Optimiseur de CSS simple</h1>
        <div class="well">Cet optimiseur n'est pas compatible avec les média queries pour l'instant
            <br/>L'optimisation comprend:
            La non répétition des sélecteurs, des instructions qui se retrouvent écrasées.
        </div>
        <!--        <div  class="row-fluid">
                    <div class="span5 well">
                        <h2>Feuille pas optimisée: <?php echo $longueur_old; ?></h2>
                        <div id="unoptimised"  class="css">
                            <pre>
        <?php echo nl2br($file, true); ?></pre>
                        </div>
                    </div>
                    <div  class="span5 well">
                        <h2> Feuille optimisée et rangée: <?php echo $longueur_new; ?>. gain: <?php echo $gain_compression; ?></h2>
                        <div id="optimised" class="css" >
                            <pre><?php echo $optimised; ?></pre>
                        </div>
                    </div>
                </div>
                <hr/>-->
        <?php
        require("tpl/demo_line.php");
        $filepath = "css/1.css";
        require("tpl/demo_line.php");
        $filepath = "css/2.css";
        require("tpl/demo_line.php");
        $filepath = "css/3.css";
        require("tpl/demo_line.php");
        ?>


        <div  class="">
            Logs
            <div id="log" class="css" >
                <pre><?php var_dump($optimised); ?></pre>
                <pre><?php var_dump($file); ?></pre>

            </div>

        </div>
        <footer>
            <div class="well">
                <a href="https://github.com/tykayn">github tykayn</a>
                <br />
                <a href="http://artlemoine.com">portfolio artlemoine.com</a> 
            </div>
        </footer>
    </body>
</html>


