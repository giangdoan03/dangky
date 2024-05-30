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

function sendBulkEmail($recipientsBatch, $template, $subject) {
    $host = 'smtp.gmail.com';
    $username = 'tuyensinh@thcsthanhxuan.vn';
    $password = 'asuugexscxujsbds';
    $port = 587;

    $mail = new PHPMailer(true);
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $successCount = 0; // Biến đếm số lượng email gửi thành công
    $successfulRecipients = []; // Mảng lưu trữ các email đã gửi thành công
    $invalidEmails = []; // Mảng lưu trữ các email không hợp lệ

    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;

        $mail->CharSet = 'UTF-8'; // Đặt mã hóa UTF-8
        $mail->Encoding = 'base64'; // Hoặc đặt kiểu ký tự base64

        $mail->setFrom($username, 'TEST GỬI MAIL TỰ ĐỘNG');
        $mail->isHTML(true);

        foreach ($recipientsBatch as $recipient) {
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
                    $successCount++; // Tăng biến đếm nếu email gửi thành công
                    $successfulRecipients[] = $recipient['email']; // Thêm email vào mảng thành công
                    $mail->clearAddresses();
                }
            } else {
                $invalidEmails[] = $recipient['email']; // Thêm email không hợp lệ vào mảng
            }
        }

        return ['status' => 'success', 'message' => 'Batch of emails has been sent successfully!', 'successCount' => $successCount, 'successfulRecipients' => $successfulRecipients, 'invalidEmails' => $invalidEmails];
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}", 'successCount' => $successCount, 'successfulRecipients' => $successfulRecipients, 'invalidEmails' => $invalidEmails];
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
        <p>Địa điểm kiểm tra: <strong>{{address}}</strong></p>
        <p>Ngày kiểm tra: <strong>04/06/2024</strong></p>
        <p>Sáng kiểm tra môn Tiếng Việt, Tiếng Anh. Chiều kiểm tra môn Toán</p>
        <p>Thời gian có mặt tại địa điểm kiểm tra: <strong>{{time}}</strong></p>
        <p style='margin: 5px 0'><strong>Lưu ý: Thí sinh sẽ nhận phiếu dự kiểm tra tại phòng kiểm tra</strong></p>
        <p>Trân trọng!</p>
    ";
    $subject = "Thông báo SBD - Thời Gian - Địa điểm dự kiểm tra";

    $response = sendBulkEmail($data, $template, $subject);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
