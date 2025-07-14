<?php
// Path to the PDF file
$pdfFile = 'C:\xampp\htdocs\dbms\reportdbms.pdf';

// Check if the file exists
if (!file_exists($pdfFile)) {
    die('File not found');
}

// Set headers to display the PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($pdfFile) . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');

// Read the file and output its content
@readfile($pdfFile);
?>
