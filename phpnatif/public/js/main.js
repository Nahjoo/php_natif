var select_zone = document.querySelector(".zone");
select_zone.addEventListener("change", zone);
var select_planche = document.querySelector(".planche");
var select_planche_serre = document.querySelector(".planche_serre");
var select_serre = document.querySelector(".serre");
var select_tache = document.querySelector(".tache");
select_tache.addEventListener("change" , tache);
var preparation = document.querySelector(".preparation");
var recolte = document.querySelector(".recolte");
var couvert = document.querySelector(".couvert");


function zone(event){
    event.preventDefault();
    if(select_zone.value == "Jardin"){
        select_planche.style.display = "inline";
        
    }else {
        select_planche.style.display = "none" ;
        select_planche.value = "Selectionnez une planche";
    }

    if (select_zone.value == "Serre"){
        select_serre.style.display = "inline";
        select_planche_serre.style.display = 'inline';
    }else {
        select_serre.style.display = "none" ;
        select_planche_serre.style.display = 'none';
        select_serre.value = "Selectionnez une serre";
        select_planche_serre.value = "Selectionnez une planche";
    }
}

function tache() {

    if(select_tache.value == "Preparation sol"){
        preparation.style.display = "block";

    }else {
        preparation.style.display = "none";
    }
    
    if (select_tache.value == "Récolte"){
        recolte.style.display = "block";

    }else {
        recolte.style.display = "none";
    }
    
    if(select_tache.value == "Couvert"){
        couvert.style.display = "block";
    }else {
        couvert.style.display = "none";
    }
}
