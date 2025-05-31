document.addEventListener("DOMContentLoaded", function(){
    const btnBook = document.querySelector(".btn.btn-primary");
    const btnLog = document.querySelector(".btn.btn-outline");
    const emailForm = document.getElementById("sendEmail");

    btnBook.addEventListener("click",function(){
        window.location.href="";
        // TODO : Specify the link
    });

    btnLog.addEventListener("click",function(){
        window.location.href="frontend/Auth/LOGIN/login.html";
    });

    emailForm.addEventListener("submit",async function(event){
        event.defaultPrevented();
        const responseText = document.getElementById("contactResponse");
        const contactData = {
            name: emailForm.name.value.trim(),
            email: emailForm.email.value.trim(),
            message: emailForm.message.value.trim()
        };

        try {
            const res = await fetch("backend/api/auth/email.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(contactData)
            });

            const result = await res.json();
            if (result.success) {
                responseText.style.color = "green";
                responseText.textContent = "Message sent successfully!";
            } 
            else {
                responseText.style.color = "red";
                responseText.textContent = result.message;
            }
            responseText.style.display = "block";
        } 
        catch (error) {
            responseText.textContent = "Error sending message.";
            responseText.style.display = "block";
        }
    });
});