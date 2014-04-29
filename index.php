
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
    $filepath = "css/1.css";
    $file = file_get_contents($filepath);
    $file = str_replace(PHP_EOL, '', $file);
    $op = array();
    $lecss = '';

    require("op.php");

    $lecss = setCss();
    $newCss = opFromFile($lecss);
//var_dump($newCss);
    $optimised = "";
    $optimised = printcss(optimise(trim($file)), 0);
    $longueur_old = strlen($file);
    $longueur_new = strlen($optimised);
    $gain_compression = (1 - round($longueur_new / $longueur_old, 2) ) * 100 . '%';
    ?>

    <body>
        <div class="container">


            <h1>Optimiseur de CSS simple</h1>
            
            <h2>Expected:</h2>
            <div class="span4 well">
                a{
                margin: 1px 2px 3px 4px; 
                }
                b{
                margin: 10px 0; 
                }
            </div>
            <?php
            
            $filepath = "css/1.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            
            
            <div class="row">
                <div class="span5">
                    <div class="alert alert-info">
                        Cet optimiseur n'est pas compatible avec les média queries pour l'instant
                        <br/>L'optimisation comprend:
                        La non répétition des sélecteurs, des instructions qui se retrouvent écrasées.
                    </div>
                </div>
                <div class="span5">
                    <form action="" method="POST">
                        <textarea name="lecss" id="lecss" cols="60" rows="10"><?php echo $lecss; ?></textarea>
                        <input class="btn btn-primary" type="submit" value="optimiser"/>
                    </form>
                </div>
                
            </div>
                <?php
                if ($newCss != '') {

                    echo ' <h1> Résultat:</h1> <div class="well" contenteditable=true > ' . $newCss . '</div>';
                }
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
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>


