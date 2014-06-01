<?php
class Service {
	function getUsers($args) {
	   $args = (array)$args;
	   return array("getUsersArray" => array(  
	                                       array("id"=>"1",
	                                           "firstname"=>"Barney",
	                                           "surname"=>"Rubble",
	                                           "message"=>$args["message"]), 
	                                       array("id"=>"2", 
	                                            "firstname"=>"Fred", 
	                                            "surname"=>"Flintstone", 
	                                            "message"=>$args["message"])
	                                    )
	               );
	}
}
ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
$server = new SoapServer("service.wsdl");
$server->setClass("Service");
try {
    $server->handle();
}
catch (Exception $e) {
    $server->fault('Sender', $e->getMessage());
}


if(isset($_SERVER['REQUEST_METHOD'])&&
	   $_SERVER['REQUEST_METHOD']=='POST'){
	$server->handle();
}else {
	if(isset($_SERVER['QUERY_STRING'])&&
	   strcasecmp($_SERVER['QUERY_STRING'], 'wsdl')== 0){
		//return the wsdl
		$wsdl = @implode('',@file('service.wsdl'));
		if(strlen($wsdl)>1){
			header("Content-type:text/html");
			echo $wsdl;
		}else {
			header("Status: 500 Internal Server Error");
			header("Content-type: text/plain");
			echo "HTTP/1.0 500 Internal Server Error";
		}
	}
	
}
?>