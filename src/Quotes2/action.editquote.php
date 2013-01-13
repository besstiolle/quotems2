<?php
if (!isset($gCms)) exit;

if (!isset($params["todo"])) exit;


$inerror=false;
//print_r($params);die();
$params["tab"]="quotes";
$quoteid="";
if ($params["todo"]!="add" && !isset($params["quoteid"])) {
	echo "Internal error"; exit;
} else {
	if (isset($params["quoteid"])) $quoteid=$params["quoteid"];
}
$type="";
if (isset($params["type"])) $type=$params["type"];

switch ($params["todo"]) {
	case "delete" : {
		//echo $locationid;
		$this->DeleteQuote($quoteid);
		$params["module_message"]=$this->Lang("quotedeleted");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "update" :
	case "save" : {
		if (!isset($params["type"]) || $params["type"]=="") {
			echo $this->ShowErrors($this->Lang("missingtype"));
			$inerror=true;
			break;
		}
		if (!isset($params["content"]) || $params["content"]=="") {
			echo $this->ShowErrors($this->Lang("missingcontent"));
			$inerror=true;
			break;
		}
		/*if (!isset($params["description"]) || $params["description"]=="") {
			echo $this->ShowErrors("Beskrivelse skal angives");
			$inerror=true;
			break;
			}*/
		//print_r($params);
		if ($params["todo"]=="save") {
			$quoteid=$this->AddQuote($type);
		}
		$this->SetQuoteProp($quoteid,"content",$params["content"]);
		$this->SetQuoteProp($quoteid,"textid",$params["textid"]);
		switch ($type) {
			//$this->SetDescriptionProp($descriptionid,"title",$params["title"]);
			case "1" : {
				$this->SetQuoteProp($quoteid,"author",$params["author"]);
				$this->SetQuoteProp($quoteid,"reference",$params["reference"]);
				break;
			}
			case "2" : {
				
			}
		}

		$groups=$this->GetGroups();
		if (!empty($groups)) {
			$this->ClearConnections($quoteid);
			foreach ($groups as $group) {
				if (isset($params["conn".$group["id"]]) && $params["conn".$group["id"]]=="1") {
					$this->SetConnection($quoteid,$group["id"]);
				}
			}
		}


		if ($params["todo"]=="save") {
			$params["module_message"]=$this->Lang("quoteadded");
		} else {
			$params["module_message"]=$this->Lang("quoteupdated");
		}
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
}


$content="";
$textid="";
$author="";
$reference="";

if ($params["todo"]=="edit" || $params["todo"]=="copy") {
	$thisquote=$this->GetQuote("",$quoteid);
	//print_r($thisquote);
	$content=$thisquote["content"];
	$textid=$thisquote["textid"];
	switch ($type) {
		case 1 : {
			$author=$thisquote["author"];
			$reference=$thisquote["reference"];
			break;
		}
		case 2 : {
			$rssparsing=$thisquote["rssparsing"];
			break;
		}
	}

}

if (isset($params["content"])) $content=$params["content"];
if (isset($params["textid"])) $textid=$params["textid"];
switch($type) {
	case 1 : {
		if (isset($params["author"])) $author=$params["author"];
		if (isset($params["reference"])) $reference=$params["reference"];
		break;
	}
	case 2 : {
		if (isset($params["rssparsing"])) $rssparsing=$params["rssparsing"];
		break;
	}
}


$newtodo="";
if ($inerror) {
	$newtodo=$params["todo"];
} else {
	if ($params["todo"]=="edit") $newtodo="update";
	if ($params["todo"]=="add" || $params["todo"]=="copy") $newtodo="save";
}


$this->smarty->assign('formstart',$this->CreateFormStart($id,"editquote",$returnid,"post","",false,"",array("todo"=>$newtodo,"quoteid"=>$quoteid,"type"=>$type)));
$this->smarty->assign('formend',$this->CreateFormEnd());

$this->smarty->assign('quotetextid',$this->Lang("quotetextid"));
$this->smarty->assign('quotetextidhelp',$this->Lang("quotetextidhelp"));
$this->smarty->assign('textidinput',$this->CreateInputText($id,"textid",$textid,32,40));

switch ($type) {
	case 1 : {
		$this->smarty->assign('quotecontent',$this->Lang("quotecontent"));
		$usewysiwyg=($this->GetPreference("allowwysiwyg","0")=="1");
		$this->smarty->assign('contentinput',$this->CreateTextArea($usewysiwyg,$id,$content,"content",'pagesmalltextarea','','','',80,6));

		$this->smarty->assign('quoteauthor',$this->Lang("quoteauthor"));
		$this->smarty->assign('authorinput',$this->CreateInputText($id,"author",$author,40,100));

		$this->smarty->assign('quotereference',$this->Lang("quotereference"));
		$this->smarty->assign('referenceinput',$this->CreateInputText($id,"reference",$reference,40,100));
		break;
	}
	case 2 : {
		$this->smarty->assign('rssurltext',$this->Lang("rssquotecontent"));
		$this->smarty->assign('rssurlinput',$this->CreateInputText($id,"content",$content,80,255));

		$this->smarty->assign('rssparsingtext',$this->Lang("rssparsingtext"));
		$this->smarty->assign('rssparsinginput',$this->CreateInputText($id,"rssparsing",$rssparsing,80,255));
		$this->smarty->assign('rssparsinghelp',$this->Lang("rssparsinghelp"));
		break;

	}
}


$this->smarty->assign('type',$type);

$groups=$this->GetGroups();

$groupsinput="";
if (TRUE == empty($groups)) {
	$this->smarty->assign('groupsinput', $this->Lang("nogroups"));
} else {
	foreach ($groups as $group) {
		$name=$group["description"];
		if ($name=="") $name=$group["textid"];
		$groupsinput.=$this->CreateInputCheckbox($id,"conn".$group["id"],"1",$this->GetConnection($quoteid,$group["id"]));
		$groupsinput.=$this->CreateLabelForInput($id,"conn".$group["id"],$name);
		$groupsinput.="<br/>";
	}
	$this->smarty->assign('groupsinput', $groupsinput);
}
$this->smarty->assign('groupstext', $this->Lang("groups"));

$titleaction="";
switch($params["todo"]) {
	case "add" : $titleaction=$this->Lang("addingquote"); break;
	case "copy" : $titleaction=$this->Lang("copyingquote"); break;
	case "edit" : $titleaction=$this->Lang("editingquote"); break;
}

$this->smarty->assign('titleaction', $titleaction);

if ($params["todo"]=="edit") {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("updatequote")));
} else {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("addquote")));
}

$this->smarty->assign('backlink', $this->CreateLink($id,"defaultadmin",$returnid,$this->Lang("backlink"),array("tab"=>"quotes")));

echo $this->ProcessTemplate('admineditquote.tpl');




?>