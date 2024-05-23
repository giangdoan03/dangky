<?php
require '../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;



function replacePlaceholders($template, $placeholders) {
    foreach ($placeholders as $key => $value) {
        $template = str_replace("{{" . $key . "}}", $value, $template);
    }
    return $template;
}

function sendBulkEmail($recipientsBatch, $template, $subject) {
    $host = 'smtp.gmail.com';
    $username = 'doangiang665@gmail.com';
    $password = 'xalylvkteybtywgj';
    $port = 587;

    $mail = new PHPMailer(true);

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
                $mail->send();
                $mail->clearAddresses();
            } else {
                echo "Invalid email address: {$recipient['email']}\n";
            }
        }

        echo "Batch of emails has been sent successfully!";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function getRecipientsFromExcel($filePath) {
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    $recipients = [];
    $header = array_shift($rows);

    foreach ($rows as $row) {
        $recipient = array_combine($header, $row);
        $recipients[] = [
            'email' => $recipient['email'],
            'name' => $recipient['name'],
            'dob' => $recipient['dob'],
            'sbd' => $recipient['sbd'],
            'room' => $recipient['room'],
            'time' => $recipient['time'],
            'address' => $recipient['address']
        ];
    }

    return $recipients;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $uploadFileDir = './uploads/';
    $dest_path = $uploadFileDir . $fileName;

    if (!file_exists($uploadFileDir)) {
        mkdir($uploadFileDir, 0777, true);
    }

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        echo "File is successfully uploaded.\n";
        $recipients = getRecipientsFromExcel($dest_path);

        $batches = array_chunk($recipients, 100);
        $template = "
        <p>Kính gửi quý cha mẹ học sinh em <strong style='color:red'>{{name}}</strong> ngày sinh <span style='color:red'>{{dob}}</span>.</p>
        <p>Hội đồng tuyển sinh lớp 6 trường THCS Thanh Xuân năm học 2024-2025</p>
        <p>Thông báo:</p>
        <p>Số báo danh: <strong style='color:red'>{{sbd}}</strong></p>
        <p>Phòng kiểm tra: <strong style='color:red'>{{room}}</strong></p>
        <p>Địa điểm kiểm tra: <strong style='color:red'>Trường THCS Thanh Xuân</strong></p>
        <p><strong style='color:red'>{{address}}</strong></p>
        <p>Thời gian có mặt tại địa điểm kiểm tra: <strong style='color:red'>{{time}}</strong></p>
        <p>Trân trọng!</p>
        ";
        $subject = "TEST GỬI MAIL TỰ ĐỘNG";

        foreach ($batches as $batch) {
            sendBulkEmail($batch, $template, $subject);
            sleep(2);
        }
    } else {
        echo "There was an error moving the uploaded file.\n";
    }
}


?>
