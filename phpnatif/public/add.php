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

include ("zone_edit.php");
include ("legume_edit.php");
include ("planche_edit.php");


//****************************Table serre***************************************************
// pagination de la table serre
$reponse = $conn->query("SELECT Count(id) as nbArt FROM serre");
$req = $reponse->fetch();
$nbArt = $req['nbArt'];
$Perpage = 4;
$nbPage = ceil($nbArt/$Perpage);
$cPage = 1;

if(isset($_GET['serre']) && $_GET['serre']>0 && $_GET['serre']<=$nbPage){
    $cPage = $_GET['serre'];
}else {
    $cPage = 1;
}

// recuperation de la table serre
$reponse = $conn->query("SELECT * FROM serre LIMIT ".(($cPage - 1) * $Perpage).",$Perpage");
while($req = $reponse->fetch()){
    $serres[] = $req;
}

if(isset($_GET['id_serre'])){
    $id_serre = $_GET['id_serre'];
    $req = $conn->query("DELETE FROM serre WHERE serre.id = '$id_serre'");
    header('Location: /add.php');
}

for($i=1; $i <= $nbPage; $i++){
    $serre_pages[] = $i;
}

if($_POST['new_serre']){
    $add_serre = $_POST['new_serre'];
    
    if(empty($_POST['new_serre'])){
        $erreur = "Veuillez remplir le champ vide";
        
    }else {
        $reponse = $conn->query("SELECT * FROM serre");
        $req = $conn->prepare('INSERT INTO serre(name) VALUES(:name)');
            $req->execute(array(
                'name' => $add_serre,
            ));
    }   
    header('Location: /add.php');
}

//****************************END table serre*************************************************
//******************************Table tache***************************************************
// pagination de la table tache
$reponse = $conn->query("SELECT Count(id) as nbArt FROM tache");
$req = $reponse->fetch();
$nbArt = $req['nbArt'];
$Perpage = 4;
$nbPage = ceil($nbArt/$Perpage);
$cPage = 1;

if(isset($_GET['tache']) && $_GET['tache']>0 && $_GET['serre']<=$nbPage){
    $cPage = $_GET['tache'];
}else {
    $cPage = 1;
}

// recuperation de la table tache
$reponse = $conn->query("SELECT * FROM tache LIMIT ".(($cPage - 1) * $Perpage).",$Perpage");
while($req = $reponse->fetch()){
    $taches[] = $req;
}

if(isset($_GET['id_tache'])){
    $id_tache = $_GET['id_tache'];
    $req = $conn->query("DELETE FROM tache WHERE tache.id = '$id_tache'");
    header('Location: /add.php');
}

for($i=1; $i <= $nbPage; $i++){
    $tache_pages[] = $i;
}

if($_POST['new_tache']){
    $add_tache = $_POST['new_tache'];
    
    if(empty($_POST['new_tache'])){
        $erreur = "Veuillez remplir le champ vide";
        
    }else {
        $reponse = $conn->query("SELECT * FROM tache");
        $req = $conn->prepare('INSERT INTO tache(name) VALUES(:name)');
            $req->execute(array(
                'name' => $add_tache,
            ));
    }   
    header('Location: /add.php');
}

//******************************END table tache***********************************************

// affichage du rendu d'un template
echo $twig->render('add.html.twig', [
    // transmission de données au template
    'zones' => $zones,
    'planches' => $planches,
    'legumes' => $legumes,
    'serres' => $serres,
    'taches' => $taches,
    'pages' => $pages,
    'serre_pages' => $serre_pages,
    'planche_pages' => $planche_pages,
    'legume_pages' => $legume_pages,
    'tache_pages' => $tache_pages,
    'erreur' => $erreur,
]);