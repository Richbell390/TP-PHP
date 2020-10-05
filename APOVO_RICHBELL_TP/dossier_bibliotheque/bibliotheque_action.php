
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement d'une bibliotheque

                 //===== Etape 2 : Insertion d'un bibliotheque dans la base
                 $req="INSERT INTO bibliotheque( numMus, ISBN, dateAchat) VALUES(:numMus,:ISBN,:dateAchat)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":numMus" => $_POST["rec-numMus"],
                     ":ISBN" => $_POST["rec-ISBN"],
                     ":dateAchat" => $_POST["rec-dateAchat"]
                   
                 ));
                 if($insertion_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "La bibliotheque à été bien ajouté";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de l'enregistrement";
            }

            echo json_encode($tab_retour);

            break;

          
       case "modifier" :
            $tab_retour = array();
            
            //===== Etape 3 : Modification d'une bibliotheque
            $update_query = "UPDATE bibliotheque SET numMus = :numMus,
                                               ISBN = :ISBN,
                                                dateAchat = :dateAchat
                                              
                             WHERE numMus = :numMus";

            $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                    ":numMus" => $_POST["rec-numMus"],
                    ":ISBN" => $_POST["rec-ISBN"],
                    ":dateAchat" => $_POST["rec-dateAchat"],
                    ":numMus" => $_POST["numMus"]
                ));
            if($update_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les informations de la bibliotheque ont bien été mises à jour";
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
                $donnees_bibliotheque = $connexion -> query("SELECT * FROM bibliotheque WHERE numMus = '".$id."'")
                -> fetch();

            echo json_encode($donnees_bibliotheque);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'une bibliotheque
        $update_query = "DELETE FROM bibliotheque WHERE numMus = :numMus";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":numMus" => $_POST["numMus"]
            ));
        if($update_exec) {
            $tab_retour['type'] = "success";
            $tab_retour['message'] = "La bibliotheque a bien été supprimé";
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
