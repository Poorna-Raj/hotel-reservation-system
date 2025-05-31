  
        document.addEventListener('DOMContentLoaded', () => {
            const passwordToggle = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');
           

            
            // check Password visibility toggle
            passwordToggle.addEventListener('click', () => {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                passwordToggle.innerHTML = type === 'password' 
                    ? '<i class="fas fa-eye"></i>' 
                    : '<i class="fas fa-eye-slash"></i>';
            });


            
        });
