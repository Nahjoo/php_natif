var select_zone = document.querySelector(".zone");
select_zone.addEventListener("change", zone);
var select_planche = document.querySelector(".planche");
var select_serre = document.querySelector(".serre");
var select_tache = document.querySelector(".tache");
select_tache.addEventListener("change" , tache);
var check = document.querySelector(".form-check");

function zone(event){
    event.preventDefault();
    if(select_zone.value == "Jardin"){
        console.log("okook");
        select_planche.style.display = "inline";
    }else {
        select_planche.style.display = "none" ;
        select_planche.value = null;
    }

    if (select_zone.value == "Serre"){
        select_serre.style.display = "inline";
    }else {
        select_serre.style.display = "none" ;
        select_serre.value = null;
    }
    
}


function tache() {

    if(select_tache.value == "Preparation"){
        check.style.display = "block";
    }else {
        check.style.display = "none";
    }
}
