
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement d'un pays

                 //===== Etape 2 : Insertion d'un pays dans la base
                 $req="INSERT INTO pays(codePays, nbhabitant) VALUES(:codePays,:nbhabitant)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":codePays" => $_POST["rec-codePays"],
                     ":nbhabitant" => $_POST["rec-nbhabitant"]
               
                 ));
                 if($insertion_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Le Pays a été bien ajouté";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de l'enregistrement";
            }

            echo json_encode($tab_retour);

            break;

          
       case "modifier" :
            $tab_retour = array();
            
            //===== Etape 3 : Modification du pays 
            $update_query = "UPDATE pays SET codePays = :codePays,
                                               nbhabitant = :nbhabitant
                                                
                                              
                             WHERE codePays = :codePays";

            $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                     ":codePays" => $_POST["rec-codePays"],
                    ":nbhabitant" => $_POST["rec-nbhabitant"]
                ));
            if($update_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les informations de ce pays ont bien été mis à jour";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de la modification";
            }

            echo json_encode($tab_retour);
            break;
         
        case "recuperation" :
            if(isset($_POST['codePays']))
            { 
                $id = $_POST['codePays'];
                $donnees_pays = $connexion -> query("SELECT * FROM pays WHERE codePays = '".$id."'")
                -> fetch();

            echo json_encode($donnees_pays);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'un pays
        $update_query = "DELETE FROM pays WHERE codePays = :codePays";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":codePays" => $_POST["codePays"]
            ));
        if($update_exec) {
            $tab_retour['type'] = "success";
            $tab_retour['message'] = "Cette ligne a bien été supprimé";
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
