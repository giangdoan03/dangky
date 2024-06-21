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

        $mail->setFrom($username, 'Tuyển sinh THCS Thanh Xuân');
        $mail->isHTML(true);

        foreach ($recipientsBatch as $recipient) {
            if (filter_var($recipient['email'], FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($recipient['email']);
                $mail->Subject = $subject;

                $body = replacePlaceholders($template, [
                    'ho_ten_dem' => $recipient['ho_ten_dem'],
                    'ten' => $recipient['ten'],
                    'ngay_sinh' => $recipient['ngay_sinh'],
                    'so_bao_danh' => $recipient['so_bao_danh'],
                    'tong_diem' => $recipient['tong_diem'],
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

    $template = "<table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff\">
    <tbody><tr>
        <td align=\"center\" style=\"padding:0\">
            <table role=\"presentation\" style=\"width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left\">
                <tbody><tr>
                    <td align=\"center\">
                        <img src=\"https://taophieu.thcsthanhxuan.vn/bg_banner_tx.png\" alt=\"\" width=\"300\" style=\"height:auto;display:block;width:100%\" class=\"CToWUd\" data-bit=\"iit\">
                    </td>
                </tr>
                <tr>
                    <td style=\"padding:36px 30px 42px 30px\">
                        <table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0\">
                            <tbody><tr>
                                <td colspan=\"2\" style=\"padding:0;color:#153643\"><span class=\"im\">
										<h1 style=\"font-size:18px;margin:0;font-family:Arial,sans-serif;text-align:center;margin-bottom:20px\">THÔNG BÁO TRÚNG TUYỂN BỔ SUNG VÀO LỚP 6
NĂM HỌC 2024-2025
</h1>
										</span><p style=\"margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif\">Hội đồng tuyển sinh Trường THCS CLC Thanh Xuân chúc mừng em: <br> {{ho_ten_dem}} {{ten}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td><p style=\"margin:0;font-family:Arial,sans-serif;line-height:25px;\">Ngày sinh: {{ngay_sinh}}</p></td>
                                <td><p style=\"margin:0;font-family:Arial,sans-serif;line-height:25px;\">Số báo danh: {{so_bao_danh}}</p></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\"><p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>Đã trúng tuyển bổ sung vào lớp 6 năm học 2024-2025 với tổng điểm: {{tong_diem}}</strong></p></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\">
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>2.1 Thời gian nộp hồ sơ nhập học:</strong></p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\">CMHS làm thủ tục nhập học từ ngày 22/6/2024 đến hết ngày 23/6/2024, theo thời gian cụ thể như sau: </p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\">+ Buổi sáng: từ 7h30 đến 11h00; </p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\">+ Buổi chiều: từ 14h00 đến 17h00.</p>

                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>2.2. Địa điểm làm thủ tục nhập học</strong></p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\">Tại văn phòng - Trường THCS Thanh Xuân, địa chỉ: 143 Nguyễn Tuân – Thanh Xuân Trung – Thanh Xuân - Hà Nội. </p>

                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\">Hồ sơ nhập học bao gồm:</p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>+ Bản chính học bạ cấp Tiểu học.</strong></p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>Phiếu kê khai thông tin học sinh (theo mẫu của nhà trường) kèm theo minh chứng về nơi thường trú (Căn cước công dân, truy cập định danh điện tử VNeID mức 2 của Bố (mẹ) hoặc người giám hộ học sinh đăng ký tuyển sinh hoặc giấy xác nhận thường trú do cơ quan có thẩm quyền cấp để đối chiếu)</strong></p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>+ Bản sao giấy khai sinh</strong></p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;\"><strong>+ Bản chính giấy xác nhận ưu tiên do cơ quan có thẩm quyền cấp (nếu có)
                                        (Trong trường hợp hồ sơ nhập học không khớp với Hồ sơ dự tuyển và không đúng với các quy định trong kế hoạch tuyển sinh của nhà trường kết quả trúng tuyển sẽ bị hủy)
                                    </strong></p>
                                    <p style=\"margin:0;line-height:25px;font-family:Arial,sans-serif;font-style: italic;\"><strong>* Lưu ý: </strong> Sau thời gian trên nếu cha mẹ học sinh không đến làm thủ tục nhập học cho con thì coi như học sinh không có nhu cầu học tại trường THCS Thanh Xuân  năm học 2024 - 2025.</p>

                                </td>
                            </tr>
                            <tr>
                                <td colspan=\"2\"><p style=\"margin:0;font-family:Arial,sans-serif;\"><strong>Mẫu phiếu kê khai thông tin học sinh: <a href=\"https://taophieu.thcsthanhxuan.vn/Mẫu%20Phiếu%20kê%20khai%20thông%20tin%20học%20sinh.docx\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q=https://taophieu.thcsthanhxuan.vn/M%E1%BA%ABu%2520Phi%E1%BA%BFu%2520k%C3%AA%2520khai%2520th%C3%B4ng%2520tin%2520h%E1%BB%8Dc%2520sinh.docx&amp;source=gmail&amp;ust=1719051814648000&amp;usg=AOvVaw1aaScdUdc9_0cooGLaPJ5s\">Tải file mẫu</a><u></u></strong></p></td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                <tr>
                    <td style=\"padding:30px;background:#028900\">
                        <table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif\">
                            <tbody><tr>
                                <td style=\"padding:0;width:100%\" align=\"left\">
                                    <p style=\"margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;text-align:center\">
                                        Copyright 2024 © Bản quyền thuộc về Trường THCS Thanh Xuân
                                    </p>
                                </td>
                                <td style=\"padding:0;width:50%\" align=\"right\">
                                    <table role=\"presentation\" style=\"border-collapse:collapse;border:0;border-spacing:0\">
                                        <tbody><tr>
                                            <td style=\"padding:0 0 0 10px;width:38px\">
                                                <a href=\"https://www.facebook.com/thcsthanhxuan.edu.vn/\" style=\"color:#ffffff\" target=\"_blank\" data-saferedirecturl=\"https://www.google.com/url?q=https://www.facebook.com/thcsthanhxuan.edu.vn/&amp;source=gmail&amp;ust=1719051814648000&amp;usg=AOvVaw344r9LoAXGwlQ-Q-Zvt39_\"><img src=\"https://ci3.googleusercontent.com/meips/ADKq_NYE6ehvLSaI3LhYle3bpa95n4cYbycsXcaPrTjNxX5lPAFaX5NBa84IiG3sv_JNSpwhkOr9oqa7mSufIjxn4Q=s0-d-e1-ft#https://assets.codepen.io/210284/fb_1.png\" alt=\"Facebook\" width=\"38\" style=\"height:auto;display:block;border:0\" class=\"CToWUd\" data-bit=\"iit\"></a>
                                            </td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    </tbody></table>";
    $subject = "Thông báo trúng tuyển";

    $response = sendBulkEmail($data, $template, $subject);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
