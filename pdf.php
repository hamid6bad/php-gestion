<?php
require_once 'vendor/autoload.php'; // Load TCPDF library

// Include the TCPDF library


// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Add a page
$pdf->AddPage();

// Set some content to the PDF
$pdf->SetFont('Helvetica', '', 12);
$pdf->Write(0, 'Hello, world! This is a PDF generated using TCPDF.');

// Determine the absolute path to the directory where you want to save the PDF file
$outputDirectory = __DIR__ . '/pdf/';
// Create the directory if it doesn't exist
if (!file_exists($outputDirectory)) {
    mkdir($outputDirectory, 0777, true);
}

// Set the output file path (absolute path)
$outputFilePath = $outputDirectory . 'file.pdf';

// Save the PDF file without opening it
$pdf->Output($outputFilePath, 'F');

// Output a success message
echo 'PDF file saved successfully at: ' . $outputFilePath;
?>
