<?php
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

// SQL query to fetch data
$sql = "SELECT * FROM stagiaire";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Styled Table</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .background-image {
      background-image: url('1.jpg'); /* Replace '1.jpg' with the path to your image */
      background-size: cover;
      background-position: center;
      min-height: 100vh; /* Adjust this as per your requirement */
    }
    
    
  </style>
</head>
<body>
<div class="background-image">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="stagaire.php">Acueill</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="listdemande.php">Liste de Demande</a>
          </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<div class="container-fluid mt-4" >
  <div class="row justify-content-center">
    <div class="coll">
    <?php
// Check if success parameter is set
if (isset($_GET['success']) && $_GET['success'] == 1) {
    // Display success alert
    echo '<div id="success-alert" class="alert alert-success" role="alert">
            le stagiaire est accepter avec succes et un Email envoie avec success!
          </div>';
}
?>
<?php
// Check if success parameter is set
if (isset($_GET['success']) && $_GET['success'] == 2) {
    // Display success alert
    echo '<div id="success-alert" class="alert alert-danger" role="alert">
            Le stagiaire est supprimer et informe par email avec success!
          </div>';
}
?>

<script>
    // Wait for the entire page to load, including images and other resources
    window.onload = function() {
        // Delay showing the alert by 1 second
        setTimeout(function() {
            // Select the alert element
            var alert = document.getElementById("success-alert");
            // Check if the alert element exists
            if (alert) {
                // Hide the alert after 5 seconds
                setTimeout(function() {
                    alert.style.display = "none";
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        }, 1000); // 1000 milliseconds = 1 second
    };
</script>

      <table class="table table-hover table-sm  bg-light table-responsive">
        <thead class="table-primary">
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Tel</th>
            <th scope="col">Email</th>
            <th scope="col">Ville</th>
            <th scope="col">Branche</th>
            <th scope="col">Date</th>
            <th scope="col">Date de Naissance</th>
            <th scope="col">Date Debut</th>
            <th scope="col">Date Fin</th>
            <th scope="col">Diplome</th>
            <th scope="col">Demande</th>
            <th scope="col">CV</th>
            <th scope="col">Assurance</th>
            <th scope="col">Actions</th> <!-- Changed from Status -->
          </tr>
        </thead>
        <tbody>
          <?php
          // Check if there are rows returned
          if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["nom"] . "</td>";
              echo "<td>" . $row["prenom"] . "</td>";
              echo "<td>" . $row["telephone"] . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["ville"] . "</td>";
              echo "<td>" . $row["branche"] . "</td>";
              echo "<td>" . $row["datee"] . "</td>";
              echo "<td>" . $row["datedenaissance"] . "</td>";
              echo "<td>" . $row["datedebut"] . "</td>";
              echo "<td>" . $row["datee"] . "</td>";
              echo "<td class='text-center'><a class='btn btn-warning text-light btn-sm' href='uploads/" . $row["diplome"] . "'><i class='bi bi-file-earmark-text'></i></a></td>";
              echo "<td class='text-center'><a class='btn btn-warning text-light btn-sm' href='uploads/" . $row["demande"] . "'><i class='bi bi-file-earmark-text'></i></a></td>";
              echo "<td class='text-center'><a class='btn btn-warning text-light btn-sm' href='uploads/" . $row["cv"] . "'><i class='bi bi-file-earmark-text'></i></a></td>";
              echo "<td class='text-center'><a class='btn btn-warning text-light btn-sm' href='uploads/" . $row["assurance"] . "'><i class='bi bi-file-earmark-text'></i></a></td>";
              echo "<td>";
              // Check button with icon
            
              echo "<button type='button' class='btn btn-primary btn-sm m-1' onclick='download(" . $row["id"] . ")'><i class='bi bi-save-fill'></i></button>";
              echo "<button type='button' class='btn btn-success btn-sm m-1' onclick='generateWordFile(" . $row["id"] . ")'><i class='bi bi-check-circle'></i></button>";
              echo "<button type='button' class='btn btn-danger btn-sm m-1' onclick='deleteEntry(" . $row["id"] . ")'><i class='bi bi-x-circle'></i></button>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='12'>0 results</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  function generateWordFile(id) {
    if (confirm("Are you sure you want to generate a Word file for this entry?")) {
        // Send AJAX request to generate the Word file
        $.ajax({
            url: 'generate_word.php',
            type: 'POST',
            data: { id: id },
            success: function(filename) {
                // Create a hidden anchor element to trigger file download
                // Redirect to listdemande.php with success parameter
                window.location.href = 'listdemande.php?success=1';
            },
            error: function(xhr, status, error) {
                console.error("Error generating Word file:", error);
            }
        });
    }
}

function download(id) {
    if (confirm("Are you sure you want to generate a Word file for this entry?")) {
        // Send AJAX request to generate the Word file
        $.ajax({
            url: 'download_pdf.php',
            type: 'POST',
            data: { id: id },
            success: function() {
                // Create a hidden anchor element to trigger file download
                // Redirect to listdemande.php with success parameter
                window.location.href = 'listdemande.php?success=1';
            },
            error: function(xhr, status, error) {
                console.error("Error generating Word file:", error);
            }
        });
    }
}



function deleteEntry(id) {
    var additionalInfo = prompt("Please provide additional information (optional):");
    if (confirm("Are you sure you want to delete this entry?")) {
      $.ajax({
        url: 'delete_entry.php',
        type: 'POST',
        data: { id: id, additionalInfo: additionalInfo }, // Pass additionalInfo to the server
        success: function(response) {
          console.log("Deletion successful");
          window.location.href = "listdemande.php?success=2"; // Redirect with success parameter
        },
        error: function(xhr, status, error) {
          console.error("Error deleting entry:", error);
        }
      });
    }
  }
</script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
