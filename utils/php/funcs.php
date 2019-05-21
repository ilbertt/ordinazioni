<?php
//
//
//
//
//
 function printTables(){ //prendi tutti i tipi di prodotti e stampa una tabella per ogni tipo
   global $mysqli;
   $getTipi = $mysqli->query("SELECT * FROM `Tipo` WHERE 1");

   if ($getTipi->num_rows > 0){

       while ($row = $getTipi->fetch_assoc()){
         $tipo_id = $row['ID'];
         $tipo = $row['Tipo'];

         echo tableContent($tipo_id, $tipo);
       }
    }

 }

 function printIndex(){ //prendi tutti i tipi e stampa l'indice
   global $mysqli;
   $getTipi = $mysqli->query("SELECT * FROM `Tipo` WHERE 1");

   if ($getTipi->num_rows > 0){
       echo "<ul style='margin-top: 0px;'>";

       while ($row = $getTipi->fetch_assoc()){
         $tipo_id = $row['ID'];
         $tipo = $row['Tipo'];

         echo "<li><a href='#indice-$tipo_id'>$tipo</a></li>";
       }
       echo "<li style='margin-top: 10px;'><a href='#conto'>Vai al conto</a></li>
             </ul>";
    }
 }

function tableHead($id, $displayname){
  echo "<p class='beforetable'></p>
            <table id='tb-$id'>";
  echo "<thead><tr>
          <th style='width:75%' id='indice-$id'><a href='#indice-$id'>$displayname</a></th>
          <th style='width:20%; text-align:center'>Prezzo</th>
          <th style='width:5%; text-align:center'>Quantit&#224;</th>
        </tr></thead>";
}

function tableContent($tipo_id, $tipo){
  global $mysqli;
  //$stmt = $mysqli->query("SELECT Prodotti.ID, Prodotti.IDProd, Prodotti.Nome, Prodotti.Descr, Prodotti.Prezzo, Tipo.Tipo FROM Prodotti LEFT JOIN Tipo ON Prodotti.Tipo = Tipo.ID WHERE Prodotti.Tipo = '$tipo'");
  $stmt = $mysqli->query("SELECT * FROM `Prodotti` WHERE `Tipo` = '$tipo_id' AND `fuori-listino` IS FALSE");

  if ($stmt->num_rows > 0){
      $x = 0;
      echo tableHead($tipo_id, $tipo);

      while ($row = $stmt->fetch_assoc()){
          $id = $row['ID'];
          $idprod = $row['IDProd'];
          //$Tipo = $row['Tipo'];
          $nome = $row['Nome'];
          $descr = $row['Descr'];
          $prezzo = $row['Prezzo'];

          if($x % 2 == 0) {
              $class = "class='tdp'";
          } else{
              $class = '';
          }

          echo "<tr>
                <td $class><span id='app-n-$id'>$nome</span><br><span class='descr'>$descr</span></td>
                <td $class style='text-align: center;'>&#8364; <span id='app-p-$id'>$prezzo</span></td>
                <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='app-q-$id'/></td>
                </tr>";

          $x++;
      }
      echo tableClose();
  }
}

function tableClose(){
    echo "</table>
          <span style='font-size:1.5em;'><span><a href='#indice' style='color:#ff3333'>Torna all'indice</a></span><span style='float: right;'><a href='#conto' style='color:#ff3333'>Vai al conto</a></span></span>";
}

function cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}
?>
