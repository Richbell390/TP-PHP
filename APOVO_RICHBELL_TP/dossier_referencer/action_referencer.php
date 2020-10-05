
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement 

                 //===== Etape 2 : Insertion d'un musee dans la base
                 $req="INSERT INTO referencer( nomSite,numeroPage,ISBN) VALUES(:nomSite,:numeroPage,:ISBN)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":nomSite" => $_POST["rec-nomSite"],
                     ":numeroPage" => $_POST["rec-numeroPage"],
                     ":ISBN" => $_POST["rec-ISBN"]
                   
                 ));
                 if($insertion_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les References ont été bien ajouté";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de l'enregistrement";
            }

            echo json_encode($tab_retour);

            break;

          
       case "modifier" :
            $tab_retour = array();
            
            //===== Etape 3 : Modification d'une séance 
            $update_query = "UPDATE referencer SET nomSite = :nomSite,
                                                        numeroPage = :numeroPage,
                                                        ISBN = :ISBN
                                                          
                             WHERE nomSite = :nomSite";

            $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                    ":nomSite" => $_POST["rec-nomSite"],
                    ":numeroPage" => $_POST["rec-numeroPage"],
                    ":ISBN" => $_POST["rec-ISBN"],
                    ":nomSite" => $_POST["nomSite"]
                ));
            if($update_exec) {
                $tab_retour['type'] = "success";
                $tab_retour['message'] = "Les informations ont bien été mis à jour";
            }
            else {
                $tab_retour['type'] = "error";
                $tab_retour['message'] = "Une erreur est survenue lors de la modification";
            }

            echo json_encode($tab_retour);
            break;
         
        case "recuperation" :
            if(isset($_POST['nomSite']))
            { 
                $id = $_POST['nomSite'];
                $donnees_musee = $connexion -> query("SELECT * FROM referencer WHERE nomSite = '".$id."'")
                -> fetch();

            echo json_encode($donnees_musee);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'une séance
        $update_query = "DELETE FROM referencer WHERE nomSite = :nomSite";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":nomSite" => $_POST["nomSite"]
            ));
        if($update_exec) {
            $tab_retour['type'] = "success";
            $tab_retour['message'] = "Cette ligne a bien été supprimer";
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




























