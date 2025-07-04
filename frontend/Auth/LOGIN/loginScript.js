
document.addEventListener('DOMContentLoaded',function(){
    const passwordToggle = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const loginForm = document.getElementById('loginForm');
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    const errorMessage = document.getElementById('errorMessage');

    
    // check Password visibility toggle
    passwordToggle.addEventListener('click',function(){
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        passwordToggle.innerHTML = type === 'password' 
            ? '<i class="fas fa-eye"></i>' 
            : '<i class="fas fa-eye-slash"></i>';
    });

    loginForm.addEventListener("submit",async function(event){
        event.preventDefault();
        const logUsername = document.getElementById('username').value.trim();
        const logPassword = document.getElementById('password').value.trim();
        const apiPath = "../../../backend/api/auth/api_login.php";

        // Clear previous error message
        errorMessage.textContent = "";
        errorMessage.style.display = "none";

        if(!validateEmail(logUsername)){
            errorMessage.textContent = "Please enter a valid email address.";
            errorMessage.style.display = "block";
            return;
        }
        if(!logPassword){
            errorMessage.textContent = "Please enter a password.";
            errorMessage.style.display = "block";
            return;
        }

        const loginData = {
            username : logUsername,
            password : logPassword
        };

        try{
            const response = await fetch(apiPath,{
                method : "POST",
                headers : {
                    "Content-type":"application/json"
                },
                body : JSON.stringify(loginData),
            });

            if(!response.ok){
                throw new Error("Login failed. Please check your credentials.");
            }

            const data = await response.json();

            if(data.success){
                if(data.role === "admin"){
                    window.location.href="../../ROOM/ROOM CARD/Admin/AdminCrudRoom.php";
                }
                else if (data.role === "customer"){
                    window.location.href="../../ROOM/ROOM CARD/Roomcard.php";
                }
                
            }
            else{
                errorMessage.textContent = data.message || "Invalid username or password";
                errorMessage.style.display = "block";
            }
        }
        catch(error){
            errorMessage.textContent = error.message;
            errorMessage.style.display = "block";
        }
    });

    function validateEmail(email){
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }
    
});
// navigate to the registration page
function toggleNav() {
    document.getElementById("myTopnav").classList.toggle("responsive");
  }
