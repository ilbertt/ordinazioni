<?php
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
?>
<!--<span style="font-size: 3em; color: red;"id="indicazione-gluten">Gli ordini sono chiusi! Si prega il cliente di recarsi in cassa per effettuare un ordine</span><br><br>-->


<div class='order-name'>
    <!--<span style="font-size: 3em; color: red;"id="indicazione-gluten">Le piadine indicate con * sono disponibili anche senza glutine!</span><br><br>-->
    <p id='id-ordine'>ID Ordine: <span id='span-idord' style='font-weight: bold'><?php echo $newid;?></span></p>
    <p>Ordine di: <span id='nome-ordine' style='font-weight: bold;'><?php echo "$order_name"?></span></p>
    <p>Numero tavolo: <span id='numero-tavolo' style='font-weight: bold;'><?php echo "$table_num"?></span></p>
</div>
<br>
<div class='completed' id='completed' style='display: none;'>
  Completato!<br> Vai in cassa a ritirare gli scontrini :)
  <br>
  <a href='ordina.php?n=<?php echo $order_name?>&t=<?php echo $table_num?>' id='neworder'>Nuovo ordine</a>
</div>
<div class='indice'>
       <span style='font-size: 1.5em;' id='indice'>Indice</span>
       <?php echo printIndex(); ?>
</div>
<div class='tabs'>
  <div id='prodotti'>
    <?php echo printTables(); ?>
  </div>
  <div id='conto' style='display: none;'>
    <p class='beforetable'></p>
    <div class='under-table'>
      <span>
        <button style='background-color: red;'><a href='#' style='color:white' onclick='hideConto();'>Torna all'indice</a></button>
      </span>
    </div>
    <table id='tb-conto'>
      <thead>
        <tr>
          <th style='width:75%' id='indice-conto'><a href='#indice-conto'>CONTO</a></th>
          <th style='width:20%; text-align:center'>Prezzo</th>
          <th style='width:5%; text-align:center'>Quantit&#224;</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <p style='text-align: center; margin-top: 40px;'><button class='button' id='btn-send'>INVIA</button></p>
  </div>
</div>


<?php
require_once 'closer.php';
