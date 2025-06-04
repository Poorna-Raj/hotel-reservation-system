document.addEventListener("DOMContentLoaded",function(){
    const registerForm = document.getElementById('registrationForm');
    const errorMessage = document.getElementById('errorMessage')

    registerForm.addEventListener("submit", async function(event){
        event.preventDefault();
        email = registerForm.email.value.trim();
        number = registerForm.tele.value.trim();
        const apiPath = "../../../backend/api/auth/api_register.php";
        if(!validateEmail(email)){
            errorMessage.textContent = "Please enter a valid email address.";
            errorMessage.style.display = "block";
            return;
        }
        if(!validatePhoneNumber(number)){
            errorMessage.textContent = "Please enter a valid phone number.";
            errorMessage.style.display = "block";
            return;
        }
        const registerData = {
            email : registerForm.email.value.trim(),
            password : registerForm.conpass.value.trim(),
            full_name : registerForm.fullname.value.trim(),
            nic : registerForm.nic.value.trim(),
            tel_number : registerForm.tele.value.trim(),
            address : registerForm.address.value.trim()
        };

        try{
            const request = await fetch(apiPath,{
                method : "POST",
                headers : {
                    "Content-type":"application/json"
                },
                body : JSON.stringify(registerData)
            });

            const response = await request.json();
            if(response.success){
                window.location.href="../LOGIN/login.php";
            }
            else{
                errorMessage.textContent = response.message;
                errorMessage.style.display = "block";
            }
        }
        catch(error){
            errorMessage.textContent = error.message;
            errorMessage.style.display = "block";
            console.log(error);
        }
    });

    function validateEmail(email){
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }
    function validatePhoneNumber(phone) {
        const phonePattern = /^\+?\d{7,15}$/;
        return phonePattern.test(phone.replace(/[\s-]/g, ""));
    }

});