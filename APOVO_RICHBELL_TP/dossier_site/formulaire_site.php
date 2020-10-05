<?php

require '../connexion.php';

?>

<!DOCTYPE html>
<html>
<head>
<title>Formulaire</title>
<meta charset="UTF-8">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
<meta charset="utf-8" />

<style >

body{
    background-color:#f5f5f5;
    background-size: cover;
    
}

</style>
</head>
<body>
<section>
<?php require_once '../header.php'; ?>
</section>
<main id="" class="container p-0" style="margin-top: 7.5%">
<section>

<div class="border-bottom border-secondary w-100 ">
        <h3 class="text-secondary text-info">Site</h3>
    </div>
    <div class="">
        <div class="row">
            <div class="col-6">
                <div class="text-left">
                    <button class="btn btn-success mt-4 btn-actions"  id="btn_modifier" data-toggle="tooltip" data-placement="top" title="Modifier" disabled>
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-danger mt-4 btn-actions"  id="btn_supprimer" data-toggle="tooltip" data-placement="top" title="Supprimer" disabled>
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            <div class="col-6">
                <div class="text-right">
                   
                </div>
            </div>
        </div>
    </div>

	<div class="">
	<form id="formulaire_site" method="post" action="site_action.php">
                  
	
                                    <label for="rec-nomSite" class="text-left">Nom Site:</label>
                                    <input type="text" class="form-control" id="rec-nomSite" name="rec-nomSite" required>
                                </div>
                         
                                <div class="form-group">
                                    <label for="rec-anneedecouv">Annee de couverture :</label>
                                    <input type="number" class="form-control" id="rec-anneedecouv" name="rec-anneedecouv" required>
                                </div>
								<div class="form-group">
                                    <label for="rec-codePays">CodePays :</label>
                                    <select class="form-control" id="rec-codePays" name="rec-codePays" required>
									
                                         <option disabled selected ></option>
                                         <?php $liste_pays= $connexion -> query("SELECT * FROM pays");

                                            foreach ($liste_pays as $un_pays) {

                                        ?>

                                        <option value="<?php echo $un_pays['codePays']  ?> ">

                                            <?php
                                                echo $un_pays['codePays']
                                            ?>
                                        </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            
                                
                                <input type="hidden" id="action" name="action" value="ajout">
                                <input type="hidden" id="nomsite" name="nomsite">
		  <div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			  <input type="submit" class="btn btn-primary" id="btn_submit_formulaire_site" value="Enregistrer">
		  </div>


	  </form>
	</div>
	<h1 class="text-center font-weight-bold text-warning">LE SITE</h1>

    

    <table class="table table-bordered text-center mt-4" id="table_site">
        <thead class="thead-light">
        <tr>
            <th class='font-weight-bold text-warning'>Nom Site</th>
            <th class='font-weight-bold text-warning '>Annee de couverture</th>
			<th class='font-weight-bold text-warning '>CodePays</th>
            
        </tr>
        </thead>
        <tbody>
		<?php 
		$liste_site= $connexion -> query("SELECT nomSite,anneedecouv,pays.codePays FROM pays,site WHERE 
        pays.codePays=site.codePays");


			foreach ($liste_site as $un_site) {

	echo "<tr id='".$un_site['nomSite'] ."'>
			<td>". $un_site['nomSite'] ."</td>
            <td>". $un_site['anneedecouv'] ."</td>
            <td>". $un_site['codePays'] ."</td>
            
          </tr>";
				};
        ?>
        </tbody>
    </table>
</main>
</section>

<section>
<?php require_once '../footer.php'; ?>
</section>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/wow.min.js"></script>
<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="../assets/js/jquery.datatables.js"></script>
<script type="application/javascript">

$(document).ready(function() {
        //Initialiser les animations avec le site animate.min.css
        new WOW().init();

        //id du nom du site actif
        var nomsite = '';

        //Initialisation de Datatable
        $('#table_site').dataTable(
            {
                "paging": false
            }
        );

        //====Correction de dataTable
        var table_container_width = $('#table_site_wrapper').width() + 52;

        $('#table_site_wrapper .row').css({"width":table_container_width});
        $('#table_site_length select').css({"margin-left":10,"margin-right":10});
        //====Correction de dataTable
        //Gestion du click sur les lignes du tableau
        $('#table_site tr').click(function() {

            //retirer la classe "selected" de toutes les autres lignes du tableau
            $('#table_site tr').removeClass('selected');

            //Attribuer la classe "selected" à la ligne sélectionné
            $(this).addClass('selected');

            //Activer les boutons d'actions
            $('.btn-actions').removeAttr('disabled');

            //On charge l'id du nom actif
          nomsite = $(this).attr('id');

        });

        //gérer nous-même la soumission du formulaire
        $('#formulaire_site').submit(function() {
            event.preventDefault();
            var form_data = $(this).serialize();
            //code ajax
            $.ajax({
                url:"site_action.php",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data) {
                    console.log(data);

                    if(data.type === "success") {
                        swal({
                            type: data.type,
                            text: data.message,
                            width: 300,
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-primary"
                        }).then(function() {
                            window
                                .location
                                .href = 'formulaire_site.php';
                        });
                    }
                    else {
                        swal({
                            type: data.type,
                            text: data.message,
                            width: 300,
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-primary"
                        });
                    }

                },
                error:function(data) {
                    console.log(data)
                }
            });
        });


        
        //Lors du click sur le bouton "Modifier"
        $('#btn_modifier').click(function () {
            event.preventDefault();
            $('#action').val('modifier');
            $('#btn_submit_formulaire_site').val("Modifier");
           
            $.ajax({
                url:"site_action.php",
                method:"POST",
                data:{action:"recuperation",nomSite:nomsite},
                dataType:"json",
                success:function(data) {

                    $('#rec-nomSite').val(data.ISBN);
                    $('#rec-anneedecouv').val(data.anneedecouv);
                    $('#rec-codePays').val(data.codePays);

                    $('#nomsite').val(data.nomSite);

                },
                error:function(data) {
                    console.log(data)
                }
            });

          

        });
     

        $('#btn_supprimer').click(function () {
            event.preventDefault();
            swal({
                title: 'Confirmation',
                text: "Êtes-vous sûr de vouloir supprimer cet musee ?",
                type: 'warning',
                cancelButtonText: 'Non',
                confirmButtonText: 'Oui',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
            }).then((result) => {
                if (result.value === true) {
                    $.ajax({
                        url: 'ouvrage_action.php',
                        method:"POST",
                        data:{action:"supprimer",isbn:ISBN},
                        dataType:'json',
                        success: function(data) {
                            console.log(data);
                            swal({
                                type: data.type,
                                title: '',
                                text: data.message
                            }).then(function() {
                                window
                                    .location
                                    .href = 'formulaire_ouvrage.php';
                            })
                        },
                        error:function(data){
                            console.log(data);
                        }
                    })
                }
            })
        });
    });
   
</script>
</body>
</html>	

