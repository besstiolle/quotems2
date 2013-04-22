<?php
if (!function_exists('cmsms')) exit;

if (!$this->VisibleToAdminUser()) {
  echo $this->Lang("accessdenied");
  return;
}

$content = (isset($params['content']) ? $params['content'] : '');
if ($content == '') $this->Redirect($id, 'defaultadmin', $returnid);


$css_text="";
if (isset($params["reset"])) {
  $css_text = file_get_contents($this->cms->config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->GetName() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');
  $params["module_message"]=$this->Lang("stylesheetreset");
} else {
  $css_text=$content;
  $params["module_message"]=$this->Lang("stylesheetupdated");
}
$db=$this->GetDB();

$css_name = "Module: Quotes Made Simple";

$query = "UPDATE " . cms_db_prefix() . "css SET css_text=?,modified_date=? WHERE css_name=?";
# add the stylesheet to the database
$result = $db->Execute($query, array($css_text, $db->DBTimeStamp(time()),$css_name));
$params["tab"]="csstab";
$this->Redirect($id, 'defaultadmin', '', $params);


?>