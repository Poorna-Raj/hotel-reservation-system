window.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.getElementById("filterForm");
  const updateModal = document.querySelector(".modal-overlay");

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

    if (searchForm.checkin.value) params.append("inDate", searchForm.checkin.value);
    if (searchForm.roomid.value) params.append("roomID", searchForm.roomid.value);
    if (searchForm.paymentStatus.value) params.append("payStatus", searchForm.paymentStatus.value);
    if (searchForm.reservationStatus.value) params.append("reservationStatus", searchForm.reservationStatus.value);

    const response = await fetch(apiRoot + "?" + params);
    const result = await response.json();

    if (!result.success) {
      console.error("Failed to fetch data: ", result.message);
    } else {
      clearReservationCards();
      renderReservation(result.data);
    }
  });
});

async function loadReservation() {
  const apiRoot = "../../backend/api/reservation/reservation.php";
  const response = await fetch(apiRoot);
  const result = await response.json();

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

function renderReservation(reservations) {
  const template = document.getElementById("reservation_template");
  const container = document.getElementById("roomGrid");

  reservations.forEach((reservation) => {
    const card = template.cloneNode(true);
    card.style.display = "flex";
    card.removeAttribute("id");

    card.querySelector("h3").textContent = reservation.id;
    card.querySelector(".check-in").textContent = `Check-in: ${reservation.check_in_date}`;
    card.querySelector(".check-out").textContent = `Check-out: ${reservation.check_out_date}`;
    card.querySelector(".guest").textContent = `Guests: ${reservation.num_guest}`;
    card.querySelector(".price").textContent = `Rs. ${reservation.total_amount}`;

    // Payment Status
    const paymentText = card.querySelector(".reservation.booked");
    paymentText.textContent = reservation.payment_status;

    // Reservation Status
    const reservationText = card.querySelector(".payment.paid");
    reservationText.textContent = reservation.reservation_status;

    // Setup Update and Delete Button Handlers
    const updateBtn = card.querySelector(".btn-update");
    const deleteBtn = card.querySelector(".btn-delete");

    updateBtn.addEventListener("click", () => openUpdateModal(reservation));
    deleteBtn.addEventListener("click", () => deleteReservation(reservation.id));

    container.appendChild(card);
  });
}

function openUpdateModal(reservation) {
  const modal = document.querySelector(".modal-overlay");
  const form = modal.querySelector("#updateForm");

  // Pre-fill the form
  form.elements["room-id"].value = reservation.id;
  form.elements["checkin"].value = reservation.check_in_date;
  form.elements["checkout"].value = reservation.check_out_date;
  form.elements["guests"].value = reservation.num_guest;
  form.elements["payment"].value = reservation.payment_status.toLowerCase();
  form.elements["reservation"].value = reservation.reservation_status.toLowerCase();

  modal.style.display = "flex";

  // Close modal
  document.getElementById("closeModal").onclick = () => {
    modal.style.display = "none";
  };

  // Handle Update Submission
  form.onsubmit = async function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    const response = await fetch("../../backend/api/reservation/updateReservation.php", {
      method: "POST",
      body: JSON.stringify(data),
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
  };
}

async function deleteReservation(id) {
  const confirmDelete = confirm("Are you sure you want to delete this reservation?");
  if (!confirmDelete) return;

  const response = await fetch("../../backend/api/reservation/deleteReservation.php", {
    method: "POST",
    body: JSON.stringify({ id }),
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
}
