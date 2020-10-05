
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement d'un Musee

                 //===== Etape 2 : Insertion d'un musee dans la base
                 $req="INSERT INTO Musee( nomMus, nblivres, codePays) VALUES(:nomMus,:nblivres,:codePays)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":nomMus" => $_POST["rec-nomMus"],
                     ":nblivres" => $_POST["rec-nblivres"],
                     ":codePays" => $_POST["rec-codePays"]
                   
                 ));
                 if($insertion_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Le Musee à été bien ajouté";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de l'enregistrement";
            }

            echo json_encode($tab_retour);

            break;

          
       case "modifier" :
            $tab_retour = array();
            
            //===== Etape 3 : Modification de musee 
            $update_query = "UPDATE musee SET nomMus = :nomMus,
                                               nblivres = :nblivres,
                                                codePays = :codePays
                                              
                             WHERE numMus = :numMus";

            $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                    ":nomMus" => $_POST["rec-nomMus"],
                    ":nblivres" => $_POST["rec-nblivres"],
                    ":codePays" => $_POST["rec-codePays"],
                    ":numMus" => $_POST["numMus"]
                ));
            if($update_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les informations du musee ont bien été mis à jour";
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
                $donnees_musee = $connexion -> query("SELECT * FROM musee WHERE numMus = '".$id."'")
                -> fetch();

            echo json_encode($donnees_musee);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'un Musee
        $update_query = "DELETE FROM musee WHERE numMus = :numMus";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":numMus" => $_POST["numMus"]
            ));
        if($update_exec) {
            $tab_retour['type'] = "success";
            $tab_retour['message'] = "Le musee a bien été supprimer";
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
