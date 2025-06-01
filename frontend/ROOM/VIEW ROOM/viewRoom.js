const apiRoot = "../../../backend/api/room/customer/roomView.php";
window.addEventListener("DOMContentLoaded",function(){
    const params = new URLSearchParams(this.window.location.search);
    const roomId = params.get('id');
    if (!roomId) {
        console.error("No room ID provided in URL.");
    }
    (async function() {
        renderRoom(roomId);
    })();

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
        const overview = roomContainer.querySelector('.detailsShort');
        overview.textContent = room.short_description;

    }
    catch(err){
        console.error("Failed to display room details: ",err.message);
    }

}