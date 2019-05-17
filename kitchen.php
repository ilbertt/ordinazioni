<?php
require_once 'header.php';

if(isset($_GET)){
    $settore = $_GET['s'];
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div class='tabs'>
    <?php echo printOrdiniCucina($settore); ?>
</div>
<?php
// put your code here
?>
<script type="text/javascript">
    window.setInterval(function(){refreshKitchen('<?php echo $settore;?>');}, 5000); //aggiorna lista cucina ogni 5 secondi
</script>
            
<?php
require_once 'closer.php';