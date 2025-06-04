window.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.getElementById("filterForm");
  const updateModal = document.querySelector(".modal-overlay");
  const updateForm = document.getElementById("updateForm");
  const updateBtn = document.querySelector(".btn-update");
  const logoutBtn = document.querySelector(".logout-btn");

  // Load and render reservations on initial page load
  (async function () {
    const reservations = await loadReservation();
    renderReservation(reservations);
  })();

  // Check user role and hide admin functions for customers
  (async function () {
    checkUser();
  })();

  // Handle search form submission
  searchForm.addEventListener("submit", async function (event) {
  event.preventDefault();

  const apiRoot = "../../backend/api/reservation/reservation.php";
  const params = new URLSearchParams();

  const checkin = searchForm.querySelector('[name="check-in"]').value;
  const roomID = searchForm.querySelector('[name="room-id"]').value;
  const payStatus = searchForm.querySelector('[name="payment-status"]').value;
  const reservationStatus = searchForm.querySelector('[name="reservation-status"]').value;



  if (checkin) params.append("inDate", checkin);
  if (roomID) params.append("roomID", roomID);
  if (payStatus) params.append("payStatus", payStatus);
  if (reservationStatus) params.append("reservationStatus", reservationStatus);

  const response = await fetch(apiRoot + "?" + params.toString());
  const result = await response.json();

  if (!result.success) {
    console.error("Failed to fetch data: ", result.message);
  } else {
    clearReservationCards();
    renderReservation(result.data);
  }

  });
  updateBtn.addEventListener("click",function(){
    updateModal.style.display = "flex";
  })
  logoutBtn.addEventListener("click",async function() {
    const apiRoot = "../../backend/api/auth/logout.php";
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

async function loadReservation() {
  const roleResponse = await fetch("../../backend/api/auth/getRole.php");
  const roleResult = await roleResponse.json();

  if (!roleResult.success) {
    console.error("Failed to fetch user role.");
    return [];
  }

  const apiRoot = "../../backend/api/reservation/reservation.php";
  const endpoint = "../../backend/api/reservation/customer/reservation.php";

  let result = null;
  // Optionally add a query to indicate full access if admin
  if (roleResult.role === "customer") {
    const response = await fetch(endpoint);
    result = await response.json();
  }
  else{
    const response = await fetch(apiRoot);
    result = await response.json();
  }

  

  if (!result.success) {
    console.error("Failed to fetch reservations: ", result.message);
    return [];
  }

  return result.data;
}


function clearReservationCards() {
  const container = document.getElementById("roomGrid");
  const children = Array.from(container.children);

  children.forEach((child) => {
    if (child.id !== "reservation_template") {
      container.removeChild(child);
    }
  });
}

function renderReservation(data) {
  const roomGrid = document.getElementById("roomGrid");
  const template = document.getElementById("reservation_template");

  // Clear existing cards except template
  roomGrid.querySelectorAll(".room-card:not(#reservation_template)").forEach(el => el.remove());

  data.forEach(reservation => {
    const clone = template.cloneNode(true);
    clone.id = ""; // Remove ID to avoid duplicates
    clone.style.display = "block"; // Ensure it's visible

    const roomInfo = clone.querySelector(".room-info");
    if (!roomInfo) return;

    // Update reservation and payment status text
    const reservationText = clone.querySelector(".reservation");
    const paymentText = clone.querySelector(".payment");

    if (reservationText) reservationText.textContent = reservation.reservation_status;
    if (paymentText) paymentText.textContent = reservation.payment_status;

    // Room title
    const roomTitle = clone.querySelector("h3");
    if (roomTitle) roomTitle.textContent = `Reservation ID: ${reservation.id}`;

    // Dates, guests, price
    const checkIn = clone.querySelector(".check-in");
    const checkOut = clone.querySelector(".check-out");
    const guest = clone.querySelector(".guest");
    const price = clone.querySelector(".price");

    if (checkIn) checkIn.textContent = reservation.check_in_date;
    if (checkOut) checkOut.textContent = reservation.check_out_date;
    if (guest) guest.textContent = reservation.num_guest;
    if (price) price.textContent = `Rs. ${reservation.total_amount}`;

    // Buttons
    const updateBtn = clone.querySelector(".btn-update");
    const deleteBtn = clone.querySelector(".btn-delete");

    if (updateBtn) {
      updateBtn.addEventListener("click", () => openUpdateModal(reservation));
    }

    if (deleteBtn) {
      deleteBtn.addEventListener("click", () => deleteReservation(reservation.room_id));
    }

    roomGrid.appendChild(clone);
  });
}


function openUpdateModal(reservation) {
  const modal = document.querySelector(".modal-overlay");
  const form = modal.querySelector("#updateForm");

    // Pre-fill the form fields safely using querySelector
    form.querySelector('input[name="room-id"]').value = reservation.id;
    form.querySelector('input[name="checkin"]').value = reservation.check_in_date;
    form.querySelector('input[name="checkout"]').value = reservation.check_out_date;
    form.querySelector('input[name="price"]').value = reservation.total_amount;
    form.querySelector('input[name="guests"]').value = reservation.num_guest;
    form.querySelector('select[name="payment"]').value = reservation.payment_status.toLowerCase();
    form.querySelector('select[name="reservation"]').value = reservation.reservation_status.toLowerCase();

    modal.style.display = "flex";

    document.getElementById("closeModal").onclick = () => {
        modal.style.display = "none";
    }
    const updateForm = document.querySelector("#updateForm");
    updateForm.addEventListener("submit", async function(e){
        e.preventDefault();
        const reservationData = {
        reserveID: form.elements["room-id"].value,
        inDate: form.elements["checkin"].value,
        outDate: form.elements["checkout"].value,
        total: form.elements["price"].value,
        num_of_guest: form.elements["guests"].value,
        payStatus: form.elements["payment"].value.toUpperCase(),
        reserveStatus: form.elements["reservation"].value.toUpperCase(),
        };
        const response = await fetch("../../backend/api/reservation/updateReservation.php", {
        method: "POST",
        body: JSON.stringify(reservationData),
        headers: {
            "Content-Type": "application/json"
        }
        });

        const result = await response.json();
        if (result.success) {
        alert("Reservation updated successfully!");
        modal.style.display = "none";
        clearReservationCards();
        const reservations = await loadReservation();
        renderReservation(reservations);
        } else {
        alert("Failed to update reservation: " + result.message);
        }
    });

}

async function deleteReservation(id) {
  const confirmDelete = confirm("Are you sure you want to delete this reservation?");
  if (!confirmDelete) return;

  const deleteData = {
    reservationID : id
  }
  const response = await fetch("../../backend/api/reservation/deleteReservation.php", {
    method: "POST",
    body: JSON.stringify(deleteData),
    headers: {
      "Content-Type": "application/json"
    }
  });

  const result = await response.json();
  if (result.success) {
    alert("Reservation deleted successfully.");
    clearReservationCards();
    const reservations = await loadReservation();
    renderReservation(reservations);
  } else {
    alert("Failed to delete reservation: " + result.message);
  }
}

async function checkUser() {
  const response = await fetch("../../backend/api/auth/getRole.php");
  const result = await response.json();

  if (result.success && result.role === "customer") {
    const adminFuncElements = document.querySelectorAll("#adminFunc");
    adminFuncElements.forEach((el) => (el.style.display = "none"));
  }
  else if(result.success && result.role === "admin"){
    const adminFuncElements = document.querySelectorAll("#adminFunc");
    adminFuncElements.forEach((el) => (el.style.display = "block"));
  }
  else{
    window.location.href = "../Auth/LOGIN/login.php";
  }
}
// ------------------------------------------LOG OUT FUNCTION----------------------------
function toggleNav() {
  document.getElementById("myTopnav").classList.toggle("responsive");
}