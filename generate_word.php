<?php
// Database connection parameters
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

// Retrieve data from the database based on the received ID
$id = $_POST['id'];
$sql = "SELECT * FROM stagiaire WHERE id = $id";
$result = $conn->query($sql);

// Load TCPDF library
require_once 'vendor/autoload.php';

// Initialize recipient email variable
$recipientEmail = '';

// Check if data is found
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Store recipient email address
        $recipientEmail = $row["email"];
        $date = $row["datee"];
        $nom = $row["nom"];
        $prenom = $row["prenom"];
        $branche = $row["branche"];
        $ville = $row["ville"];
        $dateDebut = $row["datedebut"];
        $dateFin = $row["datefin"];
    }
} else {
    echo "0 results";
}

// Create new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Accord de stage');
$pdf->SetSubject('Accord de stage');
$pdf->SetKeywords('Accord, stage');

// Set default font
$pdf->SetFont('helvetica', '', 16);

// Add a page
$pdf->AddPage();

// Set some content with styling
$content = "
<h1 style='text-align: right;'>Accord de Stage</h1><br>
<div class='header'>
    N: <br>
    Khenifra le: <br>
    M. $nom $prenom<br>
    Branche: $branche<br>
    Ville: $ville<br>
    <br>
    Objet: Accord de stage.<br>
    Réf: V. Demande parvenue $date<br>
</div>

<div class='content'>
    J'ai l'honneur de vous confirmer mon accord pour l'organisation d'un stage pratique au Service Commercial et Gestion Khénifra et ce, durant la période allant du $dateDebut au $dateFin.<br>Je vous signale que vous êtes tenu de justifier une couverture d'assurance contre les risques et accidents individuels éventuels durant la période du stage et que le transport sera à votre charge. Par ailleurs, aucune indemnité de stage ne vous sera accordée. L'ONEE-Branche Eau. Veuillez agréer l'expression de mes salutations distinguées.
</div>";

// Write content to the PDF
$pdf->writeHTML($content, true, false, true, false, '');

// Close database connection
$conn->close();

// Specify the path where the PDF file should be saved
$pdfFilePath = __DIR__ . '/generated_word_files/accord_stage'.$id.'.pdf';

// Save PDF to specified path
$pdf->Output($pdfFilePath, 'F');

// Send email with PDF attachment
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hamid6abdou@gmail.com'; // Update with your Gmail address
    $mail->Password   = 'nzeewxxxiukbvyoy    '; // Update with your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('ONEE@gmail.com', 'ONEE');
    $mail->addAddress($recipientEmail);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Felicitations pour votre acceptation de stage';
    $mail->Body    = "<h2>Cher/Chère $nom $prenom</h2><br>
    <h4>Je suis ravi(e) de vous informer que vous avez été sélectionné(e) pour effectuer un stage au sein de ONEE.<br>
    Au nom de toute l'équipe, je tiens à vous adresser nos plus sincères félicitations pour cette réalisation exceptionnelle.
    Votre candidature a retenu toute notre attention en raison de votre parcours académique impressionnant, de vos compétences et de votre passion pour cellule informatique.<br>
    Nous sommes convaincus que votre intégration au sein de notre équipe apportera une valeur ajoutée significative à nos projets et initiatives.
    Votre acceptation pour ce stage témoigne de votre détermination, de votre engagement et de votre capacité à relever les défis avec succès. Nous sommes impatients de vous accueillir et de vous offrir une expérience enrichissante au sein de notre entreprise</h4>";

    // Attach PDF
    $mail->addAttachment($pdfFilePath, 'accord_stage'.$id.'.pdf');

    // Send email
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
