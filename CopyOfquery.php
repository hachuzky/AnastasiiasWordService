<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><QueryResponse xmlns="urn:Microsoft.Search"><QueryResult><?php
//Get Content of Request
$requestBody = @file_get_contents('php://input');

//file_put_contents("test.txt", $requestBody);


$decodedRequest = html_entity_decode($requestBody,ENT_QUOTES);

$domain=getDomain($decodedRequest);
$response = getWordDescription(getQueryString($decodedRequest));
$content  = file_get_contents("./queryResponse.xml",true);
$encodedContent = htmlspecialchars($content, ENT_NOQUOTES);

$newContent=str_replace(array("%domain%","%response%"), array($domain,$response, ENT_NOQUOTES), $encodedContent);

print($newContent);



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

// function getWordDescription($string){
	
// 	$url ='http://de.thefreedictionary.com/'.$string;
	
// 	$curl_handle = curl_init($url);
// 	//curl_setopt( $curl_handle, CURLOPT_URL, $url );
// 	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
// 	$output = curl_exec( $curl_handle ); // Execute the request
// 	curl_close( $curl_handle );
	
	
// 	$pageDom = new DomDocument();
// 	$pageDom->preserveWhiteSpace = false;
// 	$pageDom->formatOutput       = true;
// 	@$pageDom->loadHTML($output);
// 	$xpath = new DOMXPath($pageDom);
// 	//return $xpath->query('//div[@id="MainTxt"]')->item(0)->nodeValue;
// 	return get_inner_html($xpath->query('//div[@id="MainTxt"]')->item(0));
// }

// function getWordDescription2($string){

// // 	$url ='http://de.wiktionary.org/wiki/'.$string;
// 	$url ='http://de.pons.com/%C3%BCbersetzung?q='.$string.'&l=dedx&in=&lf=';

// 	$curl_handle = curl_init($url);
// 	//curl_setopt( $curl_handle, CURLOPT_URL, $url );
// 	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
// 	$output = curl_exec( $curl_handle ); // Execute the request
// 	curl_close( $curl_handle );


// 	$pageDom = new DomDocument();
// 	$pageDom->preserveWhiteSpace = false;
// 	$pageDom->formatOutput       = true;
// 	@$pageDom->loadHTML($output);
// 	$xpath = new DOMXPath($pageDom);
// 	//return $xpath->query('//div[@id="MainTxt"]')->item(0)->nodeValue;
// 	//return "<table>".get_inner_html($xpath->query('//table[@class="wikitable float-right inflection-table flexbox hintergrundfarbe2"]')->item(0))."</table>";
// 	//return $xpath->query('//table[@class="wikitable float-right inflection-table flexbox hintergrundfarbe2"]')->item(0)->nodeValue;
// 	return str_replace(array('<','>'), array(' ', ' '), preg_replace('!\s+!', ' ',$xpath->query('//div[@class="romhead opened"]')->item(0)->nodeValue));
// }

function getWordDescription($string){
	$url ='http://de.wiktionary.org/w/api.php?action=query&format=json&titles='.html_entity_decode($string).'&prop=extracts&explaintext=1&exsectionformat=wiki';
	file_put_contents("test2.txt", $url);
	$curl_handle = curl_init($url);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLOPT_BINARYTRANSFER, true);
	$output = curl_exec( $curl_handle ); // Execute the request
	curl_close( $curl_handle );
	
	
	$response = json_decode($output, true);
	$content = array_values(array_values(array_values(array_values($response)[0])[0])[0])[3];
	
	$splitedContent = explode("\n",$content);
	
	$responseString = "";
	foreach ($splitedContent as $line){
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
?></QueryResult></QueryResponse></soap:Body></soap:Envelope>