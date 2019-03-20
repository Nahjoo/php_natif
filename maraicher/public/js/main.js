var select_planche = document.querySelector(".planche");
var select_zone = document.querySelector(".zone");

select_zone.addEventListener("change", zone);

function zone(){

    if(select_zone.value == "Jardin") 
    {
      select_planche.style.display = "inline";
      select_planche.required = "required";
    } 
    else
    {
        select_planche.style.display = "none";
        select_planche.required = false;
    }

}

