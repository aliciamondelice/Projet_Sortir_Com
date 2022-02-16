


let validInputProfitEditUsername = document.getElementById("profil_edit_username");
validInputProfitEditUsername.addEventListener('input',(e)=>{

    if(e.target.value.length>=3){
        validInputProfitEditUsername.style.borderColor="#006400";
        validInputProfitEditUsername.style.borderWidth="2px";

    }else{
        validInputProfitEditUsername.style.borderColor="red";
        validInputProfitEditUsername.style.borderWidth="2px";
    }
})
let validInputProfilEditName = document.getElementById("profil_edit_name");

validInputProfilEditName.addEventListener('input',(e)=>{
    if(e.target.value.length>=3){
        validInputProfilEditName.style.borderColor="#006400";
        validInputProfilEditName.style.borderWidth="2px";

    }else{
        validInputProfilEditName.style.borderColor="red";
        validInputProfilEditName.style.borderWidth="2px";
    }
})
let validInputProfilEditSurname = document.getElementById("profil_edit_surname");

validInputProfilEditSurname.addEventListener('input',(e)=>{
    if(e.target.value.length>=3){
        validInputProfilEditSurname.style.borderColor="#006400";
        validInputProfilEditSurname.style.borderWidth="2px";
    }else{
        validInputProfilEditSurname.style.borderColor="red";
        validInputProfilEditSurname.style.borderWidth="2px";
    }
})