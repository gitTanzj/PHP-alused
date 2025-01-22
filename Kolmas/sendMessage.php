<?php
include "db.php";
require "vendor/autoload.php";
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// $mail = new PHPMailer(true);

if (isset($_POST)) {
    header('Content-Type: application/json');
    $requestPayload = file_get_contents("php://input");
    $request = json_decode($requestPayload, true);

    if (!$request) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        exit;
    }

    $name = $request['name'] ?? '';
    $email = $request['email'] ?? '';
    $message = $request['message'] ?? '';

    if (empty($message)) {
        http_response_code(400);
        echo json_encode(["error" => "Message is required"]);
        exit;
    }

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Autor');
    $pdf->SetTitle('Joulutervitus');
    $pdf->SetSubject('Joulutervitamine');
    $pdf->SetKeywords('TCPDF, PDF');

    $pdf->SetHeaderData('', 0, 'Joulutervitus', 'Generated using TCPDF');

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    $pdf->SetMargins(15, 27, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);

    $pdf->SetAutoPageBreak(true, 25);

    $pdf->SetFont('helvetica', '', 12);

    $pdf->AddPage();

    $html = <<<EOD
    <h1 style="color: #2c3e50; text-align: center;">{$message}</h1>
    EOD;

    $pdf->writeHTML($html, true, false, true, false, '');

    $directory = __DIR__ . '/pdfs';

    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $uniqueFilename = uniqid('tervitus_', true) . '.pdf';
    $filePath = $directory . '/' . $uniqueFilename;
    $pdf->Output($filePath, 'F');

    echo json_encode([
        "success" => true,
        "message" => "PDF has been generated successfully",
        "filePath" => $filePath
    ]);
} 
?>