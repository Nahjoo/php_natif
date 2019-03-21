<?php

//****************************Table legume****************************************************
$new_legume = "";
// recuperation de la table legume avec nombre d'id
$reponse = $conn->query("SELECT Count(id) as nbArt FROM legume");
$req = $reponse->fetch();
$nbArt = $req['nbArt'];
$Perpage = 4;
$nbPage = ceil($nbArt/$Perpage);
$cPage = 1;

// create pagination
if(isset($_GET['legume']) && $_GET['legume']>0 && $_GET['legume']<=$nbPage){
    $cPage = $_GET['legume'];
}else {
    $cPage = 1;
}

// recuperation de la table legume
$reponse = $conn->query("SELECT * FROM legume ORDER BY name LIMIT ".(($cPage - 1) * $Perpage).",$Perpage");
while ($req = $reponse->fetch()){
    $legumes[] = $req;
    $legumes_id[] = $req['id'];
    $legumes_name[] = $req['name'];
}

// recover id in URL end delete the line with the id in url
if(isset($_GET['id_legume'])){
    $id_legume = $_GET['id_legume'];
    $req = $conn->query("DELETE FROM legume WHERE legume.id = '$id_legume'");
    header('Location: /add.php');
}


// pagination
for($i=1; $i <= $nbPage; $i++){
    $legume_pages[] = $i;
}


// check if the formulaire as send
if($_POST){
    // recover the value of dropdown legume
    if($_POST['new_legume']){
        $add_legume = ucfirst($_POST['new_legume']);
        $add_variete = ucfirst($_POST['new_variete']);
        if(empty($_POST['new_legume'])){
            $erreur = "Veuillez remplir le champ vide";
            
        }else {
            $reponse = $conn->query("SELECT * FROM legume");
            $req = $conn->prepare('INSERT INTO legume(name,variete) VALUES(:name,:variete)');
                $req->execute(array(
                    'name' => $add_legume,
                    'variete' => $add_variete,
                ));
        }   
        header('Location: /add.php');
    }
}


//****************************END table legume************************************************
