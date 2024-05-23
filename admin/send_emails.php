<?php

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendBulkEmail($recipientsBatch) {
    // Gmail SMTP server settings
    $host = 'smtp.gmail.com';
    $username = 'doangiang665@gmail.com';
    $password = 'xalylvkteybtywgj';
    $port = 587;

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;

        $mail->CharSet = 'UTF-8'; // Đặt mã hóa UTF-8

        // Common email settings
        $mail->setFrom($username, 'Tuyển sinh THCS Thanh Xuân');
        $mail->isHTML(true);

        foreach ($recipientsBatch as $recipient) {
            $mail->addAddress($recipient['email']);
            $mail->Subject = $recipient['subject'];
            $mail->Body = $recipient['body'];
            $mail->send();
            $mail->clearAddresses();  // Clear all addresses for the next iteration
        }

        echo "Batch of emails has been sent successfully!";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function getRecipientsFromCsv($filePath) {
    $recipients = [];
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $header = fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $recipients[] = [
                'email' => $data[0],
                'subject' => $data[1],
                'body' => $data[2]
            ];
        }
        fclose($handle);
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
        $recipients = getRecipientsFromCsv($dest_path);

        // Split the recipients array into batches of 100
        $batches = array_chunk($recipients, 100);

        foreach ($batches as $batch) {
            sendBulkEmail($batch);
            // Wait for a while to avoid hitting the rate limit
            sleep(2);  // Sleep for 2 seconds
        }
    } else {
        echo "There was an error moving the uploaded file.\n";
    }
}
?>
