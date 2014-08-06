<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$rendu ="palette: <div class='palette'>";
$pal = array_unique($tab[0]);
sort($pal);
foreach ($pal as $key => $value) {
    $rendu .="<div class='color_tile' style='background: $value'>$value</div>";
}
$rendu .="</div>";
echo $rendu;