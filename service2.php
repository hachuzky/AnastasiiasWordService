<?php
require '/nusoap/lib/nusoap.php';
$namespace = "http://localhost/AnastasiiasWordService/wsdl";

$server = new soap_server();
$server->debug_flag = false;
$server->configureWSDL("serviceWSDL", $namespace);
$server->wsdl->schemaTargetNamespace=$namespace;

$server->wsdl->addComplexType(
		'Walk',
		'complexType',
		'struct',
		'all',
		'',
		array(
				'WalkId' => array('name' => 'WalkId',
						'type' => 'xsd:int'),
				'WalkTitle' => array('name' => 'WalkTitle',
						'type' => 'xsd:string'),
				'WalkDate' => array('name' => 'WalkDate',
						'type' => 'xsd:date'),
				'WalkDescription' => array('name' => 'WalkDescription',
						'type' => 'xsd:string')
		)
);
$server->wsdl->addComplexType(
		'Walks',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(
				array('ref' => 'SOAP-ENC:arrayType',
						'wsdl:arrayType' => 'tns:Walk[]')
		),
		'tns:Walk'
);

$server->register('GetWalk',                    // method name
		array('WalkId' => 'xsd:int'),          // input parameters
		array('return' => 'tns:Walk'),    // output parameters
		$namespace,                         // namespace
		$namespace . '#GetWalk',                   // soapaction
		'rpc',                                    // style
		'encoded',                                // use
		'Get Specific Walk'        // documentation
);

function GetWalk($walkid)
{
	return array(
			"WalkId" => $walkid,
			"WalkTitle" => "Title of my long walk",
			"WalkDate" => date("Y-m-d", time()),
			"WalkDescription" => "Really long walk description"
	);
}
$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA'])
? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($HTTP_RAW_POST_DATA);
exit();
?>