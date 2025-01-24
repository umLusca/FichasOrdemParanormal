<?php


function sendSMS($to, $message, &$response)
{
	// Endpoint da API do Clickatell para envio de SMS
//	$ct = new Clickatell\Rest($_ENV['clickatell_api_key']);
	
	
	$data = array(
		'apiKey' => (string)$_ENV['clickatell_api_key'],
		'to' => (int)$to,
		'content' => (string)$message
	);
	
	
	$url = 'https://platform.clickatell.com/messages/http/send/?' . http_build_query($data);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	
	if ($data !== false) {
		$d = json_decode($data, true);
		$response = ["status" => $d && $d["responseCode"] >= 200 && $d["responseCode"] < 300 && $d["messages"][0]["accepted"], "response" => $d];
		return $response["status"];
		
	} else {
		$response = ["status" => false, "response" => [curl_error($ch), curl_errno($ch)]];
		return false;
	}
}



/*

function sendSMS(string $to, string $message, &$response): bool
{

    $twilio = new Client($_ENV["twillioSID"],$_ENV["twillioToken"]);

    $response = $twilio->messages->create($to, array('from' => "+12569524494", 'body' => $message));
    $response->sid;
    return $response->errorMessage === null;

}
*/