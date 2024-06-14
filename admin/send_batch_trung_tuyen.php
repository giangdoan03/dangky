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
        <table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;\">
		<tr>
			<td align=\"center\" style=\"padding:0;\">
				<table role=\"presentation\" style=\"width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;\">
					<tr>
						<td align=\"center\" style=\"padding:40px 0 30px 0;background:#70bbd9;\">
							<img src=\"https://quantri.quangich.com/UploadImages/Config/thcsthanhxuan/Banner2.png\" alt=\"\" width=\"300\" style=\"height:auto;display:block;\" />
						</td>
					</tr>
					<tr>
						<td style=\"padding:36px 30px 42px 30px;\">
							<table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;\">
								<tr>
									<td style=\"padding:0 0 36px 0;color:#153643;\">
										<h1 style=\"font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;\">Creating Email Magic</h1>
										<p style=\"margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan et dictum, nisi libero ultricies ipsum, posuere neque at erat.</p>
										<p style=\"margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\"><a href=\"http://www.example.com\" style=\"color:#ee4c50;text-decoration:underline;\">In tempus felis blandit</a></p>
									</td>
								</tr>
								<tr>
									<td style=\"padding:0;\">
										<table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;\">
											<tr>
												<td style=\"width:260px;padding:0;vertical-align:top;color:#153643;\">
													<p style=\"margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\"><img src=\"https://assets.codepen.io/210284/left.gif\" alt=\"\" width=\"260\" style=\"height:auto;display:block;\" /></p>
													<p style=\"margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, est nisi libero ultricies ipsum, in posuere mauris neque at erat.</p>
													<p style=\"margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\"><a href=\"http://www.example.com\" style=\"color:#ee4c50;text-decoration:underline;\">Blandit ipsum volutpat sed</a></p>
												</td>
												<td style=\"width:20px;padding:0;font-size:0;line-height:0;\">&nbsp;</td>
												<td style=\"width:260px;padding:0;vertical-align:top;color:#153643;\">
													<p style=\"margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\"><img src=\"https://assets.codepen.io/210284/right.gif\" alt=\"\" width=\"260\" style=\"height:auto;display:block;\" /></p>
													<p style=\"margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\">Morbi porttitor, eget est accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed.</p>
													<p style=\"margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;\"><a href=\"http://www.example.com\" style=\"color:#ee4c50;text-decoration:underline;\">In tempus felis blandit</a></p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style=\"padding:30px;background:#ee4c50;\">
							<table role=\"presentation\" style=\"width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;\">
								<tr>
									<td style=\"padding:0;width:50%;\" align=\"left\">
										<p style=\"margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;\">
											&reg; Someone, Somewhere 2024<br/><a href=\"http://www.example.com\" style=\"color:#ffffff;text-decoration:underline;\">Unsubscribe</a>
										</p>
									</td>
									<td style=\"padding:0;width:50%;\" align=\"right\">
										<table role=\"presentation\" style=\"border-collapse:collapse;border:0;border-spacing:0;\">
											<tr>
												<td style=\"padding:0 0 0 10px;width:38px;\">
													<a href=\"http://www.twitter.com/\" style=\"color:#ffffff;\"><img src=\"https://assets.codepen.io/210284/tw_1.png\" alt=\"Twitter\" width=\"38\" style=\"height:auto;display:block;border:0;\" /></a>
												</td>
												<td style=\"padding:0 0 0 10px;width:38px;\">
													<a href=\"http://www.facebook.com/\" style=\"color:#ffffff;\"><img src=\"https://assets.codepen.io/210284/fb_1.png\" alt=\"Facebook\" width=\"38\" style=\"height:auto;display:block;border:0;\" /></a>
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
