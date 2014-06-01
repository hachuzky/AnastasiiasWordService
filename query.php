<?php
//Get Content of Request
$requestBody = @file_get_contents('php://input');

$envelop  = file_get_contents("./Envelop2.xml",true);

//file_put_contents("test.txt", $requestBody);


$decodedRequest = html_entity_decode($requestBody,ENT_QUOTES);

$domain=getDomain($decodedRequest);
$response = getWordDescription(getQueryString($decodedRequest));
$content  = file_get_contents("./queryResponse.xml",true);
$encodedContent = htmlspecialchars($content, ENT_NOQUOTES);

$newContent=str_replace(array("%domain%","%response%"), array($domain,$response, ENT_NOQUOTES), $encodedContent);

//print($newContent);

$returnContext =  str_replace("%PHP%", $newContent, $envelop);
//file_put_contents("test2.txt", $returnContext);

echo $returnContext;

function getDomain($string){
	$regExpr ='/Query domain=\s*\'{([\d\w-]+)}\'/';
	preg_match($regExpr,$string, $result);
	
	if (count($result) >1){
		return $result[1];
		
	}else {
		return count($result);
	}

}

function getQueryString($string){
	//file_put_contents("test2.txt", $string);
	$regExpr = '/<QueryText\s+type=\'STRING\'\s+language=\'[\w-]+\'\s+>([\w\s\d\&\#\;]+)<\/QueryText>/';
	
	preg_match($regExpr,$string, $result);


	if (count($result) >1){
		return trim($result[1]);
		
	
	}else {
		return count($result);
	}
}

function getWordDescription($string){
	$url ='http://de.wiktionary.org/w/api.php?action=query&format=json&titles='.html_entity_decode($string).'&prop=extracts&explaintext=1&exsectionformat=wiki';
	
	$curl_handle = curl_init($url);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
	$output = curl_exec( $curl_handle ); // Execute the request
	curl_close( $curl_handle );
	
	
	$response = json_decode($output, true);
	$array1 = array_values($response);
	$array2 = array_values($array1[0]);
	$array3 = array_values($array2[0]);
	$array4 = array_values($array3[0]);
	
	
	$content = $array4[3];
	
	$content = str_replace("&", "and", $content);
	
	$splitedContent = explode("\n",$content);
	
	$responseString = "";
	
	foreach ($splitedContent as $line){
		if(strpos($line,'====') !== false){
			break;
		}
		$responseString .="<c:Line><c:Char>".$line."</c:Char></c:Line>";
	}
	return htmlspecialchars($responseString, ENT_NOQUOTES);	
}

function get_inner_html( $node ) {
	$innerHTML= '';
	$children = $node->childNodes;
	foreach ($children as $child) {
		$innerHTML .= " ".$child->ownerDocument->saveXML( $child );
	}

	return $innerHTML;
}
?>