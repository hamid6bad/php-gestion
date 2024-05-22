<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion";
require 'vendor/autoload.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID and additionalInfo are received
if(isset($_POST['id']) && isset($_POST['additionalInfo'])) {
    $id = $_POST['id'];
    $additionalInfo = $_POST['additionalInfo'];

    // SQL query to delete entry
    $sql_delete = "DELETE FROM stagiaire WHERE id = $id";

    // SQL query to fetch recipient email address
    $sql_email = "SELECT email FROM stagiaire WHERE id = $id";
    $result_email = $conn->query($sql_email);
    if ($result_email->num_rows > 0) {
        $row = $result_email->fetch_assoc();
        $recipientEmail = $row['email'];
    } else {
        echo "Error fetching recipient email address";
        exit; // Exit script if recipient email address not found
    }

    if ($conn->query($sql_delete) === TRUE) {
        echo "Entry deleted successfully";

        // Send email with additional information
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'hamid6abdou@gmail.com';                // SMTP username
            $mail->Password   = 'nzeewxxxiukbvyoy    ';                 // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('ONEE@gmail.com', 'ONEE');
            $mail->addAddress($recipientEmail);                        // Add the recipient email address

            // Content
            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = 'Reponse à votre candidature pour le stage';
            $mail->Body    = "<h2>Cher/Chère $nom $prenom</h2><br>
            <h4>Je vous remercie vivement pour l'intérêt que vous avez manifesté envers le stage proposé au sein de ONEE.<br>
            Nous avons examiné attentivement votre candidature et vos qualifications, et nous vous en sommes reconnaissants.
            C'est avec regret que nous devons vous informer que, après une évaluation minutieuse de toutes les candidatures reçues, nous avons décidé de poursuivre avec d'autres candidats pour le poste de stagiaire. La décision a été difficile à prendre compte tenu du nombre élevé de candidatures compétentes que nous avons reçues.
            Nous tenons à vous assurer que votre candidature a été prise en considération avec sérieux et respect. Vos qualifications et votre expérience sont indéniables, mais malheureusement, nous avons dû faire un choix final.<br>'<h4>$additionalInfo</h4>";  // Add additional info to the body

            // Send email
            $mail->send();
            echo $filename;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error deleting entry: " . $conn->error;
    }
} else {
    echo "ID or additionalInfo not received";
}

// Close connection
$conn->close();
?>
