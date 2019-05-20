<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'header.php';

if(isset($_GET)){
    $order_name = $_GET['n'];
    $table_num = $_GET['t'];
}

global $mysqli;

$sql2 = "INSERT INTO `id-ordini` (`nome`,`table`) VALUES ('$order_name','$table_num')";
if ($mysqli->query($sql2)) {
    $newid = $mysqli->insert_id;
} else {
    $newid = 1;
    echo "Errore: " . $sql2 . "<br>" . $mysqli->error;
}

/*$txt = "SELECT MAX(id) FROM `id-ordini`";
$stmt = $mysqli->query($txt);

if ($stmt->num_rows > 0){
    while ($row = $stmt->fetch_assoc()){
        $id = $row['max'];
        echo $id;
        $true = $row['true'];
    }
    $newid = ++$id;
} else{
    echo "$stmt<br>$mysqli->error";
    $newid=1;
}*/



?>
<!--<span style="font-size: 3em; color: red;"id="indicazione-gluten">Gli ordini sono chiusi! Si prega il cliente di recarsi in cassa per effettuare un ordine</span><br><br>-->


<div class='order-name'>
    <!--<span style="font-size: 3em; color: red;"id="indicazione-gluten">Le piadine indicate con * sono disponibili anche senza glutine!</span><br><br>-->
    <span id='id-ordine' style="display: none;"><?php echo $newid;?></span>
    <span class='ordine'>Ordine di: <span id='nome-ordine' style='font-weight: bold;'><?php echo "$order_name"?></span></span>
    <span class='tavolo'>Numero tavolo: <span id='numero-tavolo' style='font-weight: bold;'><?php echo "$table_num"?></span></span>
</div>
<br>
<div class='completed' id='completed' style='display: none;'>Completato!<br> Vai in cassa a ritirare gli scontrini :)<br><a href='ordina.php?n=<?php echo $order_name?>&t=<?php echo $table_num?>' id='neworder'>Nuovo ordine</a></div>
<div class='completed' id='error' style='display: none;'>C'&#232; stato un errore... Ci scusiamo per il disagio<br><a href='ordina.php?n=<?php echo $order_name?>&t=<?php echo $table_num?>' id='neworder'>Rifai ordine</a></div>
<div class='indice'>
       <span style='font-size: 1.5em;' id='indice'>Indice</span>
       <?php echo printIndex(); ?>
</div>
<div class='tabs'>
  <?php echo printTables(); ?>
</div>
<div class='conto'>
<div class='conto-content'>
    <span style='font-size: 1.5em; color:#ff9933; font-weight: bold; text-decoration: underline;' id='conto'>Conto</span>    <span><a href='#indice' style="font-size:1.2em; color: #ff3333; float: right;">Torna all'indice</a></span><br>
    <span id='ordine'></span><br>
    <span id='totale' style='float: right; font-weight: bold;'></span><br>
    <!--<span style="width: 100%">
    <label for='input-note'>Eventuali note:</label>
    <textarea class='input-note' id='input-note' rows="3" style="width: 100%;"></textarea>
    </span><br>-->
    <button class='button' id='btn-send'>INVIA</button>
</div>
</div>

<?php
require_once 'closer.php';
