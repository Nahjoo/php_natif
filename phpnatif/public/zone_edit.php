<?php
// ****************************************Table ZONE******************************************
$new_zone = "";

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
while ($req = $reponse->fetch()){
    $zones[] = $req;
    $zones_id[] = $req['id'];
    $zones_name[] = $req['name'];
    
}

if(isset($_GET['id_zone'])){
    $id_zone = $_GET['id_zone'];
    $req = $conn->query("DELETE FROM zone WHERE zone.id = '$id_zone'");
    header('Location: /add.php');
}

for($i=1; $i <= $nbPage; $i++){
    $pages[] = $i;
}

if($_POST){
    if($_POST['new_zone']){
        $add_zone = ucfirst($_POST['new_zone']);
        // $add_serre = $_POST['new_serre'];
        if(empty($_POST['new_zone'])){
            $erreur = "Veuillez remplir le champ vide";
            
        }else {
            $reponse = $conn->query("SELECT * FROM zone");
            $req = $conn->prepare('INSERT INTO zone(name) VALUES(:name)');
                $req->execute(array(
                    'name' => $_POST['new_zone'],
                ));
        }
        header('Location: /add.php');
    }

}
// ****************************END table ZONE***********************************************
