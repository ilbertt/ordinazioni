<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST)){
    $settore = $_POST['s'];
}

require_once 'config.php';

echo printOrdiniCucina($settore);
