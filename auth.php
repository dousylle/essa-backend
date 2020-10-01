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

 include_once(dirname(__FILE__)."\config-db.php");
 //header('Content-Type: application/json');
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
            `login`='".$login."' AND `password`='".$pass."'";
//echo $requete;
        $resultat=$connexion->query($requete);
        $reponse =array("id"=>0,"prenom"=>"","nom"=>"","code"=>"99","status"=>"faild");
        //3- parcours des resultats de la requetes
        if($resultat){
        foreach($resultat as $row)
         {
            $reponse["id"]=$row['id'];
            $reponse["prenom"]=$row['prenom'];
            $reponse["nom"]=$row['nom'];
            $reponse["code"]="0";
            $reponse["status"]="success";
    

           //creation de la session pour ne plus lui demander de s'authentifier
           $_SESSION['user']= $reponse;
        }
    }
        //4-Reponse jsonisé au client.
        echo(json_encode($reponse));
        break;

    case 'register':
        //1-recupération des infos
        $login=$_REQUEST['login'];
        $pass=$_REQUEST['pass'];
        $pass=SHA1($pass);
        $nom=$_REQUEST['nom'];
        $prenom=$_REQUEST['prenom'];
        //2-Lancement des requetes dans la base
        $requete="INSERT INTO `users`(`id`, `login`,
         `password`, `nom`,`prenom`) 
        VALUES (0,'$login','$pass','$nom','$prenom')";
$resultat=$connexion->query($requete);
$reponse =array("code"=>1);
if($resultat) $reponse["code"]=0;
        //3- parcours des resultats de la requetes
        
        //4-Reponse jsonisé au client.
        echo(json_encode($reponse));
        break;

    default:
        echo "service inconnu";
        break;
}



?>
