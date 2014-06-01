<?php
$string = "Mädchen";


$url ='http://de.wiktionary.org/w/api.php?action=query&format=json&titles='.urlencode($string).'&prop=extracts&explaintext=1&exsectionformat=wiki';

$curl_handle = curl_init($url);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec( $curl_handle ); // Execute the request
curl_close( $curl_handle );



$response = json_decode($output, true);
$content = array_values(array_values(array_values(array_values($response)[0])[0])[0])[3];
print($output);
$splitedContent = explode("\n",$content);

// 	return "Hello World <br/>".array_values(array_values(array_values(array_values($response)[0])[0])[0])[3];
$responseString = "";
foreach ($splitedContent as $line){
	$responseString .="<c:Line><c:Char>".$line."</c:Line></c:Char>";
}
print htmlspecialchars($responseString, ENT_NOQUOTES);

?>