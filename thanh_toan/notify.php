<?php
$secretKey = "XXXXXXXXXX";

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$partnerCode = $data['partnerCode'];
$accessKey = $data['accessKey'];
$requestId = $data['requestId'];
$amount = $data['amount'];
$orderId = $data['orderId'];
$orderInfo = $data['orderInfo'];
$orderType = $data['orderType'];
$transId = $data['transId'];
$resultCode = $data['resultCode'];
$payType = $data['payType'];
$responseTime = $data['responseTime'];
$extraData = $data['extraData'];
$signature = $data['signature'];

$rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&orderType=" . $orderType . "&transId=" . $transId . "&resultCode=" . $resultCode . "&payType=" . $payType . "&responseTime=" . $responseTime . "&extraData=" . $extraData;
$signatureCheck = hash_hmac("sha256", $rawHash, $secretKey);

if ($signature === $signatureCheck) {
    if ($resultCode == '0') {
        // Xử lý đơn hàng thành công
    } else {
        // Xử lý đơn hàng thất bại
    }
}
?>
