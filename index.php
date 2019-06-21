<?php
require_once 'header.php';

if(isset($_GET)){
    $table = $_GET['table'];
}
?>
<div class='inputs'>
    <label for="order-name">Inserisci il tuo nome</label><br>
    <div class="alert" id="alert"></div>
    <input class='input-iniziale' id='order-name' required/><br>
    <span>Numero tavolo: <input class='input-iniziale' style='width:20%;' type='number' id='order-table' value='<?php echo "$table"?>' required/></span><br>

    <a href='javascript:void(0);' onclick='initButton();' id='avanti-link'><button class='button-iniziale' id='avanti'>AVANTI</button></a><br>
</div>
<?php
require_once 'closer.php';
