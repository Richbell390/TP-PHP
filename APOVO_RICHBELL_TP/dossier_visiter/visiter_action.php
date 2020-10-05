
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement 

                 //===== Etape 2 : Insertion d'une visite dans la base
                 $req="INSERT INTO visiter( numMus, jour, nbvisiteurs) VALUES(:numMus,:jour,:nbvisiteurs)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":numMus" => $_POST["rec-numMus"],
                     ":jour" => $_POST["rec-jour"],
                     ":nbvisiteurs" => $_POST["rec-nbvisiteurs"]
                   
                 ));
                 if($insertion_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = " Une visite a été bien ajoutée";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de l'enregistrement";
            }

            echo json_encode($tab_retour);

            break;

          
       case "modifier" :
            $tab_retour = array();
            
            //===== Etape 3 : Modification d'une visite
            $update_query = "UPDATE visiter SET numMus=:numMus,
                                                 jour = :jour,
                                                 nbvisiteurs = :nbvisiteurs
                                                          
                             WHERE numMus = :numMus";
                echo $update_query;
          $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                    ":numMus" => $_POST["rec-numMus"],
                    ":jour" => $_POST["rec-jour"],
                    ":nbvisiteurs" => $_POST["rec-nbvisiteurs"],
                    ":numMus" => $_POST["numMus"]
                ));
            if($update_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les informations de la visite ont bien été mises à jour";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de la modification";
            }

            echo json_encode($tab_retour);
            break;
         
        case "recuperation" :
            if(isset($_POST['numMus']))
            { 
                $id = $_POST['numMus'];
                $donnees_visiter = $connexion -> query("SELECT * FROM visiter WHERE numMus = '".$id."'")
                
                
                -> fetch();

            echo json_encode($donnees_visiter);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'une visite
        $update_query = "DELETE FROM  visiter WHERE numMus = :numMus";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":numMus" => $_POST["numMus"]
            ));
        if($update_exec) {
            $tab_retour['type'] = "success";
            $tab_retour['message'] = "La visite a bien été supprimée";
        }
        else {
            $tab_retour['type'] = "error";
            $tab_retour['message'] = "Une erreur est survenue lors de la suppression";
        }
        echo json_encode($tab_retour);
        break;
    }
}
?>




























