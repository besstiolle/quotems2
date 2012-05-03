<?php

if (!isset($gCms) || !$this->VisibleToAdminUser()) {
  echo $this->Lang("accessdenied");
  return;
}

$content = (isset($params['content']) ? $params['content'] : '');
if ($content == '') $this->Redirect($id, 'defaultadmin', $returnid);


$css_text="";
if (isset($params["reset"])) {
//  $this->SetPreference("stylesheet",file_get_contents(dirname(__FILE__)."/css/stylesheet.css"));
  $css_text = file_get_contents($this->cms->config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->GetName() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');
  $params["module_message"]=$this->Lang("stylesheetreset");
} else {
  //$this->SetPreference("stylesheet",$content);
  $css_text=$content;
  $params["module_message"]=$this->Lang("stylesheetupdated");
}
$db=$this->GetDB();

$css_name = "Module: Quotes Made Simple";
//$css_text = file_get_contents($this->cms->config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->GetName() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');

$query = "UPDATE " . cms_db_prefix() . "css SET css_text=?,modified_date=? WHERE css_name=?";
# add the stylesheet to the database
$result = $db->Execute($query, array($css_text, $db->DBTimeStamp(time()),$css_name));
//echo $db->ErrorMsg();DIe();
$params["tab"]="csstab";
$this->Redirect($id, 'defaultadmin', '', $params);


?>