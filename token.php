<?php 

function getToken(){
  $curl = curl_init();
 
  $params = array(
    CURLOPT_URL =>  ACCESS_TOKEN_URL."?"
    				."code=".$code
    				."&grant_type=authorization_code"
    				."&client_id=". CLIENT_ID
    				."&client_secret=". CLIENT_SECRET
    				."&redirect_uri=". CALLBACK_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_NOBODY => false, 
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: application/x-www-form-urlencoded",
      "accept: *",
      "accept-encoding: gzip, deflate",
    ),
  );
 
  curl_setopt_array($curl, $params);
 
  $response = curl_exec($curl);
  $err = curl_error($curl);
 
  curl_close($curl);
 
  if ($err) {
    echo "cURL Error #01: " . $err;
  } else {
    $response = json_decode($response, true);    
    if(array_key_exists("access_token", $response)) return $response;
    if(array_key_exists("error", $response)) echo $response["error_description"];
    echo "cURL Error #02: Something went wrong! Please contact admin.";
  }
}

?>