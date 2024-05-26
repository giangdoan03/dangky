<?php

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function replacePlaceholders($template, $placeholders) {
    foreach ($placeholders as $key => $value) {
        $template = str_replace("{{" . $key . "}}", $value, $template);
    }
    return $template;
}

function sendEmail($recipient, $template, $subject) {
    $host = 'smtp.gmail.com';
    $username = 'tuyensinh@thcsthanhxuan.vn';
    $password = 'asuugexscxujsbds';
    $port = 587;

    $mail = new PHPMailer(true);
    $success = false; // Biến xác định email có được gửi thành công hay không

    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom($username, 'TEST GỬI MAIL TỰ ĐỘNG');
        $mail->isHTML(true);

        if (filter_var($recipient['email'], FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($recipient['email']);
            $mail->Subject = $subject;

            $body = replacePlaceholders($template, [
                'name' => $recipient['name'],
                'dob' => $recipient['dob'],
                'sbd' => $recipient['sbd'],
                'room' => $recipient['room'],
                'time' => $recipient['time'],
                'address' => $recipient['address']
            ]);

            $mail->Body = $body;
            if ($mail->send()) {
                $success = true; // Đánh dấu email đã được gửi thành công
            }
            $mail->clearAddresses();
        } else {
            return ['status' => 'error', 'message' => 'Invalid email address: ' . $recipient['email']];
        }

        if ($success) {
            return ['status' => 'success', 'message' => 'Email sent successfully to ' . $recipient['email'], 'email' => $recipient['email']];
        } else {
            return ['status' => 'error', 'message' => 'Email could not be sent to ' . $recipient['email']];
        }
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $template = "
    <p>Kính gửi quý cha mẹ học sinh em <strong>{{name}}</strong> ngày sinh <span>{{dob}}</span>.</p>
    <p>Hội đồng tuyển sinh lớp 6 trường THCS Thanh Xuân năm học 2024-2025</p>
    <p>Thông báo:</p>
    <p>Số báo danh: <strong>{{sbd}}</strong></p>
    <p>Phòng kiểm tra: <strong>{{room}}</strong></p>
    <p>Thời gian có mặt tại địa điểm kiểm tra: <strong>{{time}}</strong></p>
    <p>Địa điểm kiểm tra: <strong>{{address}}</strong></p>
    <p>Trân trọng!</p>
    ";
    $subject = "Thông báo SBD- Thời Gian - Địa điểm dự kiểm tra";

    $response = sendEmail($data, $template, $subject);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
