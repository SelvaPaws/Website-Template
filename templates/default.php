<html>
<head>
	<title><?php echo $this->pageTitle; ?> - SiteName</title>
	<link rel="stylesheet" type="text/css" href="/css/_.css" />
<?php if (file_exists('css/'.strtolower($_URI[0]).'.css')) { ?>
	<link rel="stylesheet" type="text/css" href="/css/<?php echo strtolower($_URI[0]); ?>.css" />
<?php }
if (file_exists('favicon.ico')) { ?>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<!--[if IE]>
	<link href="favicon.ico" rel="shortcut icon" />
	<![endif]-->
<?php } ?>
<script type="text/javascript">
function onLoad() {}
</script>
</head>

<body onLoad="onLoad();">
	<div id="site-wrapper">
		<div id="view-container">
			<?php //include("templates/navbar.php"); ?>
			<?php include("templates/header.php"); ?>
			<div id="view-body-container">
				<div id="view-body">
					<?php require("views/".$this->viewName.".php"); ?>
				</div>
			</div>
		</div>
		<?php include("templates/footer.php"); ?>
	</div>
</body>
</html>