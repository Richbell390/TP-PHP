<?php
try{

$connexion = new PDO ('mysql:host=localhost;dbname=musee3','root','');
$connexion -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

} 
catch (PDOException $e)
{
    echo "Une erreure est survenue lors de la connexion a la base de donnees.Veuillez réessayer plus tard <br>";
    echo "Message d'erreur : " .$e -> getMessage();
    die;
}


    
?>