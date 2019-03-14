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


// pagination de la table zone
$reponse = $conn->query("SELECT Count(id) as nbArt FROM zone");
$req = $reponse->fetch();
$nbArt = $req['nbArt'];
$Perpage = 4;
$nbPage = ceil($nbArt/$Perpage);
$cPage = 1;

if(isset($_GET['zone']) && $_GET['zone']>0 && $_GET['zone']<=$nbPage){
    $cPage = $_GET['zone'];
}else {
    $cPage = 1;
}

// recuperation de la table zone
$reponse = $conn->query("SELECT * FROM zone LIMIT ".(($cPage - 1) * $Perpage).",$Perpage");
while($req = $reponse->fetch()){
    $zones[] = $req['name'];
    $zones_id[] = $req ['id'];
}

if(isset($_GET['id']) && $_GET['id']>0 && $_GET['id']<=$nbArt){
    $req = $conn->prepare('DELETE FROM zone WHERE `zone`.`id` ='.$_GET['id'] );
    $req->execute(array(
        'name' => $add_zone,
    ));
}



for($i=1; $i <= $nbPage; $i++){
    $pages[] = $i;
}

// recuperation de la table planche
$reponse = $conn->query("SELECT * FROM planche");
while($req = $reponse->fetch()){
    $planches[] = $req['name'];
}

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
    $serres[] = $req['name'];
}
for($i=1; $i <= $nbPage; $i++){
    $serre_pages[] = $i;
}

// recuperation de la table legume
$reponse = $conn->query("SELECT * FROM legume");
while($req = $reponse->fetch()){
    $legumes[] = $req['name'];
}

// recuperation de la table tache
$reponse = $conn->query("SELECT * FROM tache");
while($req = $reponse->fetch()){
    $taches[] = $req['name'];
}


if($_POST){
    $add_zone = $_POST['new_zone'];
    $add_legume = $_POST['new_legume'];
    $add_variete = $_POST['new_variete'];
    $add_serre = $_POST['new_serre'];


    if(empty($_POST['new_zone'])){
        $erreur = "Veuillez remplir le champ vide";
        
    }else {
        $reponse = $conn->query("SELECT * FROM zone");
        $req = $conn->prepare('INSERT INTO zone(name) VALUES(:name)');
            $req->execute(array(
                'name' => $add_zone,
            ));
    }
    header('Location: /add.php');
}



// affichage du rendu d'un template
echo $twig->render('add.html.twig', [
    // transmission de données au template
    'zones' => $zones,
    'zones_id' => $zones_id,
    'legumes' => $legumes,
    'serres' => $serres,
    'pages' => $pages,
    'serre_pages' => $serre_pages
]);