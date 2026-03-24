<?php

require 'vendor/autoload.php'; // Include Composer's autoloader

use Spatie\PdfMerger\PdfMerger;

// Create a PDF merger instance
$pdfMerger = new PdfMerger();

// Loop through uploaded files
foreach ($_FILES['files']['tmp_name'] as $tmpFile) {
    // Add each file to the PDF merger
    $pdfMerger->addPDF($tmpFile);
}

// Generate the output file name
$outputFileName = 'merged_file.pdf';

// Merge the PDFs and save the result to the output file
$pdfMerger->merge('file', $outputFileName);

// Output file path
$outputFilePath = __DIR__ . '/' . $outputFileName;

// Send the output file for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $outputFileName . '"');
readfile($outputFilePath);

// Clean up: delete the output file
unlink($outputFilePath);

?>
