<?php

require '../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\IOFactory;



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
        $recipients = getRecipientsFromExcel($dest_path);

        $batches = array_chunk($recipients, 50); // Giảm số lượng mỗi batch để tránh quá tải

        echo json_encode(['status' => 'success', 'batches' => $batches]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'There was an error moving the uploaded file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
