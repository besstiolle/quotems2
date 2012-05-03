<?php
if (!isset($gCms)) exit;

$db =& $this->GetDb();
$dict = NewDataDictionary($db);


$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quotegroups");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_quotegroups_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quotes");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_quotes_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quotetemplates");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_quotetemplates_seq");


$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quoteconnections");
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quoteprops");
$dict->ExecuteSQLArray($sqlarray);

$this->RemovePermission("managequotes");

$query = "DELETE FROM ".cms_db_prefix()."css WHERE css_name=?";
$result=$db->Execute($query,array("Module: Quotes Made Simple"));


?>