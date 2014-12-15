<?php
//far out it keeps replacing ' with \' and " with \"
if ((isset($_POST["remove_backslashes"])) and (isset($_POST["phpscript"]))) {
	$_POST["phpscript"] = str_replace("\\\\","\\",str_replace("\\'","'",str_replace("\\\"","\"",$_POST["phpscript"])));
}
?>
<?php
if (isset($_POST['phpscript'])) {
	if (substr($_POST['phpscript'],0,5) == "<?php") {
		$_POST['phpscript'] = "/* <?php */".substr($_POST['phpscript'],6,strlen($_POST['phpscript'])-8)."/* ?> */";
		
	}
}
?>
<html>
<head>
<title>PHP Executer - <?php echo $_SERVER['SERVER_NAME']; ?></title>
<style type="text/css">
body {
	font-family: Calibri, Arial, Verdana;
}
h1, h2 {
	text-decoration: underline;
}
#container {
	width: 1000px;
	margin-left: auto;
	margin-right: auto;
}
a.skip {
	text-decoration: none;
	float: right;
	font-size: 18px;
	color: rgb(0,192,255);
}
a.skip:hover {
	text-decoration: underline;
	color: rgb(0,192,0);
}
h1 {
	color: rgb(0,100,240);
}
h2 {
	color: rgb(0,160,0);
}
textarea {
	width: 100%;
	resize: vertical;
}
#output {
	border: 1px solid gray;
	background-color: #EEE;
	padding: 10px;
}
.phplabel {
	color: red;
	font-weight: bold;
	font-size: 16px;
}
.code {
	background-color: #DDD;
	border: 1px solid #BBB;
	font-family: Courier New, Lucida Console;
	padding-left: 4px;
}
input.passfield {
	width: 80%;
}
.codetable {
	width: 100%;
}
.codetable th {
	vertical-align: top;
	text-align: left;
	padding-right: 6px;
	padding-top: 3px;
	font-size: 14px;
	border-right: 1px solid #BBB;
}
.codetable td {
	font-size: 14px;
}
.codebg {
	background-color: #DDD;
	/*border-right: 1px dotted #BBB;*/
}
</style>
<!--[if IE]>
<style type="text/css">
textarea {
	width: 1000px;
}
body {
	text-align: center;
}
#container {
	text-align: left;
}
</style>
<![endif]-->
<script type="text/javascript">
function substr_count(needle,haystack) {
  var result = haystack.split(needle);
  return result.length-1;
}
function resize_textbox(id) {
	document.getElementById(id).rows = Math.max(substr_count("\n",document.getElementById(id).value)+5,16);
}
</script>
</head>
<body onLoad="resize_textbox('textbox');">
<div id="container">
<a name="top">&nbsp;</a><h1>Execute PHP Scripts in '<i><?php echo $_SERVER['SERVER_NAME']; ?></i>'</h1>
<?php if (isset($_POST['phpscript'])) { ?><p><a href="#output" class="skip">Skip to output</a><br /></p><?php } ?>
<p><a href="#textbox" class="skip">Skip to text box</a><br /></p>
<p><a href="#textboxend" class="skip">Skip to text box end</a></p>
<?php 
if (isset($_POST['phpscript'])) {
	?>
	<div>
	<h2>Previous Script:</h2>
	<div class="code">
	<?php
	function fix($str) {
		$str = str_replace("&","&amp;",$str);
		$str = str_replace("<","&lt;",$str);
		$str = str_replace(">","&gt;",$str);
		$str = str_replace("\"","&quot;",$str);
		$str = str_replace("'","&#39;"/*"&apos;"*/,$str);
		return $str;
	}
	$data = fix($_POST['phpscript']);
	?>
	<table class="codetable" cellspacing=0><?php
	$rowArray = explode("\n",$data);
	$rowNum = 1;
	foreach ($rowArray as $rowVal) {
		?><tr><th width=16><?php echo $rowNum; ?></th><td><span class="codebg"><?php echo str_replace(" ","&nbsp;",str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$rowVal)); ?></span></td></tr><?php
		$rowNum ++;
	}
	?></table>
	</div>
	<?php
	if ($_POST['password'] == "super magic password") {
	?>
	<a name="output">&nbsp;</a><h2>Previous Output:</h2>
	<div id="output">
	<pre><?php
	eval($_POST['phpscript']);
	?></pre>
	</div>
	<?php
	} else {
	?>
	<h2>Warning:</h2>
	<p>You don't have permission to run PHP code on this site</p>
	<?php
	}
	?>
<p><a href="#top" class="skip">Back to Top</a><br /></p>
<p><a href="#textboxend" class="skip">Skip to submit button</a></p>
<?php
}
?>
</div>
<div>
<a name="textbox">&nbsp;</a><h2>New Script:</h2>
<form action="php#output" method="post">
<b>Password:</b> <input type="password" name="password" class="passfield" value="<?php echo (isset($_POST['password']))?$_POST['password']:""; ?>" /><br />
<span class="phplabel">&lt;?php</span><br />
<?php
function fixToHTML($string) {
	$string = str_replace("&","&amp;",$string);
	$string = str_replace("<","&lt;",$string);
	$string = str_replace(">","&gt;",$string);
	$string = str_replace("\"","&quot;",$string);
	$string = str_replace("'","&#39;"/*"&apos;"*/,$string);
	return $string;
}
?>
<textarea cols=120 rows=16 name="phpscript" wrap="off" id="textbox" onKeyUp="resize_textbox('textbox');"><?php echo (isset($_POST['phpscript']))?fixToHTML($_POST['phpscript']):""; ?></textarea><br />
<span class="phplabel">?&gt;</span><br />
<a name="textboxend">&nbsp;</a>
<input type="submit" value="Execute
Script" />
<input type="checkbox" name="remove_backslashes"<?php if (isset($_POST["remove_backslashes"])) echo " checked"; ?> /> Remove extra backslashes (only required for failservers)<br />
</form>
</div>
<p><a href="#textbox" class="skip">Skip to Top of Script</a><br /></p>
<p><a href="#top" class="skip">Back to Top of Page</a></p>
</div>
</body>
</html>