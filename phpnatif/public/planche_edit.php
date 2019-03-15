<?php

//*****************************Table planche************************************************
// pagination de la table serre
$reponse = $conn->query("SELECT Count(id) as nbArt FROM planche");
$req = $reponse->fetch();
$nbArt = $req['nbArt'];
$Perpage = 4;
$nbPage = ceil($nbArt/$Perpage);
$cPage = 1;

if(isset($_GET['planche']) && $_GET['planche']>0 && $_GET['planche']<=$nbPage){
    $cPage = $_GET['planche'];
}else {
    $cPage = 1;
}

// recuperation de la table planche
$reponse = $conn->query("SELECT * FROM planche LIMIT ".(($cPage - 1) * $Perpage).",$Perpage");
while($req = $reponse->fetch()){
    $planches[] = $req;
}

if(isset($_GET['id_planche'])){
    $id_planche = $_GET['id_planche'];
    $req = $conn->query("DELETE FROM planche WHERE planche.id = '$id_planche'");
    header('Location: /add.php');
}

for($i=1; $i <= $nbPage; $i++){
    $planche_pages[] = $i;
}

if($_POST['new_planche']){
    $add_planche = $_POST['new_planche'];
    
    if(empty($_POST['new_planche'])){
        $erreur = "Veuillez remplir le champ vide";
        
    }else {
        $reponse = $conn->query("SELECT * FROM planche");
        $req = $conn->prepare('INSERT INTO planche(name) VALUES(:name)');
            $req->execute(array(
                'name' => $add_planche,
            ));
    }   
    header('Location: /add.php');
}

//****************************END table planche*********************************************