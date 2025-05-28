
document.addEventListener('DOMContentLoaded', () => {
    const passwordToggle = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const randomImage = document.getElementById('randomImage');

    // Random nature image URLs (replace with your preferred images)
    const natureImages = [
        'https://images.unsplash.com/photo-1552733407-5d5c0c91cec5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1546587348-3f8ed90f4079?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1474&q=80',
        'https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1501854140801-50f01a510d42?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1475&q=80',
        'https://images.unsplash.com/photo-1470770841072-f978f8adfb7f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
    ];

    // Set random image on page load
    function setRandomImage() {
        const randomIndex = Math.floor(Math.random() * natureImages.length);
        randomImage.src = natureImages[randomIndex];
        randomImage.alt = 'Random Nature Landscape';
    }

    // Password visibility toggle
    passwordToggle.addEventListener('click', () => {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        passwordToggle.innerHTML = type === 'password' 
            ? '<i class="fas fa-eye"></i>' 
            : '<i class="fas fa-eye-slash"></i>';
    });

    // Initialize random image
    setRandomImage();
    document.getElementById("loginForm").addEventListener('submit',async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = {
            username : form.username.value.trim(),
            password : form.password.value
        };

        try{
            const response = await fetch("http://localhost/CW/hotel-reservation-system/backend/api/auth/api_login.php",{
                method : "POST",
                headers: {
                    'Content-type':'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            console.log(result);
            
            document.getElementById("message").textContent = result.message;
            document.getElementById("errorMessage").style.display = "block";
            if(result.success){
                if(result.role === "customer"){
                    window.location.href="../../index.html";
                }
                else if (result.role === "admin"){
                    console.log("Hi i am an admin");
                }
            }
            
        }
        catch (error) {
                
            document.getElementById("message").textContent = "Login Failed. Try Again";
        }
    });
});


