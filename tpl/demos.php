<?php
            $filepath = "css/test.css";
    require("tpl/demo_line.php");
            ?>

<h2>Expected:</h2>
            <div class="span4 well">
a{margin:1px 2px 3px 4px ;}

b{margin:10px 0;}

c{margin:10px 0 200px;}

d{margin:10px;}
            </div>
            <?php
            
            $filepath = "css/1.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            
            <h2>Expected:</h2>
            <div class="span4 well">
                a{
                border: 1px 2px 3px 4px; 
                }
                b{
                border: 10px 0; 
                }
            </div>
            
            <?php
            $filepath = "css/2.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            <h2>Expected:</h2>
            <div class="span4 well">
                a{
                padding: 1px 2px 3px 4px; 
                }
                b{
                padding: 10px 0; 
                }
            </div>
            <?php
            $filepath = "css/3.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            <?php
            $filepath = "css/4.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            <?php
            $filepath = "css/5.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            <?php
            $filepath = "css/6.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            <?php
            $filepath = "css/7.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
            <?php
            $filepath = "css/8.css";
            require("tpl/demo_line.php");
            ?>
            <hr />
