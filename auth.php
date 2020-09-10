<?php 
/**
 * BASE_URL:/backend/auth.php?service=
 * donner aux clients tous les services: auth, register,...
 * services
 * * auth(login, pass) return (status,code,id, prenom, nom, login) du user
 * * * Pour l'authentification des users
 * * * Methode: POST
 * * register(nom, prenom, login, pass) return code
 * * * pour une creation de compte
 * * * Methode: POST
 * * * code=
 * * * * 0 action reussi avec succès
 * * * * 1 problème d'accès à la base
 */
 include_once("./config/config-bd.php");
 header('Content-Type: application/json');
 $service=$_GET['service'];
switch ($service) {
    case 'auth':
        ///backend/auth.php?service=auth
        //login=diouf&pass=essa123
        //1-recupération des infos
        $login=$_REQUEST['login'];
        $pass=$_REQUEST['pass'];
        $pass=SHA1($pass);

        //2-Lancement des requetes dans la base
        $requete="SELECT * FROM `users` WHERE 
            `login`='".$login."' AND `pass`='".$pass."'";

        $resultat=$connexion->query($requete);
        $return =array("id"=>0,"prenom"=>"","nom"=>"","code"=>"99","status"=>"faild");
        //3- parcours des resultats de la requetes
        foreach($resultat as $row) {
            $return["id"]=$row['id'];
            $return["prenom"]=$row['prenom'];
            $return["nom"]=$row['nom'];
            $return["code"]="0";
            $return["status"]="success";

           //creation de la session pour ne plus lui demander de s'authentifier
           $_SESSION['user']= $return;
        }
        //4-Reponse jsonisé au client.
        echo(json_encode($return));
        break;

    case 'register':
        //1-recupération des infos
        //2-Lancement des requetes dans la base
        //3- parcours des resultats de la requetes
        //4-Reponse jsonisé au client.
        break;
    default:
        # code...
        break;
}



?>