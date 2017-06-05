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
$file_contents = json_decode($file_contents, true);
//var_dump($file_contents);
if(isset($_GET["name"]) || isset($_GET["fullName"])){
	if(!array_key_exists("status",$file_contents)){
		$temp_region = array();
		$temp_subregion = array();
		$count = 0;
		for ($x=0; $x<50 && $x<count($file_contents); $x++){
			echo "Name: ".$file_contents[$x]["name"]."<br>";
			echo "Alpha 2 Code: ".$file_contents[$x]["alpha2Code"]."<br>";
			echo "Alpha 3 Code: ".$file_contents[$x]["alpha3Code"]."<br>";
			echo "Flag:<br><img src='" . $file_contents[$x]["flag"] . "' style='width:304px;height:228px;'>"."<br>";
			echo "Region: ".$file_contents[$x]["region"]."<br>";
			echo "Subregion: ".$file_contents[$x]["subregion"]."<br>";
			echo "List of Languages:<br>";
			for($y=0; $y<count($file_contents[$x]["languages"]); $y++){
				echo $file_contents[$x]["languages"][$y]["name"]."<br>";
			}
			echo "<br>";
			if(!array_key_exists($file_contents[$x]["region"],$temp_region)){
				$temp_region[$file_contents[$x]["region"]] = 0;
			}
			if(!array_key_exists($file_contents[$x]["subregion"],$temp_subregion)){
				$temp_subregion[$file_contents[$x]["subregion"]] = 0;
			}
			$temp_region[$file_contents[$x]["region"]]++;
			$temp_subregion[$file_contents[$x]["subregion"]]++;
			$count++;
		}
		echo("Total number of countries:".$count."<br><br>");
		echo("Find the regions and their count below: <br>");
		foreach ($temp_region as $key => $value){
			echo "{$key} => {$value}<br>";		
		}
		echo("<br>");
		echo("Find the subregions and their count below: <br>");
		foreach ($temp_subregion as $key => $value){
			echo "{$key} => {$value}<br>";		
		}
	}
}
else if(isset($_GET["code"])){
	if(!array_key_exists("status",$file_contents)){
		$temp_region = array();
		$temp_subregion = array();
		$count = 0;
		echo "Name: ".$file_contents["name"]."<br>";
		echo "Alpha 2 Code: ".$file_contents["alpha2Code"]."<br>";
		echo "Alpha 3 Code: ".$file_contents["alpha3Code"]."<br>";
		echo "Flag:<br><img src='" . $file_contents["flag"] . "' style='width:304px;height:228px;'>"."<br>";
		echo "Region: ".$file_contents["region"]."<br>";
		echo "Subregion: ".$file_contents["subregion"]."<br>";
		echo "List of Languages:<br>";
		for($y=0; $y<count($file_contents["languages"]); $y++){
			echo $file_contents["languages"][$y]["name"]."<br>";
		}
		echo "<br>";
		if(!array_key_exists($file_contents["region"],$temp_region)){
			$temp_region[$file_contents["region"]] = 0;
		}
		if(!array_key_exists($file_contents["subregion"],$temp_subregion)){
			$temp_subregion[$file_contents["subregion"]] = 0;
		}
		$temp_region[$file_contents["region"]]++;
		$temp_subregion[$file_contents["subregion"]]++;
		$count++;
		echo("Total number of countries:".$count."<br><br>");
		echo("Find the regions and their count below: <br>");
		foreach ($temp_region as $key => $value){
			echo "{$key} => {$value}<br>";		
		}
		echo("<br>");
		echo("Find the subregions and their count below: <br>");
		foreach ($temp_subregion as $key => $value){
			echo "{$key} => {$value}<br>";		
		}
	}
}
curl_close ( $ch );
?>