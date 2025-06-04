<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Room Details</title>
        <link rel ="stylesheet" href="Roomcard.css">
       
    </head>
    <body>
    
    <div class="topnav" id="myTopnav">
  <div class="nav-left">
    <a href="#" class="logo">Elephant & Nature</a>
    <div class="nav-links" id="navLinks">
      <a href="../../../index.html" class="active">Home</a>
      <a href="../../ROOM/ROOM CARD/Roomcard.php">Accomadation</a>
      <a href="../../ROOM RESERVATION/Reservation.php">Reservation</a>
      <a href="../../About us page/aboutuspage.php">About</a>
    </div>
  </div>
  <div class="nav-right">
    <a class="logout-btn">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>










    <div class="container">
        <div class="filter-search">
            <form id="filterForm">
               

                <div class="form-group">
                    <label for="status">Room Type</label>
                    <select name="roomType" id="roomStatus">
                        <option value="">--ALL--</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Standard">Standard</option>
                        <option value="Suite">Suite</option>
                         <option value="Family">Family</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="status">Bed Type</label>
                    <select name="status" id="status">
                        <option value="">--ALL--</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Twin">Twin</option>
                        <option value="Queen">Queen</option>
                        <option value="King">King</option>
                    </select>
                </div>
                
             <div class="form-group">
                <label for="max-occupancy">Max Occupancy</label>
                <input
                    type="number"
                    name="maxOccupancy"
                    id="max-occupancy"
                    min="1"
                    placeholder="Enter number of guests"
                >
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

        <!--for-php-code-bla-bla-->
        <div class="room-grid">
            <!-- this is for the creation only -->
            <div class="room-card" id="room-template" style="display: none;">
                <img class="room-image" src="" alt="Room Image">
                <div class="room-card-content">
                    <h3 class="room-name"></h3>
                    <div class="sub-room-1">
                        <p class="room-type"></p>
                        <p class="bed-type"></p>
                    </div>
                    <p class="price"></p>
                    <p class="description"></p>
                    <a href="" class="view-details">View Details</a>
                </div>
            </div>
        </div>
    </div>
    <script src="Roomcard.js"></script>
</body>

</html>
       
       
