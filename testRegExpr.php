<?php
$testString = 'Query domain= {1698EF5D-E2F5-EF54-87B2-7FC9E9AB0EEF}><QueryId>{';
$testExpr ='/Query domain= ({[\d\w-]+})/';
preg_match($testExpr,$testString, $result);
print_r($result[1]);
?>