<?php session_start();
$path = $_REQUEST['path'];

?>
<html>
<head>
<title>
Model-R
</title>
		<!-- Core CSS - Include with every page -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<!-- SB Admin CSS - Include with every page -->
		<link href="css/sb-admin.css" rel="stylesheet">
		<link href="media/js/demo_table.css" rel="stylesheet">
		<?php include "css.php";?>
		<link href="css/paginacaogwm.css" rel="stylesheet">
		
<link rel='stylesheet' href="fsi-style.css" type='text/css' media='all' />
</head>
<body class="fsi-body">
<script type="text/javascript" src="https://imagens4.jbrj.gov.br/fsi/js/fsiwriter.js"></script>
<script type="text/javascript">
<!--
	writeFlashCode( "https://imagens4.jbrj.gov.br/fsi/viewer/fsi.swf?ImagePath=<?php echo ($path);?>",
		"https://imagens4.jbrj.gov.br/fsi/server?type=image&source=<?php echo ($path);?>",
		"width=100%;height=100%");
// -->
</script>
<noscript>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,65,0" width="400" height="534">
		<param name="movie" value="https://imagens3.jbrj.gov.br/fsi/viewer/fsi.swf?ImagePath=rb%2F1%2F0%2F0%2F2%2F01000002.jpg">
		<param name="allowscriptaccess" value="always" />
		<param name="allowfullscreen" value="true" />
		<param name="quality" value="high" />
		<embed src="https://imagens3.jbrj.gov.br/fsi/viewer/fsi.swf?ImagePath=rb%2F1%2F0%2F0%2F2%2F01000002.jpg"
			width="400"
			height="534"
			allowscriptaccess="always"
			allowfullscreen="true"
			quality="high"
			type="application/x-shockwave-flash"
			pluginspage="https://www.adobe.com/go/getflashplayer">
		</embed>
	</object>
</noscript>
</BODY>
</HTML>

