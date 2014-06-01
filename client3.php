<?php
$wort= array('dataRow' => array('Wort','Help'));
$dataVectors=array($wort);
$parameters=array('dataVectors' => $dataVectors);
$request = array(
    'objRequestParameters' => 
        array(
            'corpus' => 'de',
            'parameters' => $parameters
        )
);

$client = new SoapClient("http://wortschatz.uni-leipzig.de/axis/services/Frequencies?wsdl", 
                         array(
                                 'trace'=>1, 
                                 'exceptions' => 1, 
                                 'login'=>'anonymous', 
                                 'password'=>'anonymous'
                         )
                        );

try{
    $result = $client->ping($request);
    var_dump($result->pingReturn);
}catch(Exception $e){
    die("ERROR: ".$e->getMessage());
}
?>