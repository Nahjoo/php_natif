var div = document.querySelector(".planche");
var select1 = document.querySelector("#rotation_zone");

select1.addEventListener("change", beat);

function beat(){

    var select = document.createElement("select");
    select.className = "oui";
    var option = document.createElement("option");

    if(select1.value == 1) 
    {
        select.appendChild(option);
        option.display = "none";
        option.innerHTML = "option 1";
        div.appendChild(select)
    } 
    else if(select1.value == 2)
    {
        select.appendChild(option);
        select.display = none;
        option.innerHTML = "Serre";
        div.appendChild(select)
    }

}

