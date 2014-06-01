<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><QueryResponse xmlns="urn:Microsoft.Search"><QueryResult><?php

$requestBody = @file_get_contents('php://input');
$decodedRequest = html_entity_decode($requestBody,ENT_QUOTES);

$xml = new SimpleXMLElement($decodedRequest);

$result = $xml->xpath('//Envelope');
$result;

$content  = file_get_contents("./queryResponse.xml",true);
$encodedContent = htmlspecialchars($content, ENT_NOQUOTES);
// echo $encodedContent;

var_dump($result);
?></QueryResult></QueryResponse></soap:Body></soap:Envelope>