<?php


if (!isset($gCms) || !$this->VisibleToAdminUser()) {
  echo $this->Lang("accessdenied");
  return;
}

/*
if (isset($params["breadcrumbroot"])) 
  $this->SetPreference("breadcrumbroot", $params["breadcrumbroot"]);
  
if (isset($params["rsstitle"]))
  $this->SetPreference("rsstitle", $params["rsstitle"]);
  
if (isset($params["rssdescription"]))
  $this->SetPreference("rssdescription", $params["rssdescription"]);
  
*/
  
if (isset($params["allowwysiwyg"]))
  $this->SetPreference("allowwysiwyg", $params["allowwysiwyg"]);
else
  $this->SetPreference("allowwysiwyg", '0');
  
  

$this->Redirect($id, 'defaultadmin', $returnid,array("module_message"=>$this->Lang("settingssaved"),"tab"=>"settings"));
?>