<?php
$token = "TOKEN";
$useremail = "USER_EMAIL";
$ID = "USER_ID"; 
$data = "<atom:entry xmlns:atom=\"http://www.w3.org/2005/Atom\"\r\n    xmlns:gd=\"http://schemas.google.com/g/2005\">\r\n  <atom:category scheme=\"http://schemas.google.com/g/2005#kind\"\r\n    term=\"http://schemas.google.com/contact/2008#contact\"/>\r\n  <gd:name>\r\n     <gd:givenName>Elizabeth</gd:givenName>\r\n     <gd:familyName>Bennet</gd:familyName>\r\n     <gd:fullName>Elizabeth Bennet</gd:fullName>\r\n  </gd:name>\r\n  <atom:content type=\"text\">Notes</atom:content>\r\n  <gd:email rel=\"http://schemas.google.com/g/2005#work\"\r\n    primary=\"true\"\r\n    address=\"liz@gmail.com\" displayName=\"E. Bennet\"/>\r\n  <gd:email rel=\"http://schemas.google.com/g/2005#home\"\r\n    address=\"liz@example.org\"/>\r\n  <gd:phoneNumber rel=\"http://schemas.google.com/g/2005#work\"\r\n    primary=\"true\">\r\n    (206)555-1212\r\n  </gd:phoneNumber>\r\n  <gd:phoneNumber rel=\"http://schemas.google.com/g/2005#home\">\r\n    (206)555-1213\r\n  </gd:phoneNumber>\r\n  <gd:im address=\"liz@gmail.com\"\r\n    protocol=\"http://schemas.google.com/g/2005#GOOGLE_TALK\"\r\n    primary=\"true\"\r\n    rel=\"http://schemas.google.com/g/2005#home\"/>\r\n  <gd:structuredPostalAddress\r\n      rel=\"http://schemas.google.com/g/2005#work\"\r\n      primary=\"true\">\r\n    <gd:city>Mountain View</gd:city>\r\n    <gd:street>1600 Amphitheatre Pkwy</gd:street>\r\n    <gd:region>CA</gd:region>\r\n    <gd:postcode>94043</gd:postcode>\r\n    <gd:country>United States</gd:country>\r\n    <gd:formattedAddress>\r\n      1600 Amphitheatre Pkwy Mountain View\r\n    </gd:formattedAddress>\r\n  </gd:structuredPostalAddress>\r\n</atom:entry>";
getAllContacts($useremail, $token);
getContact($useremail, $token, $ID);
createContact($useremail, $token, $data);

refreshToken("REFRESH_TOKEN", "CLIENT_ID", "CLIENT_SECRET");

//Function to Get Contacts
function getAllContacts($useremail, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.google.com/m8/feeds/contacts/{$useremail}/full?max-results=10000000",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache",
      "GData-Version: 3.0",
      "Authorization: Bearer {$token}"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}

// Function to get a Single Contact By it's ID
function getContact($useremail, $token, $ID)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.google.com/m8/feeds/contacts/{$useremail}/full/{$ID}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache",
      "GData-Version: 3.0",
      "Authorization: Bearer {$token}"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}

//Function to Create a New Contact
function createContact($useremail, $token, $data)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.google.com/m8/feeds/contacts/{$useremail}/full",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{$data}",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer {$token}",
      "Cache-Control: no-cache",
      "Content-Type: application/atom+xml",
      "GData-Version: 3.0"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}


//Function to Get User Information
function getUserInfo($token)
{
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.googleapis.com/oauth2/v1/userinfo?alt=json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer {$token}",
    "Cache-Control: no-cache",
    "Content-Type: application/atom+xml",
    "GData-Version: 3.0"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}

//Function to Refresh A Token
function refreshToken($refresh_token, $client_id, $client_secret) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.googleapis.com/oauth2/v4/token?refresh_token={$refresh_token}&client_id={$client_id}&client_secret={$client_secret}&grant_type=refresh_token",
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
      return $err;
  } else {
    $data = json_decode($response);
    return $data->access_token;
  }
}