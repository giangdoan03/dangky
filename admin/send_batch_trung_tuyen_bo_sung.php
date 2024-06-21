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

    $template = "
       <table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;\">
		<tr>
			<td align=\"center\" style=\"padding:0;\">
				<table role=\"presentation\" style=\"width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;\">
					<tr>
						<td align=\"center\">
							<img src=\"https://taophieu.thcsthanhxuan.vn/bg_banner_tx.png\" alt=\"\" width=\"300\" style=\"height:auto;display:block;width: 100%;\" />
						</td>
					</tr>
					<tr>
						<td style=\"padding:36px 30px 42px 30px;\">
							<table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;\">
								<tr>
									<td colspan=\"2\" style=\"padding:0;color:#153643;\">
										<h1 style=\"font-size:18px;margin:0;font-family:Arial,sans-serif;text-align:center;margin-bottom: 20px;\">THÔNG BÁO ĐIỂM TUYỂN SINH BỔ SUNG VÀO LỚP 6 NĂM HỌC 2024-2025</h1>
										<p style=\"margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\">Hội đồng tuyển sinh Trường THCS CLC Thanh Xuân chúc mừng em: {{ho_ten_dem}} {{ten}}</p>
									</td>
								</tr>
                                <tr>
                                    <td><p style=\"margin: 0;\">Ngày sinh: {{ngay_sinh}}</p></td>
                                    <td><p style=\"margin: 0;\">Số báo danh: {{so_bao_danh}}</p></td>
                                </tr>
                                <tr>
                                    <td colspan=\"2\"><p style=\"margin: 0;\"><strong>Đã trúng tuyển vào lớp 6 năm học 2024-2025 với tổng điểm: {{tong_diem}}</strong></p></td>
                                </tr>
                                <tr>
                                    <td colspan=\"2\">
                                        <p style=\"margin: 0; line-height: 25px;\">Thời gian nộp hồ sơ nhập học:  <strong>ngày 19, 20/06/2024 (Sáng từ 7h30 đến 11h00, Chiều từ 14h00 đến 17h00)</strong></p>
                                        <p style=\"margin: 0; line-height: 25px;\">Hồ sơ nhập học bao gồm:</p>
                                        <p style=\"margin: 0; line-height: 25px;\"><strong>+ Bản chính học bạ cấp Tiểu học.</strong></p>
<p style=\"margin: 0; line-height: 25px;\"><strong>+ Phiếu kê khai thông tin học sinh (theo mẫu của nhà trường) kèm theo minh chứng về nơi thường trú (Căn cước công dân, truy cập định danh điện tử VNeID mức 2 của Bố (mẹ) hoặc người giám hộ học sinh đăng ký tuyển sinh hoặc giấy xác nhận thường trú do cơ quan có thẩm quyền cấp để đối chiếu)</strong></p>
<p style=\"margin: 0; line-height: 25px;\"><strong>+ Bản sao giấy khai sinh</strong></p>
<p style=\"margin: 0; line-height: 25px;\"><strong>+ Bản chính giấy xác nhận ưu tiên do cơ quan có thẩm quyền cấp (nếu có)</strong></p>
<p style=\"margin: 0; line-height: 25px;\"><strong>(Trong trường hợp hồ sơ nhập học không khớp với Hồ sơ dự tuyển và không đúng với các quy định trong kế hoạch tuyển sinh của nhà trường kết quả trúng tuyển sẽ bị hủy)</strong></p>

                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan=\"2\"><p style=\"margin: 0;\"><strong>Mẫu phiếu kê khai thông tin học sinh: <a href=\"https://taophieu.thcsthanhxuan.vn/Mẫu Phiếu kê khai thông tin học sinh.docx\" download>Tải file mẫu</a><span</strong></p></td>
                                </tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style=\"padding:30px;background:#028900;\">
							<table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;\">
								<tr>
									<td style=\"padding:0;width:100%;\" align=\"left\">
										<p style=\"margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;text-align: center\">
											Copyright 2024 © Bản quyền thuộc về Trường THCS Thanh Xuân
										</p>
									</td>
									<td style=\"padding:0;width:50%;\" align=\"right\">
										<table role=\"presentation\" style=\"border-collapse:collapse;border:0;border-spacing:0;\">
											<tr>
												<td style=\"padding:0 0 0 10px;width:38px;\">
													<a href=\"https://www.facebook.com/thcsthanhxuan.edu.vn/\" style=\"color:#ffffff;\"><img src=\"https://assets.codepen.io/210284/fb_1.png\" alt=\"Facebook\" width=\"38\" style=\"height:auto;display:block;border:0;\" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    ";
    $subject = "Thông báo trúng tuyển";

    $response = sendBulkEmail($data, $template, $subject);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
