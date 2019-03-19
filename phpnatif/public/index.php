<?php
// déclaration des classes PHP qui seront utilisées
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
include ("../config.php");
// activation de la fonction autoloading de Composer
require __DIR__.'/../vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
// activer le mode debug et le mode de variables strictes
$twig = new Twig_Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
    ]);
    
// charger l'extension Twig_Extension_Debug
$twig->addExtension(new Twig_Extension_Debug());

// création d'une variable avec une configuration par défaut
$config = new Configuration();

// création d'un tableau avec les paramètres de connection à la BDD
$connectionParams = [
    'driver'    => 'pdo_mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'dbname'    =>  $dbname,
    'user'      =>  $user,
    'password'  =>  $password,
    'charset'   => 'utf8mb4',
];

// connection à la BDD
// la variable `$conn` permet de communiquer avec la BDD
$conn = DriverManager::getConnection($connectionParams, $config);

$erreur = "";
$select_planche = "";
$select_serre = "";
$select_preparation = "";


// recuperation de la table zone
$reponse = $conn->query("SELECT * FROM zone");
while($req = $reponse->fetch()){
    $zones[] = $req;
}

// recuperation de la table planche
$reponse = $conn->query("SELECT * FROM planche");
while($req = $reponse->fetch()){
    $planches[] = $req;
}

// recuperation de la table serre
$reponse = $conn->query("SELECT * FROM serre");
while($req = $reponse->fetch()){
    $serres[] = $req;
}

// recuperation de la table legume
$reponse = $conn->query("SELECT * FROM legume");
while($req = $reponse->fetch()){
    $legumes[] = $req;
}

// recuperation de la table tache
$reponse = $conn->query("SELECT * FROM tache");
while($req = $reponse->fetch()){
    $taches[] = $req;
}

if($_POST){

    if(htmlspecialchars($_POST["zone"]) == "Jardin"){
        $select_planche = htmlspecialchars($_POST["planche"]);
        
    }elseif (htmlspecialchars($_POST['serre'])) {
        $select_planche = htmlspecialchars($_POST['planche_serre']);
    }
    
    else {
        $select_planche = null; 
    }

    if(htmlspecialchars($_POST["zone"]) == "Serre"){
        $select_serre = htmlspecialchars($_POST["serre"]);
        
    }else {
        $select_serre = null;
    }
   
    
    $select_zone = htmlspecialchars($_POST["zone"]);
    $select_legume = htmlspecialchars($_POST["legume"]);
    $select_tache = htmlspecialchars($_POST["tache"]);

    if(isset($_POST['tache']) == "Preparation sol"){
        if(isset($_POST["manuel"])){
            $select_preparation = htmlspecialchars($_POST["manuel"]);
            
        }else {
            $select_preparation = htmlspecialchars($_POST["traction"]);
        }
    }

    if(isset($_POST['tache']) == "Récolte"){
        if(isset($_POST["kg"])){
            $select_preparation = htmlspecialchars($_POST['kg']);
        }elseif(isset($_POST['botte'])){
            $select_preparation = htmlspecialchars($_POST['botte']);
        }else {
            $select_preparation = htmlspecialchars($_POST['unite']);
        }
    }
    

    if($select_zone == "Selectionnez une zone" Or $select_legume == "Selectionnez un legume" Or $select_tache == "Selectionnez une tache" Or $select_planche == "Selectionnez une planche" Or $select_serre == "Selectionnez une serre"){
        $erreur = "Veuillez remplir tout les champs";
    } else {
        $req = $conn->prepare('INSERT INTO rotation(zone , number_serre, number_planche ,legume, tache) VALUES(:zone ,:number_serre, :number_planche ,:legume , :tache )');
        $req->execute(array(
            'zone' => $select_zone,
            'number_serre' => $select_serre,
            'number_planche' => $select_planche,
            'legume' => $select_legume,
            'tache' => $select_tache." ".$select_preparation,
        ));
        header('Location: /show.php');
    }
}

// affichage du rendu d'un template
echo $twig->render('index.html.twig', [
// transmission de données au template
    'zones' => $zones,
    'planches' => $planches,
    'serres' => $serres,
    'serre_name' => $serre_name,
    'legumes' => $legumes,
    'taches' => $taches,
    'erreur' => $erreur,
]);
