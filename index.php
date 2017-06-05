<?php
if (! function_exists ( 'curl_version' )) {
    exit ( "Enable cURL in PHP" );
}
$ch = curl_init ();
$timeout = 0; // 100; // set to zero for no timeout
if(isset($_GET["name"])) {
	$myHITurl = "https://restcountries.eu/rest/v2/name/".$_GET["name"];
}
else if(isset($_GET["fullName"])){
	$myHITurl = "https://restcountries.eu/rest/v2/name/".$_GET["fullName"]."?fullText=true";
}
else if(isset($_GET["code"])){	
	$myHITurl = "https://restcountries.eu/rest/v2/alpha/".$_GET["code"];
}
else{
	exit();
}
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ( $ch, CURLOPT_URL, $myHITurl );
curl_setopt ( $ch, CURLOPT_HEADER, 0 );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
$file_contents = curl_exec ( $ch );
if (curl_errno ( $ch )) {
    echo curl_error ( $ch );
    curl_close ( $ch );
    exit ();
}
echo $file_contents;
curl_close ( $ch );
?>