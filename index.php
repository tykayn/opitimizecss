
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
    $op = array();
    $lecss = '';

    require("op.php");
    ?>

    <body>
        <div class="container">



            <div class="row-fluid ">
                <div class="span5">
                    <h1>Optimiseur de CSS simple</h1>
                </div>
                <div class="span5">
                    <menu class="navbar affix">
                        <a class="btn btn-primary" href="#palettes">palettes de couleur</a>
                        <a class="btn btn-primary"href="#demos">démos</a>
                        <a class="btn btn-primary" href="https://github.com/tykayn">github tykayn</a>
                        <a class="btn btn-primary" href="http://artlemoine.com">portfolio artlemoine.com</a> 
                    </menu>
                </div>
            </div>

            <section>
                <h2 id="palettes">
                    Palette de couleurs
                </h2>
                Exemple avec <a href="/css/colours.css">cette feuille de style</a>.
                <div class="well">
                    Simplifiez vos feuilles de styles en ayant une idée des redéclarations de couleurs.
                </div>
                <?php
                $filepath = "css/colours.css";
                require("tpl/demo_palette.php");
                ?>
                <div class="well">
                    <h3>
                        Comment obtenir cette palette ?
                    </h3>
                    Pour vos propres feuilles de style, prenez le contenu d'un fichier css et stockez le dans une variable en php, disons $file.
                    utilisez la fonction ePalette($file) là ou vous souhaitez faire apparaitre (avec un echo) votre palette. 

                </div>
            </section>

            <section id="demos">


                <hr />

                <?php
                if (checkPost()) {
                    $lecss = setCss();
                    $newCss = opFromFile($lecss);
                    require('tpl/demo_post.php');
                }
                ?>
                <h2>Démonstrations</h2>

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
            </section>
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
                    <a class="btn btn-primary" href="https://github.com/tykayn">github tykayn</a>
                    <br />
                    <a class="btn btn-primary" href="http://artlemoine.com">portfolio artlemoine.com</a> 
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


