<?php
$headers = ['Content-type: application/json'];

$query = http_build_query(array('limit' => 15, 'offset' => 0));


$ch = curl_init("http://library.local/members?{$query}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,value: 1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);
echo $response;

echo "\n";



$body = json_encode(array('name' => 'Lola Indigo', 'email' => 'lola.indigo@gmail.com', 'state' => 0));
$ch = curl_init('http://library.local/register');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT,1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);
curl_close($ch);
echo $response;


$body = json_encode(array('email' => 'lola.indigo@gmail.com', 'state' => 1));
$ch = curl_init('http://library.local/state');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT,1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);
curl_close($ch);
echo $response;



