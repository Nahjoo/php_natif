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
$serre_name = "";
$select_checkbox = "";


// recover de la table zone
$reponse = $conn->query("SELECT * FROM zone ORDER BY name");
while($req = $reponse->fetch()){
    $zones[] = $req;
}

// recover de la table planche
$reponse = $conn->query("SELECT * FROM planche ORDER BY name");
while($req = $reponse->fetch()){
    $planches[] = $req;
}

// recover de la table serre
$reponse = $conn->query("SELECT * FROM serre ORDER BY name");
while($req = $reponse->fetch()){
    $serres[] = $req;
}

// recover de la table legume
$reponse = $conn->query("SELECT * FROM legume ORDER BY name");
while($req = $reponse->fetch()){
    $legumes[] = $req;
}

// recover table tache
$reponse = $conn->query("SELECT * FROM tache ORDER BY name");
while($req = $reponse->fetch()){
    $taches[] = $req;
}

// lets you know if the form is validated
if($_POST){
    
    // check if the dropdown zone  egale value
    if(htmlspecialchars($_POST["zone"]) == "Jardin"){
        $select_planche = htmlspecialchars($_POST["planche"]);
        
    // elseif check if the dropdown zone  egale value    
    }elseif (htmlspecialchars($_POST['serre'])) {
        $select_planche = htmlspecialchars($_POST['planche_serre']);
    }
    
    // otherwise set the value to null
    else {
        $select_planche = null; 
    }

    // check if the dropdown zone  egale value
    if(htmlspecialchars($_POST["zone"]) == "Serre"){
        $select_serre = htmlspecialchars($_POST["serre"]);
        
    // otherwise set the value to null
    }else {
        $select_serre = null;
    }
   
    // recove value of dropdown zone / legume / tache
    $select_zone = htmlspecialchars($_POST["zone"]);
    $select_legume = htmlspecialchars($_POST["legume"]);
    $select_tache = htmlspecialchars($_POST["tache"]);

    // check if checkbox is checked
    if($_POST['tache'] == "Préparation sol"){
        if(isset($_POST["manuel"])){
            $select_checkbox = htmlspecialchars($_POST["manuel"]);
        }else {
            $select_checkbox = htmlspecialchars($_POST["traction"]);
        }
    }elseif($_POST['tache'] == "Récolte"){
        if(isset($_POST["kg"])){
            $select_checkbox = htmlspecialchars($_POST['kg']);
        }elseif(isset($_POST['botte'])){
            $select_checkbox = htmlspecialchars($_POST['botte']);
        }else {
            $select_checkbox = htmlspecialchars($_POST['unite']);
        }
    }elseif($_POST['tache'] == "Couvert"){
        if(isset($_POST["muchage"])){
            $select_checkbox = htmlspecialchars($_POST['muchage']);
        }elseif(isset($_POST['desherbage'])){
            $select_checkbox = htmlspecialchars($_POST['desherbage']);
        }else {
            $select_checkbox = htmlspecialchars($_POST['bachage']);
        }
    }

    // check if all dropdown as selected or not 
    if($select_zone == "Selectionnez une zone" Or $select_legume == "Selectionnez un legume" Or $select_tache == "Selectionnez une tache" Or $select_planche == "Selectionnez une planche" Or $select_serre == "Selectionnez une serre" Or $select_planche_serre == "Selectionnez une planche"){
        $erreur = "Veuillez remplir tout les champs";

    // if all dropdown as select insert the value in table rotation
    }else {
        $req = $conn->prepare('INSERT INTO rotation(zone , number_serre, number_planche ,legume, tache) VALUES(:zone ,:number_serre, :number_planche ,:legume , :tache )');
        $req->execute(array(
            'zone' => $select_zone,
            'number_serre' => $select_serre,
            'number_planche' => $select_planche,
            'legume' => $select_legume,
            'tache' => $select_tache." ".$select_checkbox,
        ));
        header('Location: /index.php');
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
