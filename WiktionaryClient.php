<?php
require_once('/nusoap/lib/nusoap.php');




class  WiktionaryClient{
	private $uriOfService;
	private $client;
	function __construct($uriOfService){
		
		$this->uriOfService=$uriOfService;
		
		//create nusoap client
		$this->client = new nusoap_client($this->uriOfService);
		
		//check for errors
		$error = $this->client->getError();
		if($error){
			
			die("Klient könnte einen Nusoap-Server nicht erstellen. Die Fehlermeldung war: "+$error+"\n");
		}
	}
	
	function sendQuery($nameOfFunction, $parameters){
		if($this->client){
			$answer = $this->client->call($nameOfFunction, array('parameters' => $parameters));
			
			$error = $this->client->getError();
			if($error){
				print_r($this->client->response);
				print_r($this->client->getDebug());
				die();
			}
			
			print($answer);
		}
	}
	
}

//Main Action

$client = new WiktionaryClient("de.wiktionary.org/w/api.php");

$parameters = array(
					'action'=>'query', 
					'format'=>'json',
					'rvprop'=>'content',
					'titles'=>'stadt'
					);
					
$client->sendQuery('', $parameters);
//http://de.wiktionary.org/w/api.php?action=query&format=txt&titles=M%C3%A4dchen&prop=extracts&explaintext=1&exsectionformat=wiki

//http://de.wiktionary.org/w/api.php?action=query&format=xml&titles=Stadt&prop=extracts&explaintext=1

//de.wiktionary.org/w/api.php?action=query&format=json&rvprop=content&titles=Stadt
//http://de.wiktionary.org/w/api.php?action=query&format=xml&titles=Stadt&prop=extracts

?>