
<?php

require_once '../connexion.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case "ajout" :


            $tab_retour = array();

            //Enregsitrement d'un site

                 //===== Etape 2 : Insertion d'un site dans la base
                 $req="INSERT INTO site (nomSite, anneedecouv, codePays) VALUES(:nomSite,:anneedecouv,:codePays)";
    
                 $insertion_exec = $connexion -> prepare($req)
                 -> execute(array(

                     ":nomSite" => $_POST["rec-nomSite"],
                     ":anneedecouv" => $_POST["rec-anneedecouv"],
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
            
            //===== Etape 3 : Modification d'un site 
            $update_query = "UPDATE ouvrage SET ISBN = :ISBN,
                                               nbPage = :nbPage,
                                               titre = :titre,
                                                codePays = :codePays
                                              
                             WHERE ISBN = :ISBN";

            $update_exec = $connexion -> prepare($update_query)
                -> execute(array(
                    ":ISBN" => $_POST["rec-ISBN"],
                    ":nbPage" => $_POST["rec-nbPage"],
                    ":titre" => $_POST["rec-titre"],
                    ":codePays" => $_POST["rec-codePays"]
                   
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
            if(isset($_POST['nomsite']))
            { 
                $id = $_POST['nomsite'];
                $donnees_musee = $connexion -> query("SELECT * FROM site WHERE nomSite = '".$id."'")
                -> fetch();

            echo json_encode($donnees_musee);
            }else echo "aucune information";
            
            break;
            
        

        case "supprimer" :
        $tab_retour = array();
        //=====  Suppression d'un site
        $update_query = "DELETE FROM ouvrage WHERE ISBN = :ISBN";

        $update_exec = $connexion -> prepare($update_query)
            -> execute(array(
                ":ISBN" => $_POST["isbn"]
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
