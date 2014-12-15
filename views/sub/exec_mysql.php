<?php
//far out it keeps replacing ' with \' and " with \"
if ((isset($_POST["remove_backslashes"])) and (isset($_POST["data"]))) {
	$_POST["data"] = str_replace("\\\\","\\",str_replace("\\'","'",str_replace("\\\"","\"",$_POST["data"])));
}
?>
<html>
<head>
<title>MySQL Executer - <?php echo $_SERVER["SERVER_NAME"]; ?></title>
<?php if (file_exists("mysql.ico")) { ?>
<link rel="icon" href="icons\mysql.ico" type="image/x-icon" />
<?php } ?>
<style type="text/css">
body {
	font-family: Calibri, Arial, Verdana;
}
h1, h2 {
	text-decoration: underline;
}
.code {
	background-color: #CCC;
	border: 1px solid #BBB;
	font-family: Courier New, Lucida Console;
	padding-left: 4px;
}
.success {
	background-color: #CDC;
	border: 1px solid #BCB;
}
.fail {
	background-color: #DCC;
	border: 1px solid #CBB;
}
.resultdiv {
	background-color: #EEE;
	border: 1px solid #DDD;
	padding: 8px;
}
table#results {
	border-right: 1px solid black;
	border-bottom: 1px solid black;
}
#results th, #results td {
	border-top: 1px solid black;
	border-left: 1px solid black;
	padding-left: 2px;
	padding-right: 2px;
}
#results th {
	background-color: #DCE;
	color: #013;
}
#results td {
	background-color: white;
}
#results td.nullcell {
	background-color: #EFE7FF;
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
h2.error {
	color: rgb(192,0,0);
}
.nodbnamenotice {
	font-size: 12px;
	color: orange;
}
textarea {
	width: 100%;
	resize: vertical;
}
/*.codetable, .codetable td, .codetable th {
	border: 1px dotted pink;
}*/
.codetable th {
	vertical-align: top;
	text-align: left;
	padding-right: 6px;
	padding-top: 3px;
	font-size: 14px;
	border-right: 1px solid #BBB;
}
.success .codetable th {
	border-right: 1px solid #BCB;
}
.fail .codetable th {
	border-right: 1px solid #CBB;
}
#newstmt1 {
	background-color: rgb(245,240,225);
	border: 1px solid rgb(205,200,195);
	padding: 8px;
}
#newstmt2 {
	background-color: rgb(240,240,240);
	border: 1px solid rgb(200,200,200);
	border-top: 0px solid black;
	padding: 8px;
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
<?php
function splitMySQLCode($codeStr) {
	$inString = false;
	$strWrapper = "";
	$inFieldName = false;
	$inComment = false;
	$inMultiLineComment = false;
	$split = array();
	$lastStart = 0;
	for ($i = 0; $i < strlen($codeStr); $i ++) {
		$char = substr($codeStr,$i,1);
		if ($i != 0) {
			$prevChar = substr($codeStr,$i-1,1);
		} else {
			$prevChar = "";
		}
		if (($char == "#") and (!$inString)) {
			$inComment = true;
		}
		elseif ((substr($codeStr,$i,3) == "-- ")  and (!$inString)) {
			$inComment = true;
			$i += 2;
		}
		elseif (($char == "\n") and ($inComment)) {
			$inComment = false;
		}
		elseif ((substr($codeStr,$i,2) == "/*") and (!$inString)) {
			$inMultiLineComment = true;
			$i += 1;
		}
		elseif ((substr($codeStr,$i,2) == "*/") and (!$inString) and ($inMultiLineComment)) {
			$inMultiLineComment = false;
			$i += 1;
		}
		elseif (($char == "`") and (!$inString) and (!$inComment) and (!$inMultiLineComment) and (!$inFieldName)) {
			$inFieldName = true;
		}
		elseif (($char == "`") and (!$inString) and (!$inComment) and (!$inMultiLineComment) and ($inFieldName)) {
			$inFieldName = false;
		}
		elseif (($char == "\"") and (!$inString) and (!$inComment) and (!$inMultiLineComment) and (!$inFieldName)) {
			$inString = true;
			$strWrapper = "\"";
		}
		elseif (($char == "\"") and ($inString) and ($strWrapper == "\"") and ($prevChar != "\\")) {
			$inString = false;
			$strWrapper = "";
		}
		elseif (($char == "'") and (!$inString) and (!$inComment) and (!$inMultiLineComment)) {
			$inString = true;
			$strWrapper = "'";
		}
		elseif (($char == "'") and ($inString) and ($strWrapper == "'") and ($prevChar != "\\")) {
			$inString = false;
			$strWrapper = "";
		}
		elseif (($char == ";") and (!$inString) and (!$inFieldName)) { // and (!$inComment) and (!$inMultiLineComment)) {
			$split[sizeof($split)] = substr($codeStr,$lastStart,$i-$lastStart);
			$lastStart = $i+1;
		}
	}
	$split[sizeof($split)] = substr($codeStr,$lastStart);
	return $split;
}
?>
</head>
<body>
<div id="container">
<a name="top"></a>
<?php 
if (file_exists("mysql.ico")) {
?><img src="mysql.ico" style="float:right" /><?php
}
?>
<h1>Execute MySQL Statements in <i><?php echo $_SERVER["SERVER_NAME"]; ?></i></h1>
<p><a href="#textbox" class="skip">Skip to text box</a></p>
<?php
function makeHTMLSafe($string) {
	$string = str_replace("&","&amp;",$string);
	$string = str_replace("<","&lt;",$string);
	$string = str_replace(">","&gt;",$string);
	$string = str_replace("\"","&quot;",$string);
	$string = str_replace("'","&#39;"/*"&apos;"*/,$string);
	$string = str_replace("\n","<br />\n",$string);
	return $string;
}
if (isset($_POST["dbname"])) {
	?><script type="text/javascript">alert("<?php echo $POST["dbaction"]; ?>")</script><?php
	$_POST["data"] = $_POST["dbaction"]." DATABASE ".$_POST["dbname"];
}
if (isset($_POST["database"])) {
	$database = $_POST["database"];
	$username = $_POST["username"];
	$password = $_POST["password"];
} elseif (isset($_POST["dbname"])) {
	$database = $_POST["dbname"];
	$username = $_POST["username"];
	$password = $_POST["password"];
} else {
	$database = "";
	$username = "";
	$password = "";	
}
if (isset($_POST["data"])) {
	if ($username == "") {
		?><div><h2 class="error">Error:</h2>Supply a username.</p></div><?php
	} elseif (!@mysql_connect("localhost", $username, $password)) {
		?><div><h2 class="error">Error:</h2><p>Connection to MySQL server failed.</p><p><b>MySQL Error Message:</b><br /><?php echo mysql_error(); ?></p></div><?php
	} elseif (($database != "") and (!@mysql_select_db($database))) {
		?><div><h2 class="error">Error:</h2><p>Connection to the server's database <i><?php echo $database; ?></i> failed.</p><p><b>MySQL Error Message:</b><br /><?php echo mysql_error(); ?></p></div><?php
	} else {
		$splitData = splitMySQLCode($_POST["data"]);
		$queryCount = sizeof($splitData);
		if (($queryCount > 1) and ($splitData[$queryCount-1] == "")) {
			unset($splitData[$queryCount-1]);
			$queryCount --;
		}
		?><h2>Previous Statement<?php echo ($queryCount==1)?"":"s (".$queryCount.")"; ?>:</h2><?php
		foreach ($splitData as $data)
			{
			$data = trim($data);
			?>
			<div class="resultdiv">
			<?php
			$result = mysql_query($data);
			?>
			<div class="code <?php echo ($result)?"success":"fail"; ?>">
			<?php
			if (substr_count($data,"\n") == 0) {
				if (strlen($data) == 0) {
					echo "&nbsp;";
				} else {
					echo makeHTMLSafe($data);
				}
			} else {
				?>
				<table class="codetable" cellspacing=0><?php
				$rowArray = explode("\n",makeHTMLSafe($data));
				$rowNum = 1;
				foreach ($rowArray as $rowVal) {
					?><tr><th><?php echo $rowNum; ?></th><td><?php echo $rowVal; ?></td></tr><?php
					$rowNum ++;
				}
				?></table><?php
			}
			?>
			</div>
			<?php
			if ($result) {
				if (gettype($result) == "resource") {
					$recordNum = mysql_num_rows($result);
					?><p><b>Execution Successful and<?php echo ($recordNum == 0)?" Empty":(($recordNum >= 1000)?" Enormous":(($recordNum >= 100)?" Large":"")); ?> Resource Returned<?php echo ($recordNum > 1)?" (".$recordNum." Records)":(($recordNum == 1)?" (Single Record)":""); ?>:</b></p><?php
					if (mysql_num_rows($result) == 0) {
						$fields = array();
						while ($fieldRow = mysql_fetch_field($result)) {
							$fields[sizeof($fields)] = $fieldRow->name;
						}
					} else {
						$fields = array_keys(mysql_fetch_assoc($result));
						mysql_data_seek($result,0);
					}
					$data = array();
					$i = 0;
					while ($row = mysql_fetch_assoc($result)) {
						$data[$i] = $row;
						$i += 1;
					}
					?><table cellspacing=0 id="results">
					<tr><?php
					foreach ($fields as $fieldname) {
						?><th><?php echo $fieldname; ?></th><?php
					}
					?></tr><?php
					foreach ($data as $record) {
						?><tr><?php
						foreach ($fields as $fieldname) {
							$entry = $record[$fieldname];
							if (($entry == "") or ($entry == null)) {
								$isEmpty = true;
								$entry = "&nbsp;";
							} else {
								$isEmpty = false;
							}
							?><td<?php echo $isEmpty?" class=\"nullcell\"":""; ?>><?php echo $entry; ?></td><?php
						}
						?></tr><?php
					}
					?></table><?php
				} else {
					?><p><b>Execution Successful.</b></p><?php
				}
			} else {
				?><p><b>Execution Failed.</b></p><p><b>MySQL Error Message:</b><br /><?php echo makeHTMLSafe(mysql_error()); ?></p><?php
			}
			?></div><br /><?php
		}
	}
}
?>
<div>
<h2>New Statement:</h2><a name="textbox"></a>
<form action="sql" method="post">
<?php if (!isset($_POST["username"])) {?> <span class="nodbnamenotice">If you don't enter a database name, no database is selected</span><?php } ?>
<div id="newstmt1">
<table>
<tr><td><b>Database:</b></td><td><input type="text"     name="database" value="<?php echo makeHTMLSafe($database); ?>" /></td></tr>
<tr><td><b>Username:</b></td><td><input type="text"     name="username" value="<?php echo makeHTMLSafe($username); ?>" /></td></tr>
<tr><td><b>Password:</b></td><td><input type="password" name="password" value="<?php echo makeHTMLSafe($password); ?>" /></td></tr>
</table>
</div>
<?php
function fixForTextArea($string) {
	$string = str_replace("&","&amp;",$string);
	$string = str_replace("<","&lt;",$string);
	$string = str_replace(">","&gt;",$string);
	$string = str_replace("\"","&quot;",$string);
	$string = str_replace("'","&#39;"/*"&apos;"*/,$string);
	return $string;
}
?>
<div id="newstmt2">
<textarea cols=120 rows=16 name="data"><?php echo (isset($_POST["data"]))?fixForTextArea($_POST["data"]):""; ?></textarea><br />
<input type="submit" value="Execute
Query" />
<input type="checkbox" name="remove_backslashes"<?php if (isset($_POST["remove_backslashes"])) echo " checked"; ?> /> Remove extra backslashes (only required for failservers)<br />
</div>
</form>
</div>
<p><a href="#top" class="skip">Back to top</a></p>
</div>
</body>
</html>