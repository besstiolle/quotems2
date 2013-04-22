<?php
if (!function_exists('cmsms')) exit;

if ( !$this->VisibleToAdminUser()) {
  echo $this->Lang("accessdenied");
  return;
}
  
if (isset($params["allowwysiwyg"]))
  $this->SetPreference("allowwysiwyg", $params["allowwysiwyg"]);
else
  $this->SetPreference("allowwysiwyg", '0');
  
  

$this->Redirect($id, 'defaultadmin', $returnid,array("module_message"=>$this->Lang("settingssaved"),"tab"=>"settings"));
?>