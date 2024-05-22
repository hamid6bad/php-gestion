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
        $date = date("Y-m-d", strtotime($row["datee"]));
        $nom = $row["nom"];
        $prenom = $row["prenom"];
        $branche = $row["branche"];
        $ville = $row["ville"];
        $dateDebut = date("Y-m-d", strtotime($row["datedebut"]));
        $dateFin = date("Y-m-d", strtotime($row["datefin"]));
    }
} else {
    echo "0 results";
}

// Close database connection
$conn->close();

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
<div class='header'>
    <h1 style='text-align: right;'>Accord de Stage</h1>
    <br>
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
</div>
";

// Write content to the PDF
$pdf->writeHTML($content, true, false, true, false, '');

// Specify the path where the PDF file should be saved
$pdfFilePath = __DIR__ . '/generated_word_files/accord_stage'.$id.'.pdf';

// Save PDF to specified path
$pdf->Output($pdfFilePath, 'D');


?>
