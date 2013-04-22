<?php
if (!function_exists('cmsms')) exit;

$db =& $this->GetDb();

$db_prefix = cms_db_prefix();
$dict = NewDataDictionary($db);
$flds= "
		id I,
    textid C(32),
		description C(255)
	";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_quotegroups', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence( cms_db_prefix()."module_quotegroups_seq" );

$flds= "
		id I,
    type I		
	";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_quotes', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence( cms_db_prefix()."module_quotes_seq" );

$flds= "
		quoteid I,
    name C(80),
		value X
	";
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_quoteprops', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


$flds= "
		id I,
    name C(80),
		isdefault I,
		content X
	";
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_quotetemplates', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence( cms_db_prefix()."module_quotetemplates_seq" );

$flds= "
		quoteid I,
    groupid I		
	";
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_quoteconnections', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$this->AddTemplate("default",file_get_contents("../modules/Quotes2/templates/default.tpl"));

$this->CreatePermission('managequotes', $this->Lang('permission'));

$new_css_id = $db->GenID(cms_db_prefix() . "css_seq");
$css_name = "Module: Quotes Made Simple";
$css_text = file_get_contents($this->cms->config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->GetName() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');
$media_type = '';
$query = "INSERT INTO " . cms_db_prefix() . "css (css_id, css_name, css_text, media_type, create_date, modified_date) VALUES (?, ?, ?, ?, ?, ?)";
# add the stylesheet to the database
$result = $db->Execute($query, array($new_css_id, $css_name, $css_text, $media_type, $db->DBTimeStamp(time()), $db->DBTimeStamp(time())));


?>