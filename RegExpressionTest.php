<?php
$string="<QueryText type='STRING' language='de' >M&#228;dchen</QueryText><LanguagePreference>de</LanguagePreference><Requery></Requery></Context>";
$regExpr = '/<QueryText\s+type=\'STRING\'\s+language=\'[\w-]+\'\s+>([\w\s\d\&\#\;]+)<\/QueryText>/';

preg_match($regExpr,$string, $result);

if (count($result) >1){
	echo trim($result[1]);

}else {
	echo count($result);
}
?>