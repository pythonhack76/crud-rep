<?php 


$client_id = '';
$client_secret = '';
$redirect_uri = '';


define("CALLBACK_URL", "http://localhost/oauth2client.php");
define("AUTH_URL", "https://example.com/oauth2/authorize");
define("ACCESS_TOKEN_URL", "https://example/oauth2/token");
define("CLIENT_ID", "1yLCsmAfDF49nGmJLgDbHvB6bSca");
define("CLIENT_SECRET", "g2OKQ9isj2pcaextQdjx5xW3KoAa");
define("SCOPE", ""); // optional

$url = AUTH_URL."?"
   ."response_type=code"
   ."&client_id=". urlencode(CLIENT_ID)
   ."&scope=". urlencode(SCOPE)
   ."&redirect_uri=". urlencode(CALLBACK_URL)
;





?>


