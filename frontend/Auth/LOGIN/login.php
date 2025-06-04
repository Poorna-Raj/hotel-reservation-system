<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elephant & Nature Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="loginStyle.css">
    
</head>
<body>
   
<!-- ---------------------------navi bar-------------------------- -->
 <div class="topnav" id="myTopnav">
  <div class="nav-left">
    <a href="#" class="logo">Elephant & Nature Resort</a>
    <div class="nav-links" id="navLinks">
      <a href="../../index.html" class="active">Home</a>
      <a href="../../ROOM/ROOM CARD/Roomcard.php">Accomadation</a>
     
      <a href="../About us page/aboutuspage.php">About</a>
    </div>
  </div>

  <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<!--------------------------- end of navi bar------------------------------------- -->


    <script src="loginScript.js"></script>
    <div class="login-wrapper">
        <div class="login-image" id="randomImageContainer">
            <img id="randomImage" src="images/istockphoto-517188688-612x612.jpg" alt="Random Nature Image">
            <div class="login-image-overlay">
                <div class="login-image-content">
                    <h2>Welcome to Elephant & Nature Resort</h2>
                    <p>Protecting nature, preserving wildlife</p>
                </div>
            </div>
        </div>
        <div class="login-content">
            <div class="login-logo">
                <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Animals/Elephant.png" alt="Elephant Logo">
                <h1>Elephant & Nature Management</h1>
            </div>

            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="email" id="username" class="form-control" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
                    <span class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>

                <div id="errorMessage" class="error-message">
                </div>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="../REGISTER/Register.php"> visit register</a></p>
            </div>
        </div>
    </div>

  
</body>
</html>