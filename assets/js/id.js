document.getElementById("login").addEventListener("click", login);
document.getElementById("register").addEventListener("click", register);
window.addEventListener("resize", PageWide);

var loginRegisterContainer = document.querySelector(".loginRegister");
var form_login = document.querySelector(".login");
var form_register = document.querySelector(".singup");  
var backboxLogin = document.querySelector(".loginBackBox");
var backboxRegister = document.querySelector(".registerBackBox");

function PageWide(){
    if(window.innerWidth > 850){
        backboxLogin.style.display = "block";
        backboxRegister.style.display = "block";
    } else {
        backboxRegister.style.display = "block";
        backboxRegister.style.opacity = "1";
        backboxLogin.style.display = "none";
        form_login.style.display = "block";
        form_register.style.display = "none";
        loginRegisterContainer.style.left = "0px";
    }
}

PageWide();  // Initialize layout based on current window size

function login(){
    if(window.innerWidth > 850){ 
        form_register.style.display = "none";
        loginRegisterContainer.style.left = "10px";  // Assuming default left margin for larger screens
        form_login.style.display = "block";
        backboxRegister.style.opacity = "1";
        backboxLogin.style.opacity = "0";
    } else {
        form_register.style.display = "none";
        loginRegisterContainer.style.left = "0px";
        form_login.style.display = "block";
        backboxRegister.style.display = "block";
        backboxLogin.style.display = "none";
    }
}

function register(){
    if(window.innerWidth > 850){
        form_register.style.display = "block";
        loginRegisterContainer.style.left = "410px";  // Adjust as necessary for your layout
        form_login.style.display = "none";
        backboxRegister.style.opacity = "0";
        backboxLogin.style.opacity = "1";
    } else {
        form_register.style.display = "block";
        loginRegisterContainer.style.left = "0px";
        form_login.style.display = "none";
        backboxRegister.style.display = "none";
        backboxLogin.style.display = "block";
        backboxLogin.style.opacity = "1";
    }
}


