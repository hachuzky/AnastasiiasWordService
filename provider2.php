<?php
//readfile("./description2.xml", true)
$envelop  = file_get_contents("./Envelop.xml",true);
//read content
$content  = file_get_contents("./description.xml",true);
$encodedContent = htmlspecialchars($content, ENT_NOQUOTES);

echo str_replace("%PHP%", $encodedContent, $envelop);

?>