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
<h3 class="text-secondary text-info">Pays</h3>
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
	<form id="formulaire_pays" method="post" action="pays_action.php">
                  
                    <div class="form-group">
					  <label for="rec-codePays" class="text-left">CodePays :</label>
					  <input type="text" class="form-control" id="rec-codePays" name="rec-codePays" required>
				    </div>


				  <div class="form-group">
					  <label for="rec-nbhabitant" class="text-left">Nbhabitant :</label>
					  <input type="number" class="form-control" id="rec-nbhabitant" name="rec-nbhabitant" required>
				  </div>

		  <div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			  <input type="submit" class="btn btn-primary" id="btn_submit_formulaire_pays" value="Enregistrer">
		  </div>

		  
		  						<input type="hidden" id="action" name="action" value="ajout">
                                <input type="hidden" id="codePays" name="codePays">

	  </form>
	</div>
	<h1 class="text-center font-weight-bold text-warning">LISTE DES NOMBRES D'HABITANTS</h1>

    

    <table class="table table-bordered text-center mt-4" id="table_pays">
        <thead class="thead-light">
        <tr>
            <th class='font-weight-bold text-warning'>CodePays</th>
            <th class='font-weight-bold text-warning '>Nbhabitants</th>
            
        </tr>
        </thead>
        <tbody>
		<?php 
		$liste_pays= $connexion -> query("SELECT * FROM pays");

			foreach ($liste_pays as $un_pays) {

	echo "<tr id='". $un_pays['codePays'] ."'>
			<td>". $un_pays['codePays'] ."</td>
             <td>". $un_pays['nbhabitant'] ."</td>
          </tr>";
				}
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
        //Initialiser les animations avec la table pays  animate.min.css
        new WOW().init();

        //id du codePays actif
        var codePays = '';

        //Initialisation de Datatable
        $('#table_pays').dataTable(
            {
                "paging": false
            }
        );

        //====Correction de dataTable
        var table_container_width = $('#table_pays_wrapper').width() + 52;

        $('#table_pays_wrapper .row').css({"width":table_container_width});
        $('#table_pays_length select').css({"margin-left":10,"margin-right":10});
        //====Correction de dataTable
        //Gestion du click sur les lignes du tableau
        $('#table_pays tr').click(function() {

            //retirer la classe "selected" de toutes les autres lignes du tableau
            $('#table_pays tr').removeClass('selected');

            //Attribuer la classe "selected" à la ligne sélectionné
            $(this).addClass('selected');

            //Activer les boutons d'actions
            $('.btn-actions').removeAttr('disabled');

            //On charge l'id de du num actif
           codePays = $(this).attr('id');

        });

        //gérer nous-même la soumission du formulaire
        $('#formulaire_pays').submit(function() {
            event.preventDefault();
            var form_data = $(this).serialize();

            $.ajax({
                url:"pays_action.php",
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
                                .href = 'formulaire_pays.php';
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
            $('#btn_submit_formulaire_pays').val("Modifier");
           
            $.ajax({
                url:"pays_action.php",
                method:"POST",
                data:{action:"recuperation",codePays:codePays},
                dataType:"json",
                success:function(data) {

                    $('#rec-nbhabitant').val(data.nbhabitant);
                    $('#rec-codePays').val(data.codePays);
                   	$('#codePays').val(data.codePays);

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
                text: "Êtes-vous sûr de vouloir supprimer cette information ?",
                type: 'warning',
                cancelButtonText: 'Non',
                confirmButtonText: 'Oui',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
            }).then((result) => {
                if (result.value === true) {
                    $.ajax({
                        url: 'pays_action.php',
                        method:"POST",
                        data:{action:"supprimer",codePays:codePays},
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
                                    .href = 'formulaire_pays.php';
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


   
