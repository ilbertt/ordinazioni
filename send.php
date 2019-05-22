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
        echo "OK";
    } else{
        echo "$sql<br>$mysqli->error";
    }
  }
} else{
  echo "Nothing.";
}

?>
