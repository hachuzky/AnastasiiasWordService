<?php
$wort= array('dataRow' => array('Word','Katze'));
$wortart=array('dataRow'=>array('Wortart','N'));
$limit=array('dataRow'=> array('Limit','10'));
$dataVectors=array($wort,$limit);
$parameters=array('dataVectors' => $dataVectors);
$request = array(
    'objRequestParameters' => 
        array(
            'corpus' => 'de',
            'parameters' => $parameters
        )
);

$client = new SoapClient("http://wortschatz.uni-leipzig.de/axis/services/Wordforms?wsdl", 
                         array(
                                 'trace'=>1, 
                                 'exceptions' => 1, 
                                 'login'=>'anonymous', 
                                 'password'=>'anonymous'
                         )
                        );

try{
	$result = $client->execute($request);
    var_dump($result->executeReturn->result->dataVectors);
    //var_dump($result);
}catch(Exception $e){
    die("ERROR: ".$e->getMessage());
}
?>