const apiRoot = "../../../backend/api/room/customer/roomView.php";
let roomPrice = null;
window.addEventListener("DOMContentLoaded",function(){
    const updateForm = document.getElementById("bookingModal");
    const updateModel = document.getElementById("updatePopup");
    const bookingForm = this.document.getElementById("bookingForm");
    const checkinInput = bookingForm.checkin;
    const checkoutInput = bookingForm.checkout;
    const updateRoomForm = this.document.getElementById("updateRoomForm");
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

    updateForm.addEventListener("submit", async function(event) {
        event.preventDefault();

        const apiRoot = "../../../backend/api/reservation/addReservation.php";
        const errorDisplay = document.getElementById("errorMessage");

        // Reset error message display
        errorDisplay.style.display = "none";
        errorDisplay.textContent = "";

        const updateData = {
            roomID: roomId,
            inDate: bookingForm.checkin.value,
            outDate: bookingForm.checkout.value,
            num_of_guest: bookingForm.guest.value,
            total: roomTotal(roomPrice, bookingForm.checkin.value, bookingForm.checkout.value)
        };

        try {
            const respond = await fetch(apiRoot, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(updateData),
                credentials: "include"
            });

            const result = await respond.json();

            if (!result.success) {
                errorDisplay.textContent = result.message || "An error occurred.";
                errorDisplay.style.display = "block";
            } else {
                console.log("Reservation successful.");
                location.reload();
            }
        } catch (error) {
            errorDisplay.textContent = "Failed to submit. Please try again later.";
            errorDisplay.style.display = "block";
            console.error("Fetch error:", error);
        }
    });

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
            window.location.href="../ROOM CARD/admin/AdminCrudRoom.php";
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
        const roomContainer = document.querySelector('.room-container');

        updateRoomForm.roomName.value = roomContainer.querySelector('.room-name').textContent;
        updateRoomForm.roomType.value = document.querySelector(".room-type")?.textContent || "";
        updateRoomForm.price.value = roomPrice;
        updateRoomForm.bedType.value = roomContainer.querySelector('.bed-type-detail').textContent;
        updateRoomForm.max_occupancy.value = roomContainer.querySelector('.detail-value-occu').textContent;
        updateRoomForm.description.value = roomContainer.querySelector('.description').textContent;
        updateRoomForm.short_description.value = roomContainer.querySelector('.detailsShort').textContent;
        updateRoomForm.image_01.value = roomContainer.querySelector('.main-image img').src;
        updateRoomForm.image_02.value = roomContainer.querySelector('.side-image-1').src;
        updateRoomForm.image_03.value = roomContainer.querySelector('.side-image-2').src;
        
        const roomStatus = roomContainer.querySelector('.status-available').style.display === 'inline-block' ? "Available" : "Repair";
        updateRoomForm.status.value = roomStatus;

        updateModel.style.display = "flex";
    });
    const updatePopClose = document.getElementById("updatePopClose");
    updatePopClose.addEventListener("click",function(){
        updateModel.style.display = "none";
    })


    updateRoomForm.addEventListener("submit",async function(event){
        event.preventDefault();
        const apiRoot = "../../../backend/api/room/updateRoom.php";
        const updateData = {
            roomID : roomId,
            roomName : updateRoomForm.roomName.value, 
            type : updateRoomForm.roomType.value,
            price : updateRoomForm.price.value,
            bed_type : updateRoomForm.bedType.value,
            occupancy : updateRoomForm.max_occupancy.value,
            description : updateRoomForm.description.value,
            short_description : updateRoomForm.short_description.value,
            image1 : updateRoomForm.image_01.value,
            image2 : updateRoomForm.image_02.value,
            image3 : updateRoomForm.image_03.value,
            status : updateRoomForm.status.value
        }
        const respond = await fetch(apiRoot,{
            method : "POST",
            headers : {
                "Content-type":"application/json"
            },
            body: JSON.stringify(updateData)
        });
        const result = await respond.json();
        if(!result.success){
            alert("Operation Failed: "+result.message);
        }
        else{
            location.reload();
        }

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