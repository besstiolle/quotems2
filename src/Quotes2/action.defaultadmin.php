<?php
if (!function_exists('cmsms')) exit;

if (!$this->VisibleToAdminUser()) {
  echo $this->Lang("accessdenied");
  return;
}


$db=&$this->GetDb();
$themeObject = &$gCms->variables['admintheme'];


$tab="";
if (isset($params["tab"])) $tab=$params["tab"];

echo $this->StartTabHeaders();


echo $this->SetTabHeader("quotes",$this->Lang("quotestab"),($tab=="quotes"));



echo $this->SetTabHeader("groups",$this->Lang("grouptab"),($tab=="groups"));


if( $this->CheckPermission('Modify Templates') ) {
  echo $this->SetTabHeader("templates",$this->Lang("templatetab"),($tab=="templates"));

}

if( $this->CheckPermission('Modify Stylesheets') ) {
  echo $this->SetTabHeader("showcss",$this->Lang("csstab"),($tab=="csstab"));
}

echo $this->SetTabHeader("settings",$this->Lang("settings"),($tab=="settings"));

echo $this->EndTabHeaders();
echo $this->StartTabContent();


echo $this->StartTab("quotes");

$quotes=$this->GetQuoteEntries();
//print_r($groups);
$showquotes = array();
if (TRUE == empty($quotes)) {
	$this->smarty->assign('noquotestext', $this->Lang("noquotes"));
} else {
	foreach ($quotes as $quote) {
		$onerow = new stdClass();
//print_r($quote);
//echo $quote["content"];
    switch($quote["type"]) {
    	case "1" : $quote["content"]=substr($quote["content"],0,200); break;
    }
		$onerow->content = $this->CreateLink($id, 'editquote', $returnid, strip_tags($quote["content"]), array('quoteid'=>$quote["id"],"todo"=>"edit","type"=>$quote["type"]));
		$onerow->id = $quote["id"];
		$onerow->exposure="0";
		if (isset($quote["exposures"])) $onerow->exposure=$quote["exposures"];
		$onerow->quotetype = $this->GetTypeName($quote["type"]);
		//echo $onerow->id;
				$onerow->editlink = $this->CreateLink($id, 'editquote', $returnid,
																						$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang("editquote"),'','','systemicon'),
																								array('quoteid' => $quote["id"],"todo"=>"edit","type"=>$quote["type"]));
		
		$onerow->deletelink = $this->CreateLink($id, 'editquote', $returnid,
																						$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang("deletegroup"),'','','systemicon'),
																								array('quoteid' => $quote["id"],"todo"=>"delete","type"=>$quote["type"]), $this->Lang("confirmdeletequote"));

		array_push($showquotes, $onerow);
	}
	
}
$this->smarty->assign('quotetype', $this->Lang("quotetype"));
$this->smarty->assign('quotes', $this->Lang("quotes"));
$this->smarty->assign('actions', $this->Lang("actions"));
$this->smarty->assign_by_ref('items', $showquotes);

$this->smarty->assign('itemcount', count($showquotes));

$form=$this->CreateFormStart($id,"editquote",$returnid,"post","",false,"",array("todo"=>"add"));
$form.=$this->CreateInputDropdown($id,"type",$this->GetTypes());
$form.=$this->CreateInputSubmit($id,"submit",$this->Lang("addquote"));
$form.= $this->CreateFormEnd();


$this->smarty->assign('addform', $form);

echo $this->ProcessTemplate('adminquotes.tpl');
echo $this->EndTab();




echo $this->StartTab("groups");


$groups=$this->GetGroups();
$showgroups = array();
if (TRUE == empty($groups)) {
	$this->smarty->assign('nogroupstext', $this->Lang("nogroups"));
} else {
	foreach ($groups as $group) {
		$onerow = new stdClass();
		
		$onerow->code = "";
		if (!empty($group["textid"])) {
			$onerow->code = $this->CreateLink($id, 'editgroup', $returnid, $group["textid"], array('groupid'=>$group["id"],"todo"=>"edit"));
		}
		
		$onerow->desc = "";
		if (!empty($group["description"])) {
			$onerow->desc = $group["description"];
		}
		$onerow->id = $group["id"];			
		$onerow->editlink = $this->CreateLink($id, 'editgroup', $returnid,
									$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang("editgroup"),'','','systemicon'),
									array('groupid' => $group["id"],"todo"=>"edit"));
		
		$onerow->deletelink = $this->CreateLink($id, 'editgroup', $returnid,
									$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang("deletegroup"),'','','systemicon'),
									array('groupid' => $group["id"],"todo"=>"delete"), $this->Lang("confirmdeletegroup"));

		array_push($showgroups, $onerow);
	}
	
}

$this->smarty->assign_by_ref('groups', $this->Lang("groups"));
$this->smarty->assign_by_ref('actions', $this->Lang("actions"));
$this->smarty->assign_by_ref('items', $showgroups);
$this->smarty->assign('itemcount', count($showgroups));

$link=$this->CreateLink($id, 'editgroup', 0, $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang("addgroup"),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'editgroup', $returnid, $this->lang("addgroup"), array("todo"=>"add"), '', false, false, 'class="pageoptions"');

$this->smarty->assign('addlink', $link);

echo $this->ProcessTemplate('admingroups.tpl');
echo $this->EndTab();




if( $this->CheckPermission('Modify Templates') ) {

  echo $this->StartTab("templates");



$templates=$this->GetTemplates();

$showtemplates = array();
if (TRUE == empty($templates)) {
	$this->smarty->assign('notemplatestext', $this->Lang("notemplates"));
} else {
	foreach ($templates as $template) {
		//print_r($template);

		$onerow = new stdClass();
		$onerow->name = $this->CreateLink($id, 'edittemplate', $returnid, $template["name"], array('templateid'=>$template["id"],"todo"=>"edit"));
		$onerow->id = $template["id"];
		 				
		//echo $onerow->id;
		$onerow->editlink = $this->CreateLink($id, 'edittemplate', $returnid,
																						$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang("edittemplate"),'','','systemicon'),
																								array('templateid' => $template["id"],"todo"=>"edit"));
		$onerow->copylink = $this->CreateLink($id, 'edittemplate', $returnid,
																						$themeObject->DisplayImage('icons/system/copy.gif', $this->Lang("copytemplate"),'','','systemicon'),
																								array('templateid' => $template["id"],"todo"=>"copy"));
		if ($template["name"]!="default") {
		$onerow->deletelink = $this->CreateLink($id, 'edittemplate', $returnid,
																						$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang("deletetemplate"),'','','systemicon'),
																								array('templateid' => $template["id"],"todo"=>"delete"), $this->Lang("confirmdeletetemplate"));
		}
		array_push($showtemplates, $onerow);
	}	
}

$this->smarty->assign_by_ref('templates', $this->Lang("templates"));
$this->smarty->assign_by_ref('actions', $this->Lang("actions"));
$this->smarty->assign_by_ref('items', $showtemplates);
$this->smarty->assign('itemcount', count($showtemplates));

$link=$this->CreateLink($id, 'edittemplate', 0, $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang("addtemplate"),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'edittemplate', $returnid, $this->Lang("addtemplate"), array("todo"=>"add"), '', false, false, 'class="pageoptions"');

$this->smarty->assign('addlink', $link);

echo $this->ProcessTemplate('admintemplates.tpl');
  echo $this->EndTab();
}

if( $this->CheckPermission('Modify Stylesheets') ) {
  echo $this->StartTab("showcss");
  $this->smarty->assign('formstart',$this->CreateFormStart($id,"savestylesheet",$returnid,'post', '', false,'',array("tab"=>"csstab")));
  $this->smarty->assign('formend',$this->CreateFormEnd());
  $this->smarty->assign('content',  $this->Lang("stylesheet"));
  $query = "SELECT css_text FROM " . cms_db_prefix() . "css WHERE css_name=?";
  $result=$db->Execute($query, array("Module: Quotes Made Simple"));
  $content="";
  if ($result) {
    $row=$result->FetchRow();
    $content=$row["css_text"];
  } else {
    $content="error retrieving stylesheetcontent, please use the stylesheet administration menu";
  }
  $this->smarty->assign('contentinput', $this->CreateTextArea(false,$id,$content,"content"));
  $this->smarty->assign('submit',$this->CreateInputSubmit($id,"submit",$this->Lang("savestylesheet")));
  $this->smarty->assign('reset', $this->CreateInputSubmit($id,"reset",$this->Lang("resetstylesheet"),"","",$this->Lang("confirmresetstylesheet")));
  echo $this->ProcessTemplate('adminedittext.tpl');
  echo $this->EndTab();
}

echo $this->StartTab("settings");
$this->smarty->assign('formstart',$this->CreateFormStart($id,"savesettings",$returnid));
$this->smarty->assign('formend',$this->CreateFormEnd());

 $this->smarty->assign('allowwysiwygtext', $this->Lang("allowwysiwyg"));
 $this->smarty->assign('allowwysiwyginput', $this->CreateInputCheckbox($id,"allowwysiwyg",'1',$this->GetPreference("allowwysiwyg",'0')));

$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("savesettings")));//"Gem indstillinger"));

echo $this->ProcessTemplate('settings.tpl');
echo $this->EndTab();

echo $this->EndTabContent();

?>