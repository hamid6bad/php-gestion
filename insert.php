<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $stmt = $conn->prepare("INSERT INTO stagiaire (nom, prenom, telephone, email, ville, branche,datee, datedenaissance,datedebut,datefin, diplome, demande, cv, assurance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $nom, $prenom, $telephone, $email, $ville, $branche,$date ,$datedenaissance,$datededebut,$datedefin ,$diplome, $demande, $cv, $assurance);

    // Set parameters for form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $ville = $_POST['ville'];
    $branche = $_POST['branche'];
    $date = $_POST['date'];
    $datedenaissance = $_POST['datedenaissance'];
    $datededebut = $_POST['datededebut'];
    $datedefin = $_POST['datedefin'];
    $diplome = $_FILES['diplome']['name'];
    $demande = $_FILES['demande']['name'];
    $cv = $_FILES['cv']['name'];
    $assurance = $_FILES['assurance']['name'];

    // Execute the form data insertion
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    } else {
        // Upload files
        $target_dir = "uploads/";
        move_uploaded_file($_FILES["diplome"]["tmp_name"], $target_dir . $diplome);
        move_uploaded_file($_FILES["demande"]["tmp_name"], $target_dir . $demande);
        move_uploaded_file($_FILES["cv"]["tmp_name"], $target_dir . $cv);
        move_uploaded_file($_FILES["assurance"]["tmp_name"], $target_dir . $assurance);
        
        // Close statement and connection
        $stmt->close();
        $conn->close();

        // Redirect to stagiaire.php with modal parameter
        header("Location: stagaire.php?status=success");
        exit();
    }
}
?>
