const apiRoot = "../../../backend/api/room/customer/roomView.php";
let roomPrice = null;
window.addEventListener("DOMContentLoaded",function(){
    const updateForm = document.getElementById("bookingModal");
    const updateModel = document.getElementById("updatePopup");
    const bookingForm = this.document.getElementById("bookingForm");
    const checkinInput = bookingForm.checkin;
    const checkoutInput = bookingForm.checkout;
    const totalPriceDisplay = document.getElementById("total");
    const deleteBtn = this.document.getElementById("deleteBtn");
    const updateBtn = document.getElementById("updateBtn");
    const params = new URLSearchParams(this.window.location.search);
    const roomId = params.get('id');
    if (!roomId) {
        console.error("No room ID provided in URL.");
    }
    (async function() {
        renderRoom(roomId);
    })();
    (async function(){
        checkUser();
    })();
    const bookBtn = this.document.getElementById("bookNowBtn");

    bookBtn.addEventListener("click",function(){
        updateForm.style.display = "flex";
    });

    const updateClose = this.document.getElementById("closeModal");
    updateClose.addEventListener("click",function(){
        const updateForm = document.getElementById("bookingModal");
        updateForm.style.display = "none";
    })

    updateForm.addEventListener("submit",async function(event){
        const apiRoot = "../../../backend/api/reservation/addReservation.php";
        event.preventDefault();
        const updateData = {   
            roomID : roomId,
            inDate : bookingForm.checkin.value,
            outDate : bookingForm.checkout.value,
            num_of_guest : bookingForm.guest.value,
            total : roomTotal(roomPrice,bookingForm.checkin.value,bookingForm.checkout.value)
        }

        const respond = await fetch(apiRoot,{
            method : "POST",
            headers : {
                "Content-type":"application/json"
            },
            body : JSON.stringify(updateData),
            credentials: "include"
        });
        const result = await respond.json();
        if(!result.success){
            const errorDisplay = document.getElementById("errorMessage");
            errorDisplay.textContent = result.message;
        }
        else{
            console.log("Done");
        }
    })
    function updatePriceDisplay() {
        const inDate = checkinInput.value;
        const outDate = checkoutInput.value;
        const total = roomTotal(roomPrice, inDate, outDate);
        totalPriceDisplay.value = total;
        console.log(total);
    }
    checkinInput.addEventListener("change", updatePriceDisplay);
    checkoutInput.addEventListener("change", updatePriceDisplay);

    deleteBtn.addEventListener("click",function(){
        const deleteConfirm = document.getElementById("deletePopup");
        deleteConfirm.style.display = "flex";
    });
    const makeDelete = this.document.getElementById("makeDelete");
    const closeDelete = this.document.getElementById("closeDelete");

    makeDelete.addEventListener("click",async function(){
        const apiRoot = "../../../backend/api/room/deleteRoom.php";
        const params = new URLSearchParams();
        if(roomId) params.append("roomID",roomId);
        const response = await fetch(apiRoot + "?" + params,{
            method: "GET",
            credentials: "include"
        });
        const result = await response.json();
        console.log(roomId);

        if(result.success){
            alert("Deletion Successfull");
            window.location.href="../ROOM CARD/AdminCrudRoom.html";
        }
        else{
            alert("Operation Failed: "+result.message);
        }
    });
    closeDelete.addEventListener("click",function(){
        const deleteConfirm = document.getElementById("deletePopup");
        deleteConfirm.style.display = "none";
    });

    updateBtn.addEventListener("click",function(){
        updateModel.style.display = "flex";
    });
});

async function renderRoom(id) {
    try{
        const params = new URLSearchParams();
        if(id) params.append("id",id);
        const response = await fetch(apiRoot + "?" + params);
        const result = await response.json();

        if(!result.success){
            console.error("Failed to fetch room details: ",result.message);
            return;
        }
        const room = result.data;

        const roomContainer = document.querySelector('.room-container');

        const roomName = roomContainer.querySelector('.room-name');
        roomName.textContent = room.room_name;
        const mainImage = roomContainer.querySelector('.main-image img');
        mainImage.src = room.image_01;
        const sideImage1 = roomContainer.querySelector('.side-image-1');
        sideImage1.src = room.image_02;
        const sideImage2 = roomContainer.querySelector('.side-image-2');
        sideImage2.src = room.image_03;
        const bedType = roomContainer.querySelector('.bed-type-detail');
        bedType.textContent = room.bed_type;
        const maxOc = roomContainer.querySelector('.detail-value-occu');
        maxOc.textContent = room.max_occupancy;
        const description = roomContainer.querySelector('.description');
        description.textContent = room.description;

        const available = roomContainer.querySelector('.status-available');
        const unavailable = roomContainer.querySelector('.status-unavailable');

        available.style.display = "none";
        unavailable.style.display = "none";

        if (room.status !== "Repair") {
            available.style.display = "inline-block";
        } else {
            unavailable.style.display = "inline-block";
        }

        const price = roomContainer.querySelector('.price-value');
        price.textContent = "Rs." + room.price;
        roomPrice = room.price;
        const overview = roomContainer.querySelector('.detailsShort');
        overview.textContent = room.short_description;

    }
    catch(err){
        console.error("Failed to display room details: ",err.message);
    }

}

function roomTotal(price,inDate,outDate){
    const inD = new Date(inDate);
    const outD = new Date(outDate);

    // Calculate difference in milliseconds
    const timeDiff = outD - inD;

    // Convert milliseconds to days
    const days = timeDiff / (1000 * 60 * 60 * 24);

    if (days <= 0 || isNaN(days)) {
        return 0; // Invalid date range
    }

    return price * days;
}

async function checkUser() {
    const respond = await fetch("../../../backend/api/auth/getRole.php");
    const result = await respond.json();

    if(result.success && result.role === "customer"){
        const adminFunc = document.getElementById("adminFunc");
        adminFunc.style.display = "none";
    }
}