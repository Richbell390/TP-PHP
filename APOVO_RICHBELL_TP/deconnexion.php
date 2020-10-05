<?php

//Démarrer la session
session_start();

//Détruire la session
session_destroy();

//redirgier l'utilisateur
header('location:index.php');

?>