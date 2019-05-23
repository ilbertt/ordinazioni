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
  <p class='beforetable'></p>
  <table id='tb-conto'>
    <thead>
      <tr>
        <th style='width:75%' id='indice-conto'><a href='#indice-conto'>CONTO</a></th>
        <th style='width:20%; text-align:center'>Prezzo</th>
        <th style='width:5%; text-align:center'>Quantit&#224;</th>
      </tr>
    </thead>
    <tbody>
      <!-- <tr>
            <td $class><span id='conto-nome'>Prova</span><br><span class='descr'>descr</span></td>
            <td $class style='text-align: center;'>&#8364; <span id='conto-prezzo'>3.50</span></td>
            <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='conto-qta' data-idprod='$idprod'/></td>
            </tr> -->
    </tbody>
  </table>
  <span style='font-size:1.5em;'><span><a href='#indice' style='color:#ff3333'>Torna all'indice</a></span><span style='float: right;'><a href='#conto' style='color:#ff3333'>Vai al conto</a></span></span>
</div>
<button class='button' id='btn-send'>INVIA</button>

<?php
require_once 'closer.php';
