<?php

$quote=$this->SelectQuote($params);

switch($quote["type"]) {
	
}

//print_r($quote);
$template="default";
if (isset($params["template"])) $template=$params["template"];

$template=$this->_GetTemplate("",$template);
//print_r ($templatecontent); 	

foreach ($quote as $propname=>$value) {
	$this->smarty->assign("quote".$propname, $value);
}

echo $this->ProcessTemplateFromData($template["content"]);

?>