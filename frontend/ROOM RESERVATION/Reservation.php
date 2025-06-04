<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Room Reservation | Elephant & Nature Resort</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="Reservation.css"/>
  <link rel="icon" href="favicon.ico" type="image/x-icon"/>
  <meta name="description" content="Book your stay at Elephant & Nature Resort. Explore our luxurious rooms and serene environment in Anuradhapura, Sri Lanka.">
  <meta name="keywords" content="Elephant & Nature Resort, Room Reservation, Anuradhapura, Sri Lanka, Luxury Rooms, Eco-Friendly Resort">
  <meta name="author" content="Elephant & Nature Resort Team">
</head>
<body>
      <?php include '../responsive-navbar/navbar.html'; ?>

  <header>
    <h1>Elephant & Nature Resort</h1>
    <p>Tranquil Stays in the Heart of Anuradhapura</p>
  </header>

  <form id="filterForm">
  <section class="filter-section">
    <input type="text" name="room-id" placeholder="Room ID" />

    <input type="date" name="check-in" placeholder="Check-in Date" />
    

    <select name="payment-status">
      <option value="">Payment Status</option>
      <option value="pending">Pending</option>
      <option value="paid">Paid</option>
      <option value="cancelled">Cancelled</option>
    </select>

    <select name="reservation-status">
      <option value="">Reservation Status</option>
      <option value="booked">Booked</option>
      <option value="checkedin">Checked In</option>
      <option value="checkedout">Checked Out</option>
      <option value="cancelled">Cancelled</option>
    </select>

    <button>Search Reservations</button>
  </form>
</section>

  <section class="room-grid" id="roomGrid">
    <div class="room-card" id="reservation_template">
      
      <div class="room-info">
        <div class="room-status">
          <span class="reservation booked"></span>
          <span class="payment paid"></span>
        </div>
        <h3></h3>

         <label>Check-in Date:</label>
        <p class="check-in"></p>

        <label>Check-out Date:</label>
        <p class="check-out"></p>

        <label>Guests:</label>
        <p class="guest"></p>

        <label>Payment Price:</label>
        <p class="price"></p>

 <div class="room-actions">
    <button class="btn-update">Update</button>
    <button class="btn-delete">Delete</button>
  </div>

      </div>
    </div>
  </section>

  <!--------------------------------------- update pop up------------------------------------------------ -->
  <div class="modal-overlay" id="updateModal">
  <div class="modal-content">
    <span class="close-btn" id="closeModal">&times;</span>
    <h2>Update Reservation</h2>
    <form id="updateForm">
      <input type="hidden" name="room-id" />

      <label>Check-in Date:</label>
      <input type="date" name="checkin" required />

      <label>Check-out Date:</label>
      <input type="date" name="checkout" required />

      <label>Guests:</label>
      <input type="number" name="guests" min="1" required />

      <label>Price:</label>
      <input type="text" name="price"required />

      <label>Payment Status:</label>
      <select name="payment">
        <option value="pending">Pending</option>
        <option value="paid">Paid</option>
        <option value="cancelled">Cancelled</option>
      </select>

      <label>Reservation Status:</label>
      <select name="reservation">
        <option value="booked">Booked</option>
        <option value="checkedin">Checked In</option>
        <option value="checkedout">Checked Out</option>
        <option value="cancelled">Cancelled</option>
      </select>

      <button type="submit" class="btn-update-modal">Save Changes</button>
    </form>
  </div>
</div>

  

  <footer>
    <p>&copy; 2025 Elephant & Nature Resort. All rights reserved.</p>
</footer>

  <script src="reservation.js"></script>

</body>
</html>
