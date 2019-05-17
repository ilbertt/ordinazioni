<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function tableHead($id, $displayname){
    if ($id === 'cucina'){
         echo "<table id='tb-$id'>";
        echo "<thead><tr>
            <th style='width:75%' id='cucina'><a href='#cucina'>Nome</a></th>
            <th style='width:20%; text-align:center'>Quantit&#224;</th>
          </tr></thead>";
    } else{
        echo "<p class='beforetable'></p>
                  <table id='tb-$id'>";
        echo "<thead><tr>
                <th style='width:75%' id='$id'><a href='#$id'>$displayname</a></th>
                <th style='width:20%; text-align:center'>Prezzo</th>
                <th style='width:5%; text-align:center'>Quantit&#224;</th>
              </tr></thead>";
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

function printAppetizerPiatti(){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `menu-appetizer` WHERE 1");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('appetizer', 'Appetizer');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $descr = $row['descrizione'];
            $prezzo = $row['prezzo'];

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

/*function printPiadinePiatti(){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `menu-piadine` ORDER BY `idprod`");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('piadine', 'Piadine');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $descr = $row['descrizione'];
            $prezzo = $row['prezzo'];
            $gluten = $row['gluten'];

            if($x % 2 == 0) {
                $class = "class='tdp'";
            } else{
                $class = '';
            }

            $ingredienti = explode(",", $descr);

            //width: 100%;
    //font-size: 1em;

            if($gluten === '1'){
                echo "<tr style='color: #ff8080;'>
                  <td $class><span id='pia-n-$id'>$nome<!--<span id='gluten' style='color: red;'> *</span>--></span><br><span class='descr'>$descr</span></td>
                  <td $class style='text-align: center;'>&#8364; <span id='pia-p-$id'>$prezzo</span><br><textarea id='pia-i-$id' cols='1' rows='2' style='width: 100%;font-size: 1em;' placeholder='Note'></textarea></td>
                  <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='pia-q-$id'/></td>
                  </tr>";
            } else{
                echo "<tr>
                  <td $class><span id='pia-n-$id'>$nome</span><br><span class='descr'>$descr</span></td>
                  <td $class style='text-align: center;'>&#8364; <span id='pia-p-$id'>$prezzo</span><br><textarea id='pia-i-$id' cols='1' rows='2' style='width: 100%;font-size: 1em;' placeholder='Note'></textarea></td>
                  <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='pia-q-$id'/></td>
                  </tr>";
            }

            $x++;
        }
        echo tableClose();
    }
}*/

function printHamburgerPiatti(){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `menu-hamburger` WHERE 1");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('hamburger', 'Hamburger');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $descr = $row['descrizione'];
            $prezzo = $row['prezzo'];

            if($x % 2 == 0) {
                $class = "class='tdp'";
            } else{
                $class = '';
            }

            echo "<tr>
                  <td $class><span id='ham-n-$id'>$nome</span><br><span class='descr'>$descr</span></td>
                  <td $class style='text-align: center;'>&#8364; <span id='ham-p-$id'>$prezzo</span><br><textarea id='ham-i-$id' cols='1' rows='2' style='width: 100%;font-size: 1em;' placeholder='Note'></textarea></td>
                  <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='ham-q-$id'/></td>
                  </tr>";

            $x++;
        }
        echo tableClose();
    }
}

function printSandwichPiatti(){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `menu-sandwich` WHERE 1");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('sandwich', 'Club Sandwich');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $descr = $row['descrizione'];
            $prezzo = $row['prezzo'];

            if($x % 2 == 0) {
                $class = "class='tdp'";
            } else{
                $class = '';
            }

            echo "<tr>
                  <td $class><span id='san-n-$id'>$nome</span><br><span class='descr'>$descr</span></td>
                  <td $class style='text-align: center;'>&#8364; <span id='san-p-$id'>$prezzo</span><br><textarea id='san-i-$id' cols='1' rows='2' style='width: 100%;font-size: 1em;' placeholder='Note'></textarea></td>
                  <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='san-q-$id'/></td>
                  </tr>";

            $x++;
        }
        echo tableClose();
    }
}

function printBevandePiatti(){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `menu-bevande` WHERE 1");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('bevande', 'Bevande');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $descr = $row['descrizione'];
            $prezzo = $row['prezzo'];

            if($x % 2 == 0) {
                $class = "class='tdp'";
            } else{
                $class = '';
            }

            echo "<tr>
                  <td $class><span id='bev-n-$id'>$nome</span><br><span class='descr'>$descr</span></td>
                  <td $class style='text-align: center;'>&#8364; <span id='bev-p-$id'>$prezzo</span></td>
                  <td $class style='text-align: center;'><input type='number' class='qta' value='0'id='bev-q-$id'/></td>
                  </tr>";

            $x++;
        }
        echo tableClose();
    }
}

function printDolciPiatti(){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `menu-dolci` WHERE 1");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('dolci', 'Dolci');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $descr = $row['descrizione'];
            $prezzo = $row['prezzo'];

            if($x % 2 == 0) {
                $class = "class='tdp'";
            } else{
                $class = '';
            }

            echo "<tr>
                  <td $class><span id='dol-n-$id'>$nome</span><br><span class='descr'>$descr</span></td>
                  <td $class style='text-align: center;'>&#8364; <span id='dol-p-$id'>$prezzo</span></td>
                  <td $class style='text-align: center;'><input type='number' class='qta' value='0' id='dol-q-$id'/></td>
                  </tr>";

            $x++;
        }
        echo tableClose();
    }
}

function printOrdiniCucina($settore){
    global $mysqli;
    $stmt = $mysqli->query("SELECT * FROM `ordini-cucina` WHERE sect = '$settore'");

    if ($stmt->num_rows > 0){
        $x = 0;

        echo tableHead('cucina', 'Cucina');

        while ($row = $stmt->fetch_assoc()){
            $id = $row['id'];
            $nome = $row['nome'];
            $qta = $row['qta'];

            if($x % 2 == 0) {
                $class = "class='tdp'";
            } else{
                $class = '';
            }

            echo "<tr>
                  <td $class><span id='cuc-n-$id'>$nome</span></td>
                  <td $class style='text-align: center;'><span id='cuc-q-$id'>$qta</span></td>
                  </tr>";

            $x++;
        }
        echo "</table>";
    }
}
