<?php session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}
if ($_SESSION['s_idtipousuario'] == '5')
{
	header('Location: consexperimento.php');
}
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?><html lang="pt-BR">
<?php
require_once('classes/experimento.class.php');

$Experimento = new Experimento();
$Experimento->conn = $conn;

$id = $_REQUEST['id'];

$extensao2_norte = '6.41';
$extensao2_sul = '-32.490';
$extensao2_leste = '-34';
$extensao2_oeste = '-62';

$Experimento->getById($id);
$extent_model = $Experimento->extent_model;

if(empty($extent_model) || $extent_model == ';;;' || $extent_model == '')
{	
	$extensao1_norte = 0;
    $extensao1_sul = 0;
    $extensao1_leste = 0;
    $extensao1_oeste = 0;
    $has_extent = 'false';
} else {
    $extents = explode(';', $extent_model);
    $extensao1_norte = $extents[2];
    $extensao1_sul = $extents[3];
    $extensao1_leste = $extents[0];
    $extensao1_oeste = $extents[1];
	$has_extent = 'true';
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

	<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #mapMod {
        height: 65%;
      }
	  #map3 {
        height: 65%;
      }
    </style>
	
</head>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Extensão<small></small></h2>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_content">
		 <p style="padding: 5px;">
		 <div id="mapMod"></div>
			<!-- end pop-over -->
		</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_content coordinates">
			<form name='frmextensao' id='frmextensao' action='exec.extensao.php' method="post" class="form-horizontal form-label-left" novalidate>
				<!--<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="shape">Selecionar shape: 
					</label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<select id="shape" onChange="saveShape()" style="display: flex;width: -webkit-fill-available;height: 34px;">
						  <option value="amazonia">Amazônia</option>
						  <option value="caatinga">Caatinga</option>
						  <option value="cerrado">Cerrado</option>
						  <option value="mataatlantica">Mata Atlântica</option>
						  <option value="pampa">Pampa</option>
						  <option value="pantanal">Pantanal</option>
						</select>
					</div>
				</div>-->
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Longitude esquerda: 
					</label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtextensao1_oeste" value="<?php echo $extensao1_oeste;?>"  name="edtextensao1_oeste" class="form-control col-md-7 col-xs-12" >
					</div>
				</div>
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Longitude direita:
					</label>
					 <div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtextensao1_leste" value="<?php echo $extensao1_leste;?>"  name="edtextensao1_leste" class="form-control col-md-7 col-xs-12">
					</div>
				</div>	
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Latitude superior:
					</label>
					 <div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtextensao1_norte" value="<?php echo $extensao1_norte;?>"  name="edtextensao1_norte" class="form-control col-md-7 col-xs-12" >
					</div>
				</div>	
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Latitude inferior:</span>
					</label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtextensao1_sul" value="<?php echo $extensao1_sul;?>"  name="edtextensao1_sul" class="form-control col-md-7 col-xs-12" >
					</div>
				</div>	
			</form>
		</div>
		</div>
	</div>
	<div class="form-group">
			<div class="send-button">
				<button id="send" type="button" onclick="enviarExtensao(12)" class="btn btn-success">Salvar</button>
			</div>
		</div>
</div>
</div> <!-- row -->

<!-- custom notification -->
<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
	</ul>
	<div class="clearfix"></div>
	<div id="notif-group" class="tabbed_notifications"></div>
</div>
	
<!-- SCRIPTS -->

<script src="js/bootstrap.min.js"></script>

<!-- chart js -->
<script src="js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="js/icheck/icheck.min.js"></script>

<script src="js/custom.js"></script>
<!-- form validation -->
<script src="js/validator/validator.js"></script>

<script src="js/loading.js"></script>	

<!-- PNotify -->
<script type="text/javascript" src="js/notify/pnotify.core.js"></script>
<script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>

<script>
<?php require 'MSGCODIGO.php';?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];?>

var extentMap;
var rectangleExtension;

function initMapModelagem() {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>

	if(!extentMap) var mapMod = startMap('mapMod', [-24.5452, -42.5389], 2);
	else mapMod = extentMap;

// [START region_rectangle]
  var bounds = {
    north: <?php echo $extensao1_norte;?>,
    south: <?php echo $extensao1_sul;?>,
    east: <?php echo $extensao1_leste;?>,
    west: <?php echo $extensao1_oeste;?>
  };
	 
  if(<?php echo $has_extent;?>){
		// Define a rectangle and set its editable property to true.
		buildRectangle (mapMod, [bounds.south, bounds.west], [bounds.north, bounds.east]);
		mapMod.on('editable:vertex:dragend', function (e) {
			var ne = e.layer.getBounds().getNorthEast();
			var sw = e.layer.getBounds().getSouthWest();
		
			document.getElementById('edtextensao1_norte').value=ne.lat;
			document.getElementById('edtextensao1_sul').value=sw.lat;
			document.getElementById('edtextensao1_oeste').value=sw.lng;
			document.getElementById('edtextensao1_leste').value=ne.lng;
		});
	  
  }
 
<?php 
	$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
case when lat2 is not null then lat2 else lat end as lat, case when long2 is not null then long2
else long end as long
 from modelr.occurrence, modelr.statusoccurrence where 
							occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
							idexperiment = ".$id. ' 
 and occurrence.idstatusoccurrence in (4,17) ';

//echo $sql; 
$res = pg_exec($conn,$sql);
$conta = pg_num_rows($res);
$marker = '';
	
	$c=0;
	while ($row = pg_fetch_array($res))
	{
		
		// preparo os quadros de informação para cada ponto
		$c++;
		if ($c < $conta) {
			$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."'],";
		}
		else
		{
			$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."']";
			$latcenter = $row['lat'];
			$longcenter = $row['long'];
		}
	}   
?>							
  	var markers = [
        <?php echo $marker;;?>
    ];

    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
			var marker = printMarker (mapMod, [markers[i][1], markers[i][2]], 'green-dot.png', false);        
    }
	extentMap = mapMod;
}

function enviarExtensao(tab)
{	
	//console.log('exec.expextensao.php?tab='+tab+'&id=' + '<?php echo $id?>')
	document.getElementById('frmextensao').action='exec.expextensao.php?tab='+tab+'&id=' + '<?php echo $id?>';
	document.getElementById('frmextensao').submit();
}

$(document).ready(function() {
	initMapModelagem();	
	extentMap.invalidateSize();
});

$('input[type=radio][name=tabs]').change(function(ev) {
	if(ev.target.id == 'tab12'){
		extentMap.invalidateSize();
		var sw = [document.getElementById('edtextensao1_sul').value,document.getElementById('edtextensao1_oeste').value];
		var ne = [document.getElementById('edtextensao1_norte').value,document.getElementById('edtextensao1_leste').value]
		var bounds = [sw, ne];
		fitToBounds(extentMap, bounds)
	}
});
</script>		