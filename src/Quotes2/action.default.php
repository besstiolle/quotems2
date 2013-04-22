<?php
if (!function_exists('cmsms')) exit;

$quotes=$this->SelectQuotes($params);

$template="default";
if (isset($params["template"])) $template=$params["template"];

$template=$this->_GetTemplate("",$template);

foreach ($quotes['quotes'] as $quote) {
    foreach ($quote as $propname=>$value) {
        $this->smarty->assign("quote".$propname, $value);
    }
    echo $this->ProcessTemplateFromData($template["content"]);
}
?>