<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><RegistrationResponse xmlns="urn:Microsoft.Search"><RegistrationResult><?php
//readfile("./description2.xml", true)

//read content
$content  = file_get_contents("./description.xml",true);
$encodedContent = htmlspecialchars($content, ENT_NOQUOTES);

echo $encodedContent;

?></RegistrationResult></RegistrationResponse></soap:Body></soap:Envelope>