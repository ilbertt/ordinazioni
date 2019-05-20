<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'header.php';

if(isset($_GET)){
    $table = $_GET['table'];
}
?>
<div class='inputs'>
    <label for="order-name">Inserisci il tuo nome</label><br>
    <div class="alert" id="alert">Inserisci un nome valido!</div>
    <input class='input-iniziale' id='order-name' required/><br>
    <span>Numero tavolo: <span id='table-num' style="font-weight: bold"><?php echo "$table"?></span></span><br>
    
    <a href='' id='avanti-link'><button class='button-iniziale' id='avanti'>AVANTI</button></a><br>
</div>
<?php
require_once 'closer.php';
