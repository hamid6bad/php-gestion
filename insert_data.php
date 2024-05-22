<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$dbname = "gestion";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind the SQL statement for inserting form data
$stmt = $conn->prepare("INSERT INTO stagiaire (nom, prenom, telephone, email, ville, branche, datedenaissance) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $nom, $prenom, $telephone, $email, $ville, $branche, $datedenaissance);

// Set parameters for form data
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$ville = $_POST['ville'];
$branche = $_POST['branche'];
$datedenaissance = $_POST['datedenaissance'];

// Execute the form data insertion
if (!$stmt->execute()) {
    echo "Error: " . $stmt->error;
    $stmt->close();
    $conn->close();
    exit();
}

// Get the ID of the last inserted row
$last_id = $conn->insert_id;

// File upload directory
$target_dir = "uploads/";

// Handle file uploads
$diplome = uploadFile('diplome', $target_dir);
$demande = uploadFile('demande', $target_dir);
$cv = uploadFile('cv', $target_dir);
$assurance = uploadFile('assurance', $target_dir);

// Prepare and bind the SQL statement for inserting file paths into the database
$stmt_file = $conn->prepare("UPDATE stagiaire SET diplome=?, demande=?, cv=?, assurance=? WHERE id=?");
$stmt_file->bind_param("ssssi", $diplome_path, $demande_path, $cv_path, $assurance_path, $last_id);

// Set parameters for file paths
$diplome_path = $target_dir . $diplome;
$demande_path = $target_dir . $demande;
$cv_path = $target_dir . $cv;
$assurance_path = $target_dir . $assurance;

// Execute the file path insertion
if (!$stmt_file->execute()) {
    echo "Error: " . $stmt_file->error;
}

// Close statements and connection
$stmt->close();
$stmt_file->close();
$conn->close();

// Function to handle file uploads
function uploadFile($file_input_name, $target_dir) {
    $target_file = $target_dir . basename($_FILES[$file_input_name]["name"]);
    if (move_uploaded_file($_FILES[$file_input_name]["tmp_name"], $target_file)) {
        return basename($_FILES[$file_input_name]["name"]);
    } else {
        echo "Error uploading file.";
        exit();
    }
}
?>
