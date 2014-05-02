
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
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <?php
    error_reporting(E_ALL);
//    $filepath = "css/1.css";
//    $file = file_get_contents($filepath);
//    $file = str_replace(PHP_EOL, '', $file);
    $op = array();
    $lecss = '';

    require("op.php");

    $lecss = setCss();
    $newCss = opFromFile($lecss);
//var_dump($newCss);
//    $optimised = "";
//    $optimised = printcss(optimise(trim($file)), 0);
//    $longueur_old = strlen($file);
//    $longueur_new = strlen($optimised);
//    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
    ?>

    <body>
        <div class="container">


            <h1>Optimiseur de CSS simple</h1>

            <?php
            $filepath = "css/8.css";
            require("tpl/demo_line.php");
            ?>
            <hr />


            TODO:

            -faire des sélecteurs a virgule si besoin
            -permettre d'extraire des instructions selon leur stype dans des résultats séparés. Par exemple: sortir un ensemble de sélecteurs ne donnant que des instructions sur les font-size, font-weight.

            <?php
            require('tpl/form.php');

            require('tpl/demos.php');
            ?>

            <div  class="">
                <h1>Logs</h1>
                <div id="log" class="css" >
                    écrasements: <pre><?php var_dump($GLOBALS['ecrasement']); ?></pre>

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
        </div>
        <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        
        <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
        <script>
            $(document).ready(function() {
                    $('code,  pre').addClass('prettyprint linenums');
                    $('.prettyprint').prettyPrint();
            });
        </script>
    </body>
</html>


