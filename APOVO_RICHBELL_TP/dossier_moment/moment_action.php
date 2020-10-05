
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement d'un moment

                 //===== Etape 2 : Insertion d'un moment dans la base
                 $req="INSERT INTO moment(jour) VALUES(:jour)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":jour" => $_POST["rec-moment"]
                 ));
                 if($insertion_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Le Jour à été bien ajouté";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de l'enregistrement";
            }

            echo json_encode($tab_retour);

            break;

          
       case "modifier" :
            $tab_retour = array();
            
            //===== Etape 3 : Modification de moment 
            $update_query = "UPDATE moment SET jour = :jour                
                             WHERE jour = :jour";

            $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                    ":jour" => $_POST["rec-moment"]

                ));
            if($update_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les informations de moment ont bien été mis à jour";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de la modification";
            }

            echo json_encode($tab_retour);
            break;
         //pour recuperer
        case "recuperation" :
            if(isset($_POST['jour']))
            { 
                $id = $_POST['jour'];
                $donnees_moment = $connexion -> query("SELECT * FROM moment WHERE jour = '".$id."'")
                -> fetch();

            echo json_encode($donnees_moment);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'un jour
        $update_query = "DELETE FROM moment WHERE jour = :jour";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":jour" => $_POST["jour"]
            ));
        if($update_exec) {
            $tab_retour['type'] = "success";
            $tab_retour['message'] = "Le Jour a bien été supprimer";
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
