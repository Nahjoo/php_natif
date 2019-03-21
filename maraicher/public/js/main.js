var select_planche = document.querySelector(".planche");
var required_planche = document.querySelector(".required_planche");
var required_serre = document.querySelector(".required_serre");
var select_zone = document.querySelector(".zone");
var select_serre = document.querySelector(".serre");

select_zone.addEventListener("change", zone);

function zone(){

    if(select_zone.value == 1) 
    {
      select_planche.style.display = "inline";
      required_planche.required = "required";
    } 
    else
    {
        select_planche.style.display = "none";
        required_planche.required = false;
    }

    if(select_zone.value == 2){
        select_serre.style.display = "inline";
        required_serre.required = "required";
    }else {
        select_serre.style.display = "none";
        required_serre.required = false;
    }

}

