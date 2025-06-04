<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elephant & Nature Management - Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css" />
</head>
<body>
    
<!---------------------------------- nav bar--------------------- -->

<div class="topnav" id="myTopnav">
  <div class="nav-left">
    <a href="#" class="logo">Elephant & Nature Resort</a>
    <div class="nav-links" id="navLinks">
      <a href="../../../index.html" class="active">Home</a>
      <a href="../../ROOM/ROOM CARD/Roomcard.php">Accomadation</a>
     
      <a href="../../About us page/aboutuspage.php">About</a>
    </div>
  </div>

  <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
    <i class="fa fa-bars"></i>
  </a>
</div>






    <script src="register.js"></script>
    <div class="registration-wrapper">
       <div class="registration-image" id="randomImageContainer">
    <div class="registration-image-overlay"></div>
</div>

        
        <div class="registration-content">
            <div class="registration-header">
                <h2>Register and Start Planning</h2>
            </div>

            <form id="registrationForm" class="registration-form">
                <div class="form-group">
                    <label for="full-name">Full Name</label>
                    <input type="text" id="full-name" name="fullname" class="form-control" placeholder="Enter your full name">
                    <div class="error" id="full-name-error"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email">
                    <div class="error" id="email-error"></div>
                </div>

                <div class="form-group">
                    <label for="nic">NIC Number</label>
                    <input type="text" id="nic" name="nic" class="form-control" placeholder="Enter your NIC number">
                    <div class="error" id="nic-error"></div>
                </div>

                <div class="form-group">
                    <label for="tel">Phone Number</label>
                    <input type="text" id="tel" name="tele" class="form-control" placeholder="Enter your phone number">
                    <div class="error" id="tel-error"></div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" placeholder="Enter your address"></textarea>
                    <div class="error" id="address-error"></div>
                </div>

                <div class="form-group">
                    <label for="pass1">Password</label>
                    <input type="password" id="pass1" name="pass1" class="form-control" placeholder="Create a password">
                    <div class="password-strength">
                        <span></span>
                    </div>
                    <span class="password-strength-text"></span>
                    <div class="error" id="pass1-error"></div>
                </div>

                <div class="form-group">
                    <label for="con-pass">Confirm Password</label>
                    <input type="password" id="con-pass" name="conpass" class="form-control" placeholder="Confirm your password">
                    <div class="error" id="con-pass-error"></div>
                </div>

                <div id="errorMessage" class="error-message">
                </div>

                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus"></i> Register
                </button>

                
            </form>
        </div>
    </div>    