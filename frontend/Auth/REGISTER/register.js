document.addEventListener("DOMContentLoaded",function(){
    const registerForm = document.getElementById('registrationForm');
    const errorMessage = document.getElementById('errorMessage')

    registerForm.addEventListener("submit", async function(){
        email = registerForm.email.value.trim();
        if(!validateEmail(email)){
            errorMessage.textContent = "Please enter a valid email address.";
            errorMessage.style.display = "block";
            return;
        }
        const registerData = {
            email : 
        };

        const request = await fetch("")
    });

    function validateEmail(email){
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }
});