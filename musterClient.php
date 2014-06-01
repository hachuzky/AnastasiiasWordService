<?php
require_once('/nusoap/lib/nusoap.php');

// Create the client instance
$client = new soapclient('http://localhost/AnastasiiasWordService/server.php');
// Call the SOAP method
$result = $client->call('hello', array('name' => 'Scott'));
// Display the result
print_r($result);
?>