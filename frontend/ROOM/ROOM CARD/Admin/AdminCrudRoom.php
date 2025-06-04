<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Room</title>
        <link rel ="stylesheet" href="AdminCrudRoom.css">
       
    </head>
    <body>
       <?php include '../../../responsive-navbar/navbar.html'; ?>


    <div class="container">

      
        <div class="filter-search">
            <form id="filterForm">
                <div class="form-group">
                    <label for="search-name">Search by Name</label>
                    <input type="text" name="searchName" id="search-name" placeholder="Room Name">
                </div>
                
                <div class="form-group">
                    <label for="status">Room Status</label>
                    <select name="status" id="status">
                        <option value="">--ALL--</option>
                        <option value="Available">Available</option>
                        <option value="Booked">Booked</option>
                        <option value="Repair">Repair</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="order">Order By</label>
                    <select name="order" id="order">
                        <option value="">--DEFAULT--</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <input type="submit" value="Search Rooms">
                </div>
            </form>
        </div>

        
        <div class="room-grid">

            <!-------------------------------------------- Add Room Empty Card-------------------------------------------->
            <div class="room-card add-room-card" id="addRoomInterface">
                <div class="room-card-content">
                    <div class="add-icon">+</div>
                    <p>Add Room</p>
                </div>
            </div>







            <!-- Example Room Card 1 -->
            <div class="room-card" id="room-template" style="display: none;">
                <img class="room-image" src="" alt="Room">
                <div class="room-card-content">
                    <span class="status-tag" id="status"></span>
                    <h3 class="room-name"></h3>
                    <div class="sub-room-1">
                        <p class="room-type"></p>
                        <p class="bed-type"></p>
                    </div>
                    <p class="price"></p>
                    <p class="description"></p>
                    <a href="#" class="view-details">View Details</a>
                </div>
            </div>
            
        </div>
    </div>
    <!------------------------------------------ Pop up----------------------------------------- -->
    <div class="popup-overlay" id="popup">
        <div class="popup-form">
            <button class="close-btn" id="addRoomClose">×</button>
            <h2>Add Room</h2>
        <form id="addRoomForm">
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

            <button type="submit">Save</button>
        </form>
        </div>
    </div>

    <script src="admin.js"></script>
    
</body>

</html>
       
       
