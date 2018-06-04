<?php

$file = file_get_contents('./client_secrets.json'); //Client Secrets file
$data = json_decode($file);
$client_id = $data->web->client_id;
$scope = "https://www.googleapis.com/auth/userinfo.email&https://www.google.com/m8/feeds";
$redirect_uri = $data->web->redirect_uris[0];

$url = "https://accounts.google.com/o/oauth2/v2/auth?scope={$scope}&response_type=code&state=security_token&redirect_uri={$redirect_uri}&client_id={$client_id}&access_type=offline";
header("location: {$url}");