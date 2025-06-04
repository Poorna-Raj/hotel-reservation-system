<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
     <link rel ="stylesheet" href="viewRoom.css">
   
  </head>
  <body>


<!----------------------------------------- this is the navigation bar ------------------------------------------------>
    <?php include '../../responsive-navbar/navbar.html'; ?>
    <!-- --------------------------------------navigation code is close -------------------------------------------->



    <div class="room-container">
      <div class="room-header">
        <h1 class="room-name"></h1>
        <span class="room-type-badge"></span>
      </div>

      <div class="image-gallery">
        <div class="main-image">
          <img
            src=""
            alt="Primary room image" />
        </div>
        <div class="side-images">
          <img class="side-image-1"
            src=""
            alt="Second room image" />
          <img class="side-image-2"
            src=""
            alt="Third room image" />
        </div>
      </div>

      <div class="room-details">
        <div class="details-left">
          <div class="detail-row">
            <span class="detail-label">Bed Type</span>
            <div class="detail-value">
              <i class="fas fa-bed amenity-icon"></i>
              <p class="bed-type-detail"></p>
            </div>
          </div>

          <div class="detail-row">
            <span class="detail-label">Max Occupancy</span>
            <div class="detail-value">
              <i class="fas fa-users amenity-icon"></i>
              <p class="detail-value-occu"></p>
            </div>
          </div>


          <div class="detail-row">
            <span class="detail-label">Description</span>
            <p class="description"></p>
          </div>

          <div class="detail-row">
            <span class="detail-label">Status</span>
            <div class="detail-value">
              <span class="status-badge status-available" style="display: none;"> <i class="fas fa-check-circle"></i> Available </span>
              <span class="status-badge status-unavailable" style="display: none;"> <i class="fas fa-times-circle"></i> Unavailable </span>
            </div>
          </div>
        </div>

        <div class="details-right">
          <div class="price-section">
            <div class="price-label">Price per night</div>
            <div class="price-value"></div>
          </div>

          <div class="detail-row">
            <span class="detail-label">Room Overview</span>
            <p class="detailsShort"></p>
          </div>

         <!-------------------------------------------- Book Now Button --------------------------------------------------->
<button id="bookNowBtn" class="book-now-btn">Book Now</button>

<!---------------------------------------------------- Admin Action Buttons----------------------- -->
<div class="admin-actions" id="adminFunc">
  <button class="update-btn" id="updateBtn"><i class="fas fa-edit"></i> Update</button>
  <button class="delete-btn" id="deleteBtn"><i class="fas fa-trash-alt"></i> Delete</button>
</div>


<!-------------------------------------------------------- Popup Modal ------------------------------------------------->
<div id="bookingModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" id="closeModal">&times;</span>
    <h2>Book Your Stay</h2>
    <form id="bookingForm">
      <label for="checkIn">Check-In Date</label>
      <input type="date" name="checkin" id="checkIn" required />

      <label for="checkOut">Check-Out Date</label>
      <input type="date" id="checkOut" name="checkout" required />

      <label for="guests">Number of Guests</label>
      <input type="number" id="guests" min="1" value="1" name="guest" required />

      <label for="total">Total</label>
      <input type="text" id="total" name="total" readonly />

      <p id="errorMessage" class="errorMessage"></p>
      <button type="submit">Confirm Booking</button>
    </form>
  </div>
</div>

<!-- -------------------------------------------update and form---------------------------------------------------- -->
 <!-- Popup Form -->
<div class="popup-form-overlay" id="updatePopup"> 
  <div class="popup-form">
    <h2>Update Room</h2>
    <form id="updateRoomForm">
      <label>Room Name</label>
            <input type="text" name="roomName" placeholder="Enter room name" required />

            <label>Room Type</label>
            <select required name="roomType">
            <option value="">Select type</option>
            <option value="Deluxe">Deluxe</option>
            <option value="Standard">Standard</option>
            <option value="Suite">Suite</option>
            <option value="Family">Family</option>
            </select>

            <label>Price</label>
            <input type="text" name="price" placeholder="Enter the room price" required />
            
            <label>Bed Type</label>
            <select required name="bedType">
            <option value="">Select type</option>
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            <option value="Twin">Twin</option>
            <option value="Queen">Queen</option>
            <option value="King">King</option>

            </select>

            <label for="max_occupancy" class="required">Maximum Occupancy</label>
                                <input type="number" id="max_occupancy" name="max_occupancy" required min="1" max="10" placeholder="e.g. 2">

        <label for="short_description" class="required">Short Description</label>
                                <div class="textarea-wrapper">
                                    <textarea id="short_description" name="short_description" required placeholder="Brief summary of the room (will appear in listings)" maxlength="150"></textarea>
                                
                                </div>

                                <label for="description">Full Description</label>
                                <div class="textarea-wrapper">
                                    <textarea id="description" name="description" placeholder="Detailed description of the room and its amenities"></textarea>
                                    
                                </div>

                                <label for="image_01" class="required">Primary Image URL</label>
                                <textarea id="image_01" name="image_01" required placeholder="Enter image URL or upload path"></textarea>

                                <label for="image_02">Secondary Image URL</label>
                                <textarea id="image_02" name="image_02" placeholder="Enter image URL or upload path"></textarea>

                                <label for="image_03">Additional Image URL</label>
                                <textarea id="image_03" name="image_03" placeholder="Enter image URL or upload path"></textarea>
        <label for="status">Status</label>
        <select name="status">
        <option value="Available">Available</option>
        <option value="Booked">Booked</option>
        <option value="Repair">Repair</option>
        </select>

      <div class="popup-buttons">
        <button type="submit">Save</button>
        <button type="button" id="updatePopClose">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- ------------------------------------------ended here--------------------------------------------- -->
 <!-- -----------------------------------Delete Confirmation Popup--------------------------------------->
<div class="popup-form-overlay" id="deletePopup">
  <div class="popup-form">
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete this room?</p>
    <div class="popup-buttons">
      <button id="makeDelete">Yes, Delete</button>
      <button id="closeDelete">Cancel</button>
    </div>
  </div>
</div>


        </div>
      </div>
    </div>
    <script src="viewRoom.js"></script>
  </body>
</html>
