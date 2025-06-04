document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById('registrationForm');
    const errorMessage = document.getElementById('errorMessage');

    registerForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        // Clear previous error message
        errorMessage.textContent = "";
        errorMessage.style.display = "none";

        // Collect and trim form data
        const email = registerForm.email.value.trim();
        const number = registerForm.tele.value.trim();
        const password = registerForm.pass1.value.trim(); 
        const confirmPassword = registerForm.conpass.value.trim(); 
        const fullName = registerForm.fullname.value.trim();
        const nic = registerForm.nic.value.trim();
        const address = registerForm.address.value.trim();

        const apiPath = "../../../backend/api/auth/api_register.php";

        // Begin validation
        if (!validateEmail(email)) {
            return showError("Please enter a valid email address.");
        }

        if (!validatePhoneNumber(number)) {
            return showError("Please enter a valid phone number.");
        }

        if (password.length < 6) {
            return showError("Password must be at least 6 characters long.");
        }

        if (password !== confirmPassword) {
            return showError("Passwords do not match.");
        }

        if (fullName === "") {
            return showError("Full name is required.");
        }

        if (nic === "") {
            return showError("NIC is required.");
        }

        if (address === "") {
            return showError("Address is required.");
        }

        // All good, send to backend
        const registerData = {
            email: email,
            password: password,
            full_name: fullName,
            nic: nic,
            tel_number: number,
            address: address
        };

        try {
            const request = await fetch(apiPath, {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify(registerData)
            });

            const response = await request.json();

            if (response.success) {
                window.location.href = "../LOGIN/login.php";
            } else {
                showError(response.message || "Registration failed.");
            }
        } catch (error) {
            showError("Something went wrong: " + error.message);
            console.error(error);
        }
    });

    function showError(msg) {
        errorMessage.textContent = msg;
        errorMessage.style.display = "block";
    }

    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function validatePhoneNumber(phone) {
        const phonePattern = /^\+?\d{7,15}$/;
        return phonePattern.test(phone.replace(/[\s-]/g, ""));
    }
});
// navigate to the registration page
function toggleNav() {
    document.getElementById("myTopnav").classList.toggle("responsive");
  }
