<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config.php';

$id = $_POST['id'];
$name = $_POST['name'];
$num = $_POST['num'];
$tot = $_POST['tot'];
$text = $_POST['text'];
$nota = $_POST['note'];

global $mysqli;

$text = str_replace('€', '', $text);
$text = cleanString($text);
$menuarr = ['appetizer', 'hamburger', 'sandwich', 'bevande', 'dolci'];
$arr = explode(',', $text);
$arr_nota = explode('[',$nota);

$i = 0;

foreach ($arr as $line) {
    $arrline = explode('X', $line);
    $testo = rtrim($arrline[0]);
    $nota_db = $arr_nota[$i];

    if(!$nota_db || $nota_db === ''){
        $nota_db = '-';
    }

    for ($mnum = 0; $mnum < count($menuarr); $mnum++){
        $sqlprod = "SELECT * FROM `menu-$menuarr[$mnum]` WHERE `nome` = '$testo'";
        $stmt = $mysqli->query($sqlprod);
        if($stmt->num_rows > 0){
            while($row = $stmt->fetch_assoc()){
                $idprod = $row['idprod'];
            }
            break;
        }
    }
    $afterx = substr($line, strpos($line, "X") + 1);
    $arrqta = explode(' ', $afterx);

    for($x=0; $x < count($arrqta); $x++){
        $qta = $arrqta[0];
        $prezzo = $arrqta[1];
    }

    $sql = "INSERT INTO `ordini` (`IDOrd`, `Nome`, `Tavolo`, `IDProd`, `Qta`, `Note`) VALUES ('$id', '$name', '$num', '$idprod', '$qta', '$nota_db')";
    if($mysqli->query($sql)){
        echo "";
    } else{
        echo "$sql<br>$mysqli->error";
    }

    $i++;
}
