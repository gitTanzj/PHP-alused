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

    $check_stmt = $pdo->prepare('SELECT * FROM LOGS WHERE EMAIL = :email');
    $check_stmt->execute([
        ':email' => $email 
    ]);
    $check = $check_stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($check)) {
        $lastLogTime = strtotime($check['LOGTIME'] ?? '');
        $thirtyMinutesAgo = strtotime('-30 minutes');
        
        if($lastLogTime && $lastLogTime > $thirtyMinutesAgo) {
            http_response_code(400);
            echo json_encode(["error" => "Sellele tüübile saadeti kiri viimase 30 min sees. Oled kindel, et tahad uut saata?"]);
            exit;
        }
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
        <div>
            <p style="font-size: 48px;">$name saatis sulle kevadise tervituse!</p>
            <h1 style="font-size: 72px; color: green;">$message</h1>
        </div>
    EOD;

    $pdf->writeHTML($html, true, false, true, false, '');

    $directory = __DIR__ . '/pdfs';

    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $uniqueFilename = uniqid('tervitus_', true) . '.pdf';
    $filePath = $directory . '/' . $uniqueFilename;
    $pdf->Output($filePath, 'F');

    $count_stmt = $pdo->prepare('SELECT MAX(ID) as max_id FROM LOGS');
    $count_stmt->execute();
    $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
    $next_id = ($count['max_id'] ?? 0) + 1;

    $stmt = $pdo->prepare('INSERT INTO LOGS (ID, PDF, EMAIL, NAME, MESSAGE, LOGTIME) VALUES (:id, :pdf, :email, :name, :message, :logtime)');
    $stmt->execute([
        ':id' => $next_id,
        ':pdf' => $filePath,
        ':email' => $email,
        ':name' => $name,
        ':message' => $message,
        ':logtime' => date('Y-m-d H:i:s')
    ]);

    echo json_encode([
        "success" => true,
        "message" => "PDF has been generated successfully and logged",
        "filePath" => $filePath
    ]);
} 
?>