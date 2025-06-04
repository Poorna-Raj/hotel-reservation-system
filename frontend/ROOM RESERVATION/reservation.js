window.addEventListener("DOMContentLoaded",function(){

    const searchForm = this.document.getElementById("filterForm");
    (async function(){
        const reservations = await loadReservation();
        renderReservation(reservations);
    })();

    searchForm.addEventListener("submit",async function(event){
        event.preventDefault();
        const apiRoot = "../../backend/api/reservation/reservation.php";
        const params = new (URLSearchParams);
        if(searchForm.checkin.value) params.append("inDate",searchForm.checkin.value);
        if(searchForm.roomid.value) params.append("roomID",searchForm.roomid.value);
        if(searchForm.paymentStatus.value) params.append("payStatus",searchForm.paymentStatus.value);
        if(searchForm.reservationStatus.value) params.append("reservationStatus",searchForm.reservationStatus.value);

        const respond = await fetch(apiRoot + "?" + params);
        const result = await respond.json();

        if(!result.success){
            console.error("Failed to fetch data: ", result.message);
        }
        else{
            clearReservationCards();
            renderReservation(result.data);
            console.log(result.data);
        }
    });
});
async function loadReservation(){
    const apiRoot = "../../backend/api/reservation/reservation.php";

    const respond = await fetch(apiRoot);
    const result = await respond.json();
    if(!result.success){
        console.error("Failed to fetch data: ",result.message);
    }
    else{
        return result.data;
    }
}
async function renderReservation(reservations){
    const reserTemplate = document.getElementById("reservation_template");
    const container = document.getElementById("roomGrid");

    reservations.forEach(function(reservation){
        const card = reserTemplate.cloneNode(true);
        card.style.display = "flex";
        card.removeAttribute('id');
        card.classList.add('room-card');

        card.querySelector("h3").textContent = reservation.id;
        card.querySelector(".check-in").textContent = reservation.check_in_date;
        card.querySelector(".check-out").textContent = reservation.check_out_date;
        card.querySelector('.price').textContent = 'Rs. ' + reservation.total_amount;
        card.querySelector('.guest').textContent = reservation.num_guest;

        if(reservation.payment_status === "Pending"){
            card.querySelector(".reservation.booked").textContent = "Pending";
        }
        else if(reservation.payment_status === "Paid"){
            card.querySelector(".reservation.booked").textContent = "Paid";
        }
        else{
            card.querySelector(".reservation.booked").textContent = "Cancelled";
        }

        if(reservation.reservation_status === "Booked"){
            card.querySelector(".payment.paid").textContent = "Booked";
        }
        else if(reservation.reservation_status === "CheckedIn"){
            card.querySelector(".payment.paid").textContent = "CheckedIn";
        }
        else if(reservation.reservation_status === "CheckedOut"){
            card.querySelector(".payment.paid").textContent = "CheckedOut";
        }
        else{
            card.querySelector(".payment.paid").textContent = "Cancelled";
        }

        container.appendChild(card);
    });
}
function clearReservationCards() {
  const container = document.getElementById("roomGrid");
  const children = Array.from(container.children);

  children.forEach(child => {
    if (child.id !== "reservation_template") {
      container.removeChild(child);
    }
  });
}