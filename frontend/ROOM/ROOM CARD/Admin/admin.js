document.addEventListener("DOMContentLoaded",function(){
    const apiRoot = "../../../../backend/api/room/listView.php";
    const filterForm = document.getElementById("filterForm");
    
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

        card.querySelector('img').src = 'images/' + room.image;
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
