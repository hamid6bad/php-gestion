<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form with Cards and Navbar</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* CSS for background image */
    .background-image {
      background-image: url('1.jpg'); /* Replace '1.jpg' with the path to your image */
      background-size: cover;
      background-position: center;
      min-height: 100vh; /* Adjust this as per your requirement */
    }
    .button-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 25%; /* Adjust as needed */
}
.btn2 {
  padding: 15px 40px;
  border: none;
  outline: none;
  color: #FFF;
  cursor: pointer;
  position: relative;
  z-index: 0;
  border-radius: 12px;
}
.btn2::after {
  content: "";
  z-index: -1;
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #333;
  left: 0;
  top: 0;
  border-radius: 10px;
}
/* glow */
.btn2::before {
  content: "";
  background: linear-gradient(
    45deg,
    #FF0000, #FF7300, #FFFB00, #48FF00,
    #00FFD5, #002BFF, #FF00C8, #FF0000
  );
  position: absolute;
  top: -2px;
  left: -2px;
  background-size: 600%;
  z-index: -1;
  width: calc(100% + 4px);
  height:  calc(100% + 4px);
  filter: blur(8px);
  animation: glowing 20s linear infinite;
  transition: opacity .3s ease-in-out;
  border-radius: 10px;
  opacity: 0;
}

@keyframes glowing {
  0% {background-position: 0 0;}
  50% {background-position: 400% 0;}
  100% {background-position: 0 0;}
}

/* hover */
.btn2:hover::before {
  opacity: 1;
}

.btn2:active:after {
  background: transparent;
}

.btn2:active {
  color: #000;
  font-weight: bold;
}

  </style>
</head>
<body>
<div class="background-image">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       
        <li class="nav-item">
          <a class="nav-link active" href="stagaire.php" >Acueill</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-dark" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<div class="container d-flex flex-column justify-content-center align-items-center">
  <?php
  // Check if submission was successful
  if (isset($_GET['status']) && $_GET['status'] === "success") {
      // Display success alert
      echo '<div class="alert alert-success mt-2" role="alert">
                Data submitted successfully!
            </div>';
  }
  ?>
  <?php
// Start PHP session
session_start();

// Function to redirect to login page after 30 minutes of inactivity
function redirectIfInactive() {
  // Check if last activity time is set in session
  if (isset($_SESSION['last_activity'])) {
    // Calculate difference between current time and last activity time
    $inactive_time = time() - $_SESSION['last_activity'];
    // Redirect if inactive for more than 30 minutes
    if ($inactive_time > 1800) {
      header("Location: stagaire.php");
      exit();
    }
  }
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve username and password from the form
  $username = $_POST['usernam'];
  $password = $_POST['password'];

  // Query to check if the username and password match any records in the login table
  $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Username and password are correct, redirect to listdemande.php
    $_SESSION['last_activity'] = time(); // Update last activity time
    header("Location: listdemande.php");
    exit(); // Stop further execution
  } else {
    // Username or password is incorrect, display error message
    echo '<div class="alert alert-danger mt-2" role="alert">Invalid username or password.</div>';
  }
}

// Redirect to stagaire.php if inactive for more than 30 minutes
redirectIfInactive();
?>
<div class="button-container">
  <button class="btn2 m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Registrer</button>
  <button class="btn2 m-2" data-bs-toggle="modal" data-bs-target="#loginModal">login</button>
</div>

  <!-- Login Modal -->


<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="mb-3">
            <label for="inputUsername" class="form-label">Nom D'utillisateur:</label>
            <div class="mb-3 input-group">
              <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
              </span>
              <input type="text" name="usernam" class="form-control-lg form-control" id="inputUsername" placeholder="Nom D'utillisateur">
            </div>
          </div>
          <div class="mb-3">
            <label for="inputPassword" class="form-label">Mot de Passe:</label>
            <div class="mb-3 input-group">
              <span class="input-group-text">
                <i class="bi bi-lock-fill"></i>
              </span>
              <input type="password" class="form-control-lg form-control" id="inputPassword" name="password" placeholder="Mot de Passe">
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  action="insert.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <label for="input1" class="form-label">Nom:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-person-fill"></i>
                  </span>
                <input type="text" name="nom" class="form-control" id="input1" placeholder="Nom">
              </div>
            </div>
            <div class="col-md-6">
              <label for="Prenom" class="form-label">Prenom:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-person-fill"></i>
                  </span>
                <input type="text" name="prenom" class="form-control" id="Prenom" placeholder="Prenom">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Tel" class="form-label">Tel:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-telephone-fill"></i>
                  </span>
                <input type="text" name="telephone" class="form-control" id="Tel" placeholder="Tel">
              </div>
            </div>
            <div class="col-md-6">
              <label for="Email" class="form-label">Email:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-envelope-fill"></i>
                  </span>
                <input type="email" name="email" class="form-control" id="Email" placeholder="Email">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Tel" class="form-label">Ville:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                    <i class="bi bi-building-fill"></i>
                  </span>
                <input type="text" name="ville" class="form-control" id="Tel" placeholder="Tel">
              </div>
            </div>
            <div class="col-md-6">
              <label for="branche" class="form-label">Branche:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                    <i class="bi bi-person-workspace"></i>
                  </span>
                <input type="text"  class="form-control" id="branche" placeholder="Branche" name="branche">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
            <label for="datedenaissance" class="form-label">Date:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-calendar-date-fill"></i>
                  </span>
                <input type="date" name="date" class="form-control" id="date" >
              </div>
            </div>
            <div class="col-md-6">
            <label for="datedenaissance" class="form-label">Date de Naissance:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-calendar-date-fill"></i>
                  </span>
                <input type="date" name="datedenaissance" class="form-control" id="datedenaissance" >
              </div>
            </div>
          </div>
          

          <div class="row">
            <div class="col-md-6">
            <label for="datedenaissance" class="form-label">Date de Debut:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-calendar-date-fill"></i>
                  </span>
                <input type="date" name="datededebut" class="form-control" id="datededebut" >
              </div>
            </div>
            <div class="col-md-6">
            <label for="datedenaissance" class="form-label">Date de Fin:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-calendar-date-fill"></i>
                  </span>
                <input type="date" name="datedefin" class="form-control" id="datedefin" >
              </div>
            </div>
          </div>



          
          <div class="mb-3">
              <label for="Diplome" class="form-label">Diplome:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-file-earmark-text-fill"></i>
                  </span>
                <input type="file" name="diplome" class="form-control" id="Diplome">
              </div>
          </div>
          <div class="mb-3">
              <label for="demande" class="form-label">Demande de Stage:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-file-earmark-text-fill"></i>
                  </span>
                <input type="file" name="demande" class="form-control" id="demande">
              </div>
          </div>
          <div class="mb-3">
              <label for="cv" class="form-label">CV:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-file-earmark-text-fill"></i>
                  </span>
                <input type="file" name="cv" class="form-control" id="cv">
              </div>
          </div>
          <div class="mb-3">
              <label for="assurance" class="form-label">Assurance:</label>
              <div class="mb-3 input-group">
                  <span class="input-group-text">
                      <i class="bi bi-file-earmark-text-fill"></i>
                  </span>
                <input type="file" name="assurance" class="form-control" id="assurance">
              </div>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
// Check if modal parameter exists
if (isset($_GET['modal']) && $_GET['modal'] === "exampleModal") {
    echo "<script>$(document).ready(function() { $('#exampleModal').modal('show'); });</script>";
}
?>


<!-- Bootstrap Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
