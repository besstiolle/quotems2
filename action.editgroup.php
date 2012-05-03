<?php
if (!isset($gCms)) exit;

if (!isset($params["todo"])) exit;


$inerror=false;

$params["tab"]="groups";
$groupid="";
if ($params["todo"]!="add" && !isset($params["groupid"])) {
	echo "Internal error"; exit;
} else {
	if (isset($params["groupid"])) $groupid=$params["groupid"];
}
if (isset($params["apply"])) $params["todo"]="apply";

switch ($params["todo"]) {
	case "delete" : {
		$this->DeleteGroup($groupid);
		$params["module_message"]=$this->Lang("groupdeleted");		
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "save" : {
		if (!isset($params["textid"])) {
			echo $this->ShowErrors($this->Lang("missingtextid"));
			$inerror=true;
			break;
		}
		$group=$this->GetGroup($params["textid"]);
	  if ($group!=false && $group["id"]!=$groupid) {
			echo $this->ShowErrors($this->Lang("textidinuse"));
			$inerror=true;
			break;
		}
//print_r($params);die();
		if ($params["description"]=="") $params["decription"]=$params["textid"];
		$this->AddGroup($params["textid"],$params["description"]);
		
		$params["module_message"]=$this->Lang("groupadded");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "apply" : {
		if (!isset($params["textid"])) {
			echo $this->ShowErrors($this->Lang("missingtextid"));
			break;
		}
		$group=$this->GetGroup($params["textid"]);
		if ($group!=false && $group["id"]!=$groupid) {
			echo $this->ShowErrors($this->Lang("textidinuse"));
			$inerror=true;
			break;
		}
		if ($params["description"]=="") $params["decription"]=$params["textid"];
		$this->UpdateGroup($groupid,$params["textid"],$params["description"]);
		$params["module_message"]=$this->Lang("groupupdated");
		$params["todo"]="edit";		
		unset($params["apply"]);
		$this->Redirect($id, 'edittemplate', $returnid,$params);
		break;
	}
	case "update" : {
		if (!isset($params["textid"])) {
			echo $this->ShowErrors($this->Lang("missingtextid"));
			break;
		}
		$group=$this->GetGroup($params["textid"]);
		if ($group!=false && $group["id"]!=$groupid) {
			echo $this->ShowErrors($this->Lang("textidinuse"));
			$inerror=true;
			break;
		}
		if ($params["description"]=="") $params["decription"]=$params["textid"];
		$this->UpdateGroup($groupid,$params["textid"],$params["description"]);
		$params["module_message"]=$this->Lang("groupupdated");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
}

$name="";

$description="";

if ($params["todo"]=="edit") {
	$group=$this->GetGroup("",$groupid);	
	$textid=$group["textid"];
	$description=$group["description"];
}

if (isset($params["textid"])) $textid=$params["textid"];
if (isset($params["description"])) $description=$params["description"];


$newtodo="";
if ($inerror) {
	$newtodo=$params["todo"];
} else {
  if ($params["todo"]=="edit") $newtodo="update";
  if ($params["todo"]=="add") $newtodo="save";
}
$this->smarty->assign('formstart',$this->CreateFormStart($id,"editgroup",$returnid,"post","",false,"",array("todo"=>$newtodo,"groupid"=>$groupid)));
$this->smarty->assign('formend',$this->CreateFormEnd());

$this->smarty->assign('textid',$this->lang("textid"));
$this->smarty->assign('textidinput',$this->CreateInputText($id,"textid",$textid,20,32));


$this->smarty->assign('description',$this->lang("groupdescription"));
$this->smarty->assign('descriptioninput',$this->CreateInputText($id,"description",$description,80,100));

if ($params["todo"]=="edit") {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("savegroup")));
	$this->smarty->assign('apply', $this->CreateInputSubmit($id,"apply",$this->Lang("applychanges")));
} else {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("addgroup")));
}

$this->smarty->assign('backlink', $this->CreateLink($id,"defaultadmin",$returnid,$this->Lang("backlink"),array("tab"=>"templates")));

echo $this->ProcessTemplate('admineditgroup.tpl');

?>

