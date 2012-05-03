<?php
$lang["friendlyname"]="Quotes Made Simple";
$lang["permission"]="Manage Quotes";
$lang["description"]="Quote Made Simple allows easy insertion of a selection of quotes";
$lang["accessdenied"]="Access denied";
$lang["backlink"]="<< Back";
$lang["installpostmessage"]="The Quotes Made Simple module was correctly installed. Please consider attaching the Quotes-stylesheet to your template(s)";
$lang["uninstallpostmessage"]="The Quotes Made Simple module was successfully uninstalled";

$lang["nomatchingquotes"]="Sorry, no quotes were matching the parameters. So bringing my favorite one: 'All those moments will be lost in time, like tears in the rain.'";

$lang["quotestab"]="Quotes";
$lang["grouptab"]="Groups";
$lang["templatetab"]="Templates";
$lang["csstab"]="Stylesheet";
$lang["settings"]="Settings";
$lang["applychanges"]="Apply changes";
$lang["actions"]="Actions";

$lang["notemplates"]="No templates";
$lang["templates"]="Templates";
$lang["addtemplate"]="Add template";
$lang["savetemplate"]="Save template";
$lang["templatename"]="Template name";
$lang["templatecontent"]="Content";
$lang["templateupdated"]="Template updated";
$lang["templatedeleted"]="Template deleted";
$lang["templateadded"]="Template added";
$lang["templatereset"]="Template reset to default";
$lang["deletetemplate"]="Delete template";
$lang["resettemplate"]="Reset template to default";
$lang["confirmdeletetemplate"]="Are you sure this template should be deleted?";
$lang["confirmtempaltereset"]="Are you sure this template should be reset to the default value?";
$lang["missingname"]="A name must be provided for the template";


$lang["groups"]="Groups";
$lang["nogroups"]="No groups";
$lang["textid"]="Group text ID";
$lang["groupdescription"]="Group description";
$lang["missingtextid"]="A text id must be provided";
$lang["textidinuse"]="Text id already in use";
$lang["confirmdeletegroup"]="Are you sure this group shuld be deleted?";
$lang["savegroup"]="Save group";
$lang["addgroup"]="Add group";
$lang["updategroup"]="Update group";
$lang["groupadded"]="Group added";
$lang["groupdeleted"]="Group deleted";
$lang["deletegroup"]="Delete group";
$lang["groupupdated"]="Group updated";

$lang["quotes"]="Quotes";
$lang["noquotes"]="No quotes";
$lang["quotetextid"]="Quote text ID";
$lang["quotetextidhelp"]="This optional field can be used to select a specific quote";
$lang["quoteauthor"]="Quote author";
$lang["quotereference"]="Quote reference";
$lang["quotecontent"]="Quote content";

$lang["rssquotecontent"]="RSS-url";
$lang["rssparsingtext"]="RSS-parsing info";
$lang["rssparsinghelp"]="This is not used presently, but will be in the future I suspect";

$lang["confirmdeletequote"]="Are you sure this quote shuld be deleted?";
$lang["savequote"]="Save quote";
$lang["addquote"]="Add quote";
$lang["addingquote"]="Adding quote";
$lang["updatequote"]="Update quote";
$lang["quoteadded"]="Quote added";
$lang["quotedeleted"]="Quote deleted";
$lang["deletequote"]="Delete quote";
$lang["editingquote"]="Editing quote";
$lang["quoteupdated"]="Quote updated";
$lang["missingcontent"]="You must provide some content for this quote-type";


$lang["quotetype"]="Quote type";
$lang["plainquote"]="Plain text quote";
$lang["rssquote"]="Quote from an RSS feed";
$lang["javascriptquote"]="Quote inserted by JavaScript-snippet";

$lang["stylesheet"]="Stylesheet";
$lang["savestylesheet"]="Save stylesheet";
$lang["resetstylesheet"]="Reset stylesheet to default";
$lang["confirmresetstylesheet"]="Are you sure you want to reset the stylesheet to default?";
$lang["stylesheetreset"]="The stylesheet was reset to default";
$lang["stylesheetupdated"]="The stylesheet was updated";

$lang["allowwysiwyg"]="Allow wysiwyg";
$lang["savesettings"]="Save settings";
$lang["settingssaved"]="Settings saved";

$lang["parampickedbyhelp"]="How to pick the quote among the candidates, allow values are 
'random' (which pick a random quote), 
'equal' (which tries to make sure all quotes are shown approximately the same number of times,
'day' (which selects the quote of the day maintaining that for 24 hours and not repeating it until all relevant quotes have been used
<br/>
Note that this setting can be more or less relevant regarding the actualy source of the quotes.";
$lang["paramtemplatehelp"]="Use this template to show the quotes";
$lang["paramgroupshelp"]="Only show quotes attached to this/these groups, should contain a groupname or more seperated by commas.";
$lang["paramquoteshelp"]="Only show specific quote(s) specified by their text-id, seperated by commas. This overrides the groups-parameter.";

$lang["templatehelp"]=<<<EOF
These smarty-values are passed on to the template:<br/>
{quoteauthor}, {quotereference}, {quotecontent}, {quoteexposures}<br/>
For RSS-quotes: {quoterssdescription} also mapped as {quotecontent}, {quotersstitle} also mapped as {quoteauthor}<br/>
For JavaScript-quotes: {quotejavascript} also mapped as {quotecontent}
EOF;


$lang["help"]=<<<EOF
This module allows easy maintenance and insertion of quotes into your pages/templates. The quotes can be attached to groups
and several options for selection of quote to show is available.
<br/>
Among the planned features are retrieval of quotes from external sources like RSS-feeds and text/xml-files on the server.
<h3>Usage</h3>
Insert a module-call like this
<pre>
{Quotes <i>params</i>}
</pre>
into your page or template.

EOF;

?>