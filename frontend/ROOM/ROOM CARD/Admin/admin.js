document.addEventListener("DOMContentLoaded",function(){
    const apiRoot = "../../../../backend/api/room/listView.php";
    const filterForm = document.getElementById("filterForm");
    const addFormInit = document.getElementById("addRoomInterface");
    const addForm = document.getElementById("popup");
    const addFormClose = document.getElementById("addRoomClose");
    const saveRoomForm = document.getElementById("addRoomForm");

    
    (async function(){
        const rooms = await loadRooms();
        renderRooms(rooms);
    })();

    filterForm.addEventListener("submit",async function(event){
        event.preventDefault();
        const name = filterForm.searchName.value.trim();
        const status = filterForm.status.value;
        const order = filterForm.order.value;

        const params = new URLSearchParams();
        if(name) params.append("name",name);
        if(status) params.append("status",status);
        if(order) params.append("orderBy",order);

        try{
            const response = await fetch(apiRoot + "?" + params.toString());
            const result = await response.json();

            if(!result.success){
                console.error("Failed to fetch filtered results: ",result.message);
                return;
            }
            clearRoomCards();
            renderRooms(result.data);
        }
        catch(error){
            console.error("Failed to fetch results: ",error.message);
        }
    });

    addFormInit.addEventListener("click",function(){
        addForm.style.display = "flex";
    });
    addFormClose.addEventListener("click",function(){
        addForm.style.display = "none";
    });

    saveRoomForm.addEventListener("submit",async function(event){
        event.preventDefault();
        const roomData = {
            name : saveRoomForm.roomName.value.trim(),
            type : saveRoomForm.roomType.value,
            price : saveRoomForm.price.value,
            bed_type: saveRoomForm.bedType.value,
            occupancy: saveRoomForm.max_occupancy.value,
            description: saveRoomForm.description.value.trim(),
            short_description: saveRoomForm.short_description.value.trim(),
            image1: saveRoomForm.image_01.value.trim(),
            image2: saveRoomForm.image_02.value.trim(),
            image3: saveRoomForm.image_03.value.trim()
        };
        try{
            const respond = await fetch("../../../../backend/api/room/addRoom.php",{
                method: "POST",
                headers: {
                    "Content-type" : "application/json"
                },
                body : JSON.stringify(roomData)
            });
            const result = await respond.json();
            if(result.success){
                window.location.href="AdminCrudRoom.html";
            }
        }
        catch(err){
            console.error(err.message);
        }
    });
});

function clearRoomCards() {
    const container = document.querySelector('.room-grid');
    const cards = container.querySelectorAll('.room-card');

    cards.forEach(function (card) {
        if (!card.classList.contains('add-room-card') && card.id !== 'room-template') {
            card.remove();
        }
    });
}

function renderRooms(rooms){
    var container = document.querySelector('.room-grid');
    var template = document.getElementById('room-template');

    rooms.forEach(function (room) {
        var card = template.cloneNode(true);
        card.style.display = 'block';
        card.removeAttribute('id');
        card.classList.add('room-card');

        card.querySelector('img').src = room.image_01;
        card.querySelector('h3').textContent = room.room_name;
        card.querySelector('.price').textContent = 'Rs. ' + room.price;
        card.querySelector('.description').textContent = room.description;
        card.querySelector('.view-details').href = 'room.php?id=' + room.id;

        var roomType = card.querySelector('.room-type');
        if (roomType) {
            roomType.textContent = room.type || '';
        }

        var bedType = card.querySelector('.bed-type');
        if (bedType) {
            bedType.textContent = room.bed || '';
        }

        var statusTag = card.querySelector('#status');
        if (statusTag) {
            statusTag.textContent = room.status;
            statusTag.className = 'status-tag status-' + room.status.toLowerCase();
        }

        container.appendChild(card);
    });
}

async function loadRooms(){
    const response = await fetch("../../../../backend/api/room/listView.php");
    const result = await response.json();

    if(!result.success){
        console.error("Failed to fetch results: ",result.message);
        return;
    }
    return result.data;
}
