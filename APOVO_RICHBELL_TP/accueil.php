<?php

require 'connexion.php';

?>

<!DOCTYPE html>
<html>
<head>
<title>Formulaire</title>
<meta charset="UTF-8">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
<meta charset="utf-8" />

<style >

.header{
    background: url('assets/images/Mus.jpg');
    background-size: cover;
    background-position: center bottom;
    height: 100vh;
    margin-left:-48px;
    margin-right:-44px;
}

</style>
</head>
<body>
<section>
<?php require_once 'header.php'; ?>
</section>
<main id="" class="container p-0" style="margin-top: 5%">
<section>

<div class="header">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 text-center h-100 d-flex">
                    <h1 class="m-auto text-light">Visitez les musées!</h1>
                    
                </div>
            </div>

        </div>

    </div>

    <div class="background-1">
        <div class="container py-5">
            <div class="row">
                <div class="col-10 m-auto text-center">
                    <h2 class="mb-5">Nous disposons des formulaires à remplir pour vos choix d'ouvrages</h2>

<button type="button" class="btn btn-secondary"><a href="http://localhost/APOVO_RICHBELL_TP/dossier_pays/formulaire_pays.php"> Pays </a></button>
<button type="button" class="btn btn-warning"> <a href="http://localhost/APOVO_RICHBELL_TP/dossier_moment/moment.php"> Moment </a></button>
<button type="button" class="btn btn-success"><a href="http://localhost/APOVO_RICHBELL_TP/dossier_musee/formulaire_musee.php"> Musee</a></button>
<button type="button" class="btn btn-danger"> <a href="http://localhost/APOVO_RICHBELL_TP/dossier_visiter/formulaire_visiter.php">Visiter</a></button>
<button type="button" class="btn btn-link"><a href="http://localhost/APOVO_RICHBELL_TP/dossier_ouvrage/formulaire_ouvrage.php"> Ouvrage</a></button>
<button type="button" class="btn btn-warning"><a href="http://localhost/APOVO_RICHBELL_TP/dossier_bibliotheque/formulaire_bibliotheque.php"> Bibliotheque</a></button>
<button type="button" class="btn btn-light"><a href="http://localhost/APOVO_RICHBELL_TP/dossier_site/formulaire_site.php">Site</a> 
<button type="button" class="btn btn-dark"><a href="http://localhost/APOVO_RICHBELL_TP/dossier_referencer/formulaire_referencer.php">Referencer</a></button>

                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col text-right">
                <h2>CONTACTEZ-NOUS!</h2>
            </div>
            <div class="col-8">
                <form>
                    <div class="form-group">
                        <label for="exampleInputName">Nom</label>
                        <input type="name" class="form-control" id="exampleInputName" aria-describedby="name"
                            placeholder="Entrer votre nom">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Adresse Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Entrer votre mail">
                        <small id="emailHelp" class="form-text text-muted">Eh bien, ne partagez jamais votre email avec quelqu'un d'autre
                            </small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputSubject">Sujet</label>
                        <input type="subject" class="form-control" id="exampleInputSubject" aria-describedby="subject"
                            placeholder="Entrer votre sujet">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Votre message</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Envoyer un message</button>
                </form>
            </div>
        </div>
    </div>

</section>

</main>

<section>
<?php require_once 'footer.php'; ?>
</section>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/jquery.datatables.js"></script>




</body>
</html>	