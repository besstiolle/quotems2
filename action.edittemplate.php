<?php
if (!isset($gCms)) exit;

if (!isset($params["todo"])) exit;

if (isset($params["reset"])) $params["todo"]="reset";
if (isset($params["apply"])) $params["todo"]="apply";
$inerror=false;

$params["tab"]="templates";
$templateid="";
if ($params["todo"]!="add" && !isset($params["templateid"])) {
	echo "Internal error"; exit;
} else {
	if (isset($params["templateid"])) $templateid=$params["templateid"];
}
if (isset($params["apply"])) $params["todo"]="apply";

switch ($params["todo"]) {
	case "delete" : {
		$this->_DeleteTemplate($templateid);
		$params["module_message"]=$this->Lang("templatedeleted");		
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "reset" : {
		$this->UpdateTemplate($templateid,"default",file_get_contents("../modules/Quotes2/templates/default.tpl"));
		$params["module_message"]=$this->Lang("templatereset");
		/*$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;*/
		$params["content"]=	file_get_contents("../modules/Quotes2/templates/default.tpl");
		$params["todo"]="edit";		
		unset($params["reset"]);
		$this->Redirect($id, 'edittemplate', $returnid,$params);
		break;
	}
	case "save" : {
		if (!isset($params["name"]) || trim($params["name"]=="")) {
			echo $this->ShowErrors($this->Lang("missingname"));
			$inerror=true;
			break;
		}
//print_r($params);die();
		$this->AddTemplate($params["name"],$params["content"]);
		
		$params["module_message"]=$this->Lang("templateadded");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "apply" : {
		if (!isset($params["name"]) || trim($params["name"]=="")) {
			echo $this->ShowErrors($this->Lang("missingname"));
			break;
		}
		$this->UpdateTemplate($templateid,$params["name"],$params["content"]);
		$params["module_message"]=$this->Lang("templateupdated");
		$params["todo"]="edit";		
		unset($params["apply"]);
		$this->Redirect($id, 'edittemplate', $returnid,$params);
		break;
	}
	case "update" : {
		if (!isset($params["name"]) || trim($params["name"]=="")) {
			echo $this->ShowErrors($this->Lang("missingname"));
			break;
		}
		$this->UpdateTemplate($templateid,$params["name"],$params["content"]);
		$params["module_message"]=$this->Lang("templateupdated");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
}

$name="";
$content=file_get_contents("../modules/Quotes2/templates/default.tpl");

if ($params["todo"]=="edit") {
	$template=$this->_GetTemplate($params["templateid"]);	
	$name=$template["name"];
	$content=$template["content"];
}

if (isset($params["name"])) $name=$params["name"];
if (isset($params["content"])) $content=$params["content"];


$newtodo="";
if ($inerror) {
	$newtodo=$params["todo"];
} else {
  if ($params["todo"]=="edit") $newtodo="update";
  if ($params["todo"]=="add" || $params["todo"]=="copy") $newtodo="save";
}
$this->smarty->assign('formstart',$this->CreateFormStart($id,"edittemplate",$returnid,"post","",false,"",array("todo"=>$newtodo,"templateid"=>$templateid)));
$this->smarty->assign('formend',$this->CreateFormEnd());
if ($name=="default") {
	$this->smarty->assign('nameinput',$name);
	$this->smarty->assign('namehidden',$this->CreateInputHidden($id,"name",$name));
} else {
  $this->smarty->assign('nameinput',$this->CreateInputText($id,"name",$name,40,100));
}

$this->smarty->assign('name',$this->lang("templatename"));
$this->smarty->assign('templatehelp',$this->lang("templatehelp"));

$this->smarty->assign('content',$this->lang("templatecontent"));
$this->smarty->assign('contentinput',$this->CreateTextArea(false,$id,$content,"content"));

if ($params["todo"]=="edit") {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("savetemplate")));	
	$this->smarty->assign('apply', $this->CreateInputSubmit($id,"apply",$this->Lang("applychanges")));
	$this->smarty->assign('reset', $this->CreateInputSubmit($id,"reset",$this->Lang("resettemplate"),"","",$this->Lang("confirmtempaltereset")));
} else {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("addtemplate")));
}

$this->smarty->assign('backlink', $this->CreateLink($id,"defaultadmin",$returnid,$this->Lang("backlink"),array("tab"=>"templates")));

echo $this->ProcessTemplate('adminedittext.tpl');

?>

