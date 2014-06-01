<?php


// Pull in the NuSOAP code
require_once('/nusoap/lib/nusoap.php');
$client = new nusoap_client('http://wortschatz.uni-leipzig.de:8100/axis/services/Wordforms?wsdl', FALSE);
$client->namespaces['ns1']='urn:Wordforms';
$client->namespaces['ns2']='http://datatypes.webservice.wortschatz.uni_leipzig.de';
$client->operation = 'execute';
//get errors
$error = $client->getError();

if($error){
 	die("client construction error: {$error}\n");
}

$client->setCredentials('anonymous', 'anonymous', 'basic');

$msg = $client->serializeEnvelope('
		<ns1:execute>
			<ns1:objRequestParameters>
				<ns1:corpus>de</ns1:corpus>
				<ns1:parameters>
					<ns1:dataVectors>
						<ns2:dataRow>Word</ns2:dataRow>
						<ns2:dataRow>Katze</ns2:dataRow>
					</ns1:dataVectors>
					<ns1:dataVectors>
						<ns2:dataRow>Limit</ns2:dataRow>
						<ns2:dataRow>10</ns2:dataRow>
					</ns1:dataVectors>
				</ns1:parameters>
			</ns1:objRequestParameters>
		</ns1:execute>
		
		');

//perform a function call without parameters:
try{
$answer = $client->send($msg,'http://wortschatz.uni-leipzig.de:8100/axis/services/Wordforms');
//var_dump($answer->executeReturn->result->dataVectors);
var_dump($answer['executeReturn']['result']['dataVectors']);
}catch(Exception $e){
	
	
    die("ERROR: ".$e->getMessage());
	
}


?>