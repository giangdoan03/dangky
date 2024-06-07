<?php
$secretKey = "XXXXXXXXXX";

$orderId = $_GET['orderId'];
$requestId = $_GET['requestId'];
$amount = $_GET['amount'];
$orderInfo = $_GET['orderInfo'];
$orderType = $_GET['orderType'];
$transId = $_GET['transId'];
$resultCode = $_GET['resultCode'];
$payType = $_GET['payType'];
$responseTime = $_GET['responseTime'];
$extraData = $_GET['extraData'];
$signature = $_GET['signature'];

$rawHash = "partnerCode=" . $_GET['partnerCode'] . "&accessKey=" . $_GET['accessKey'] . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&orderType=" . $orderType . "&transId=" . $transId . "&resultCode=" . $resultCode . "&payType=" . $payType . "&responseTime=" . $responseTime . "&extraData=" . $extraData;
$signatureCheck = hash_hmac("sha256", $rawHash, $secretKey);

if ($signature === $signatureCheck) {
    if ($resultCode == '0') {
        echo "Payment successful!";
    } else {
        echo "Payment failed!";
    }
} else {
    echo "Invalid signature!";
}
?>
