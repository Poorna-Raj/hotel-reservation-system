const apiRoot = "../../../backend/api/room/customer/listView.php";
window.addEventListener("DOMContentLoaded",function(){
    const logoutBtn = document.querySelector(".logout-btn");
    const filterForm = this.document.getElementById('filterForm');
    (async function(){
        const rooms = await loadRooms();
        renderRooms(rooms);
    })();

    filterForm.addEventListener("submit", async function(event){
        event.preventDefault();
        const roomType = filterForm.roomType.value;
        const bedType = filterForm.status.value;
        const people = filterForm.maxOccupancy.value;
        const order = filterForm.order.value;

        const params = new URLSearchParams();
        if(roomType) params.append('type',roomType);
        if(bedType) params.append('bed_type',bedType);
        if(people) params.append('max_occupancy',people);
        if(order) params.append('orderBy',order);

        try{
            const response = await fetch(apiRoot + "?" + params.toString());
            const result = await response.json();

            if(!result.success){
                console.error("Failed to fetch filtered rooms ",result.success);
                return;
            }
            clearRoomCards();
            renderRooms(result.data);
        }
        catch(error){
            console.error("Failed to fetch data ",error.message);
        }
    });

    logoutBtn.addEventListener("click",async function() {
    const apiRoot = "../../../backend/api/auth/logout.php";
    const respond = await fetch(apiRoot);
    const result = await respond.json();

    if(result.success){
        window.location.href = "../../../index.html";
    }
    else{
        alert("Logout Failed");
    }
  });
});

async function loadRooms() {
    const response = await fetch(apiRoot);
    const result = await response.json();

    if(!result.success){
        console.error("Failed to fetch rooms: ",result.message);
        return;
    }

    return result.data;
}

function renderRooms(rooms){
    const container = document.querySelector('.room-grid');
    const template = document.getElementById('room-template');

    rooms.forEach(function(room) {
        const card = template.cloneNode(true);
        card.style.display = "block";
        card.removeAttribute('id');
        card.classList.add('room-card');

        card.querySelector('img').src = room.image_01;
        card.querySelector('h3').textContent = room.room_name;
        card.querySelector('.price').textContent = 'Rs. ' + room.price;
        card.querySelector('.description').textContent = room.description;
        card.querySelector('.view-details').href = '../VIEW ROOM/viewRoom.php?id=' + room.id;

        const roomType = card.querySelector('.room-type');
        if(roomType){
            roomType.textContent = room.type || "";
        }

        const bedType = card.querySelector('.bed-type');
        if (bedType) {
            bedType.textContent = room.bed_type || '';
        }

        container.appendChild(card);
    });
}
function clearRoomCards() {
    const container = document.querySelector('.room-grid');
    const cards = container.querySelectorAll('.room-card');

    cards.forEach(card => {
        if (card.id !== 'room-template') {
            card.remove();
        }
    });
}

//-------------------------------- LOGOUT FUNCTION--------------------------
function toggleNav() {
  document.getElementById("myTopnav").classList.toggle("responsive");
}
async function logout(){
  console.log("You click me");
  const apiRoot = "../../backend/api/auth/logout.php";
  const respond = await fetch(apiRoot);
  const result = await respond.json();

  if(result.success){
    window.location.href="../../index.html";
  }
  else{
    alert("Logout Failed!");
  }
}