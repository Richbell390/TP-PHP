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
        <h3 class="text-secondary text-info">Ouvrage</h3>
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
	<form id="formulaire_ouvrage" method="post" action="ouvrage_action.php">
                  
	
                                    <label for="rec-ISBN" class="text-left">ISBN:</label>
                                    <input type="text" class="form-control" id="rec-ISBN" name="rec-ISBN" required>
                                </div>
                         
                                <div class="form-group">
                                    <label for="rec-nbPage">Nombre de Page :</label>
                                    <input type="number" class="form-control" id="rec-nbPage" name="rec-nbPage" required>
                                </div>
                                <div class="form-group">
                                    <label for="rec-titre">Titre :</label>
                                    <input type="text" class="form-control" id="rec-titre" name="rec-titre" required>
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
                                <input type="hidden" id="isbn" name="isbn">
                            
		  <div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
			  <input type="submit" class="btn btn-primary" id="btn_submit_formulaire_ouvrage" value="Enregistrer">
		  </div>


	  </form>
	</div>
	<h1 class="text-center font-weight-bold text-warning">LES OUVRAGES</h1>

    

    <table class="table table-bordered text-center mt-4" id="table_ouvrage">
        <thead class="thead-light">
        <tr>
            <th class='font-weight-bold text-warning'>ISBN</th>
            <th class='font-weight-bold text-warning '>Nombre de pages</th>
            <th class='font-weight-bold text-warning '>Titre</th>
            <th class='font-weight-bold text-warning '>CodePays</th>
            
        </tr>
        </thead>
        <tbody>
		<?php 
		$liste_ouvrage= $connexion -> query("SELECT ISBN,nbPage,titre,pays.codePays FROM pays,ouvrage WHERE 
        pays.codePays=ouvrage.codePays");


			foreach ($liste_ouvrage as $un_ouvrage) {

	echo "<tr id='".$un_ouvrage['ISBN'] ."'>
			<td>". $un_ouvrage['ISBN'] ."</td>
            <td>". $un_ouvrage['nbPage'] ."</td>
            <td>". $un_ouvrage['titre'] ."</td>
            <td>". $un_ouvrage['codePays'] ."</td>
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
        //Initialiser les animations avec la ouvragee animate.min.css
        new WOW().init();

        //id de l'isbn actif
        var ISBN = '';

        //Initialisation de Datatable
        $('#table_ouvrage').dataTable(
            {
                "paging": false
            }
        );

        //====Correction de dataTable
        var table_container_width = $('#table_ouvrage_wrapper').width() + 52;

        $('#table_ouvrage_wrapper .row').css({"width":table_container_width});
        $('#table_ouvrage_length select').css({"margin-left":10,"margin-right":10});
        //====Correction de dataTable
        //Gestion du click sur les lignes du tableau
        $('#table_ouvrage tr').click(function() {

            //retirer la classe "selected" de toutes les autres lignes du tableau
            $('#table_ouvrage tr').removeClass('selected');

            //Attribuer la classe "selected" à la ligne sélectionné
            $(this).addClass('selected');

            //Activer les boutons d'actions
            $('.btn-actions').removeAttr('disabled');

            //On charge l'id de l'ouvrage
          ISBN = $(this).attr('id');

        });

        //gérer nous-même la soumission du formulaire
        $('#formulaire_ouvrage').submit(function() {
            event.preventDefault();
            var form_data = $(this).serialize();

            $.ajax({
                url:"ouvrage_action.php",
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
                                .href = 'formulaire_ouvrage.php';
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
            $('#btn_submit_formulaire_ouvrage').val("Modifier");
           
            $.ajax({
                url:"ouvrage_action.php",
                method:"POST",
                data:{action:"recuperation",isbn:ISBN},
                dataType:"json",
                success:function(data) {

                    $('#rec-ISBN').val(data.ISBN);
                    $('#rec-nbPage').val(data.nbPage);
                    $('#rec-titre').val(data.titre);
                    $('#rec-codePays').val(data.codePays);

                    $('#ISBN').val(data.isbn);

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
                text: "Êtes-vous sûr de vouloir supprimer cet ouvrage ?",
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


   
