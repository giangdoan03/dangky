<?php
$endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
$partnerCode = "MOMOXXXX";
$accessKey = "XXXXXXXXXX";
$secretKey = "XXXXXXXXXX";

$orderId = $_POST['orderId'];
$amount = $_POST['amount'];
$orderInfo = "Payment for order: $orderId";
$returnUrl = "http://your-website.com/return.php";
$notifyUrl = "http://your-website.com/notify.php";

// Tạo chữ ký
$requestId = time() . "";
$requestType = "captureMoMoWallet";
$extraData = "";

$rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyUrl . "&extraData=" . $extraData;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

$data = array(
    'partnerCode' => $partnerCode,
    'accessKey' => $accessKey,
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'returnUrl' => $returnUrl,
    'notifyUrl' => $notifyUrl,
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

$result = sendRequestToMoMo($endpoint, $data);
$jsonResult = json_decode($result, true);

header('Location: ' . $jsonResult['payUrl']);
exit();

function sendRequestToMoMo($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

?>
