<?php

require_once 'config/config.php';
global $mysqli;

if(isset($_POST)){

  $order_data = $_POST['order-data'];
  $order_prods = $_POST['order-prods'];

  $name = $order_data['name'];
  $table = $order_data['table'];
  $idord = $order_data['idord'];


  foreach($order_prods as $idprod => $qta)
  {
    $sql = "INSERT INTO `ordini` (`idord`, `name`, `table`, `idprod`, `qta`) VALUES ('$idord', '$name', '$table', '$idprod', '$qta')";
    if($mysqli->query($sql)){
      $res = true;
    } else{

      $res = false;
      break;
    }
  }

  if($res){
    echo "Completato!
          <br>
          Vai in cassa a ritirare gli scontrini :)
          <br>
          <a href='ordina.php?n=$name&t=$table' id='neworder'>Nuovo ordine</a>";
  }else{
    echo "$sql<br>$mysqli->error";
    echo "C'&#232; stato un errore... Ci scusiamo per il disagio
          <br>
          <a href='ordina.php?n=$name&t=$table' id='neworder'>Rifai ordine</a>";
  }
} else{
  echo "Nothing.";
}

?>
