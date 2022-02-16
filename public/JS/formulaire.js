
let validInputUsername = document.getElementById("registration_form_username");
validInputUsername.addEventListener('input',(e)=>{

    if(e.target.value.length>=3){
        validInputUsername.style.borderColor="#006400";
        validInputUsername.style.borderWidth="2px";

    }else{
        validInputUsername.style.borderColor="red";
    }
})
let validInputName = document.getElementById("registration_form_name");

validInputName.addEventListener('input',(e)=>{
    if(e.target.value.length>=3){
        validInputName.style.borderColor="#006400";
        validInputUsename.style.borderWidth="2px";

    }else{
        validInputName.style.borderColor="red";
    }
})
let validInputSurname = document.getElementById("registration_form_surname");

validInputSurname.addEventListener('input',(e)=>{
    if(e.target.value.length>=3){
        validInputSurname.style.borderColor="#006400";
        validInputUsename.style.borderWidth="2px";
    }else{
        validInputSurname.style.borderColor="red";
    }
})



let img = document.getElementById('img');

let angle=0;
setInterval(function(){
    img.style.transform="rotateZ("+ angle++ +"deg)";
}, 60);


window.addEventListener('click',(e)=>{
    console.log(e);
})
//document.getElementById('registration_form_pictureFile_file')
//C:\fakepath\
   // document.getElementById('registration_form_pictureFile_file').value= "Choisir image";

