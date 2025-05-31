document.addEventListener("DOMContentLoaded", function(){
    const btnBook = document.querySelector(".btn.btn-primary");
    const btnLog = document.querySelector(".btn.btn-outline");

    btnBook.addEventListener("click",function(){
        window.location.href="";
        // TODO : Specify the link
    });

    btnLog.addEventListener("click",function(){
        window.location.href="frontend/Auth/LOGIN/login.html";
    });
});