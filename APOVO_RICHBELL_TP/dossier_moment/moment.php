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
        <h3 class="text-secondary text-info">Moment</h3>
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
	<form id="moment" method="post" action="moment_action.php">
                  
				  <div class="form-group">
					  <label for="rec-moment" class="text-left">Jour :</label>
					  <input type="date" class="form-control" id="rec-moment" name="rec-moment" required>
				  </div>

				  <input type="hidden" id="action" name="action" value="ajout">
                                <input type="hidden" id="jour" name="jour">
                               
		  <div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			  <input type="submit" class="btn btn-primary" id="btn_submit_moment" value="Enregistrer">
		  </div>


	  </form>
	</div>
	<h1 class="text-center font-weight-bold text-warning">LISTE DES JOURS</h1>

    

    <table class="table table-bordered text-center mt-4" id="table_moment">
        <thead class="thead-light">
        <tr>
            <th class='font-weight-bold text-warning'>jour</th>
            
        </tr>
        </thead>
        <tbody>
		<?php 
		$liste_moment= $connexion -> query("SELECT * FROM moment");

			foreach ($liste_moment as $un_moment) {

	echo "<tr id='". $un_moment['jour'] ."'>
			<td>". $un_moment['jour'] ."</td>
             
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
        //Initialiser les animations avec moment animate.min.css
        new WOW().init();

        //id du jour
        var jour = '';

        //Initialisation de Datatable
        $('#table_moment').dataTable(
            {
                "paging": false
            }
        );

        //====Correction de dataTable
        var table_container_width = $('#table_moment_wrapper').width() + 52;

        $('#table_moment_wrapper .row').css({"width":table_container_width});
        $('#table_moment_length select').css({"margin-left":10,"margin-right":10});
        //====Correction de dataTable
        //Gestion du click sur les lignes du tableau
        $('#table_moment tr').click(function() {

            //retirer la classe "selected" de toutes les autres lignes du tableau
            $('#table_moment tr').removeClass('selected');

            //Attribuer la classe "selected" à la ligne sélectionné
            $(this).addClass('selected');

            //Activer les boutons d'actions
            $('.btn-actions').removeAttr('disabled');

            //On charge l'id du jour actif
          jour = $(this).attr('id');

        });

        //gérer nous-même la soumission du formulaire
        $('#moment').submit(function() {
            event.preventDefault();
            var form_data = $(this).serialize();

            $.ajax({
                url:"moment_action.php",
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
                                .href = 'moment.php';
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
            $('#btn_submit_moment').val("Modifier");//le bouton enregistrer change pour modifier
			
            $.ajax({
                url:"moment_action.php",
                method:"POST",
                data:{action:"recuperation",jour:jour},
                dataType:"json",
                success:function(data) {

                    $('#rec-moment').val(data.jour);
                    $('#jour').val(data.jour);
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
                text: "Êtes-vous sûr de vouloir supprimer ce jour ?",
                type: 'warning',
                cancelButtonText: 'Non',
                confirmButtonText: 'Oui',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
            }).then((result) => {
                if (result.value === true) {
					
                    $.ajax({
                        url: 'moment_action.php',
                        method:"POST",
                        data:{action:"supprimer",jour:jour},
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
                                    .href = 'moment.php';
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


   
