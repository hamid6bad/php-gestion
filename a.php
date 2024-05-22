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
  <link href="style.css" rel="stylesheet">
  
  <style>

    
  </style>
</head>
<body>
<main class="tablee" id="customers_table">
        <section class="table__header">
            <h1>Tous Les Demandes</h1>
            <div class="input-groupe">
                <input type="search" placeholder="Search Data...">
                <img src="search.png" alt="">
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Tel</th>
                        <th>Email</th>
                        <th>Ville</th>
                        <th>Branche</th>
                        <th>Date</th>
                        <th>Date de Naissance</th>
                        <th>Date Debut</th>
                        <th>Date Fin</th>
                        <th>Diplome</th>
                        <th>Demande</th>
                        <th>CV</th>
                        <th>Assurance</th>
                        <th>Actions</th>
                        
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
        </section>
    </main>
    <script src="script.js"></script>
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
