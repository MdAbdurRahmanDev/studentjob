<?php

$url = 'https://www.24bulksmsbd.com/api/smsSendApi'; 
$mobile_no = '01737651993';
$message = 'Hello, this is a test SMS from the system.';

$data = array(
    'customer_id' => 1597,
    'api_key' => '79cd045232d86db8f9dda04e9a374dd6adad435ee2c8d',
    'message' => $message,
    'mobile_no' => $mobile_no
);

echo "Sending single SMS to: $mobile_no...\n";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
$output = curl_exec($curl);
curl_close($curl);

echo "Response from API:\n";
var_dump($output);

echo "\n\nNow testing Dynamic SMS API...\n";
$url2 = 'https://www.24bulksmsbd.com/api/DynamicSMSApi';
$data2 = array(
    'customer_id' => 1597,
    'api_key' => '79cd045232d86db8f9dda04e9a374dd6adad435ee2c8d',
    'message' => json_encode([
        [
            "to" => "8801737651993",
            "message" => "Test Dynamic SMS"
        ]
    ]),
);

$curl2 = curl_init($url2);
curl_setopt($curl2, CURLOPT_POST, true);
curl_setopt($curl2, CURLOPT_POSTFIELDS, $data2);
curl_setopt($curl2, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
$output2 = curl_exec($curl2);
curl_close($curl2);

echo "Response from Dynamic API:\n";
var_dump($output2);
