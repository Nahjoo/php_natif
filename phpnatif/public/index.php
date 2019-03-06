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

$reponse = $conn->query("SELECT * FROM zone");
while($req = $reponse->fetch()){
    $zones[] = $req['name'];
}

if($_POST){
    $zone_select = $_POST["zone_lol"];
    echo 'ok';
}

// if($zone_select == "Jardin"){
//     $reponse = $conn->query("SELECT * FROM planche");
//     while($req = $reponse->fetch()){
//         $planches[] = $req['name'];
//     }
// }




    
// affichage du rendu d'un template
echo $twig->render('index.html.twig', [
// transmission de données au template
    'zone_select' => $zone_select,
    'zones' => $zones,
    // 'planches' => $planches
]);
