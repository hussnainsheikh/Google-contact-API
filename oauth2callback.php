<?php

$file = file_get_contents('./client_secrets.json'); //Client Secrets file
$data = json_decode($file);
$client_id = $data->web->client_id;
$redirect_uri = $data->web->redirect_uris[0];
$client_secret = $data->web->client_secret;
$code = $_GET['code'];
if (isset($_GET['code'])) {

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://www.googleapis.com/oauth2/v4/token?code={$code}&client_id={$client_id}&client_secret={$client_secret}&redirect_uri={$redirect_uri}&access_type=offline&grant_type=authorization_code",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
	    'Content-length: 0',
	    "Content-Type: application/x-www-form-urlencoded"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		var_dump($response);
		$data = json_decode($response);
		echo "access_token: " .$data->access_token;
		if ($data->refresh_token) {
			echo "<br>refresh_token: " .$data->refresh_token;
		}
	}
}