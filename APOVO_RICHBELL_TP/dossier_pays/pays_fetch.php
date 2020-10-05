<?php


$liste_pays= $connexion -> query("SELECT * FROM pays");

foreach ($liste_pays as $un_pays) {

    echo "<tr id='". $un_pays['codePays'] ."'>
            <td>". $un_pays['codePays'] ."</td>
             <td>". $un_pays['nbhabitant'] ."</td>
          </tr>";
};
?>