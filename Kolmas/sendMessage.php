<?php 
    include "db.php";
    require "vendor/autoload.php";
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\SMTP;
    // use PHPMailer\PHPMailer\Exception;

    // $mail = new PHPMailer(true);

    $requestPayload = file_get_contents("php://input");
    $request = json_decode($requestPayload, true);

    $name = $request['name'];
    $email = $request['email'];
    $message = $request['message'];


    if(!$request){
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        exit;
    }

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->AddPage();
    $pdf->SetFont('Bigelow Rules', '', 56);
    $pdf->Cell(0, 10, $message . ': ' . $name, 0, 1, 'C');

    $pdf->Output('./pdfs/' . $name . '.pdf', 'F');

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    // $mail->isSMTP();                                            //Send using SMTP
    // $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->Username   = 'kalleita22@ikt.khk.ee';                     //SMTP username
    // $mail->Password   = 'qwerty';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    // $mail->Port       = 465;   



    
    echo json_encode(["success" => "Request processed"]);
?>