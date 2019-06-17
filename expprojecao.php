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

$Experimento->getById($id);
$projection_model = $Experimento->extent_projection;
$extent_model = $Experimento->extent_model;

if(empty($projection_model) || $projection_model == ';;;' || $projection_model == ''){
    if(empty($extent_model) || $extent_model == ';;;' || $extent_model == ''){	
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
} else {
    $extents = explode(';', $projection_model);
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
      #mapModProjecao {
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
			<h2>Projeção<small></small></h2>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_content">
		 <p style="padding: 5px;">
		 <div id="mapModProjecao"></div>
			<!-- end pop-over -->
		</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_content coordinates">
			<form name='frmprojecao' id='frmprojecao' action='exec.projecao.php' method="post" class="form-horizontal form-label-left" novalidate>
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Longitude esquerda: 
					</label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtprojecao1_oeste" value="<?php echo $extensao1_oeste;?>"  name="edtprojecao1_oeste" class="form-control col-md-7 col-xs-12" >
					</div>
				</div>
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Longitude direita:
					</label>
					 <div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtprojecao1_leste" value="<?php echo $extensao1_leste;?>"  name="edtprojecao1_leste" class="form-control col-md-7 col-xs-12">
					</div>
				</div>	
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Latitude superior:
					</label>
					 <div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtprojecao1_norte" value="<?php echo $extensao1_norte;?>"  name="edtprojecao1_norte" class="form-control col-md-7 col-xs-12" >
					</div>
				</div>	
				<div class="item form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-4" for="email">Latitude inferior:</span>
					</label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<input id="edtprojecao1_sul" value="<?php echo $extensao1_sul;?>"  name="edtprojecao1_sul" class="form-control col-md-7 col-xs-12" >
					</div>
				</div>	
			</form>
		</div>
		</div>
	</div>
	<div class="form-group">
			<div class="send-button">
				<button id="send" type="button" onclick="enviarProjecao(18)" class="btn btn-success">Salvar</button>
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

var projectionMap;
var rectangleExtension;

function initMapProjecao() {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>

	if(!projectionMap) var mapModProjecao = startMap('mapModProjecao', [-24.5452, -42.5389], 2);
	else mapModProjecao = projectionMap;

  
// [START region_rectangle]
  var bounds = {
    north: <?php echo $extensao1_norte;?>,
    south: <?php echo $extensao1_sul ;?>,
    east: <?php echo $extensao1_leste ;?>,
    west: <?php echo $extensao1_oeste ;?>
  };
  
  if(<?php echo $has_extent;?>){
	// Define a rectangle and set its editable property to true.
		buildRectangle (mapModProjecao, [bounds.south, bounds.west], [bounds.north, bounds.east]);
		  
	    mapModProjecao.on('editable:vertex:dragend', function (e) {
			var ne = e.layer.getBounds().getNorthEast();
			var sw = e.layer.getBounds().getSouthWest();

			document.getElementById('edtprojecao1_norte').value=ne.lat;
			document.getElementById('edtprojecao1_sul').value=sw.lat;
			document.getElementById('edtprojecao1_oeste').value=sw.lng;
			document.getElementById('edtprojecao1_leste').value=ne.lng;
			
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
		var marker = printMarker (mapModProjecao, [markers[i][1], markers[i][2]], 'green-dot.png', false);            
    }
	projectionMap = mapModProjecao;
}

function enviarProjecao(tab)
{	
	//console.log('exec.expextensao.php?tab='+tab+'&id=' + '<?php echo $id?>')
	document.getElementById('frmprojecao').action='exec.expprojecao.php?tab='+tab+'&id=' + '<?php echo $id?>';
	document.getElementById('frmprojecao').submit();
}

$(document ).ready(function() {
	initMapProjecao();	
});

// $('.nav-tabs a[href="#tab_content18"]').click(function(){
// 	google.maps.event.trigger(window, 'resize', {});
// 	initMapProjecao();
// })

// $('.nav-tabs').on('shown.bs.tab', function () {
// 	google.maps.event.trigger(window, 'resize', {});
// 	initMapProjecao();
// });

$('input[type=radio][name=tabs]').change(function(ev) {
	if(ev.target.id == 'tab18'){
		projectionMap.invalidateSize();
		var sw = [document.getElementById('edtprojecao1_sul').value,
			document.getElementById('edtprojecao1_oeste').value];
		var ne = [document.getElementById('edtprojecao1_norte').value,
			document.getElementById('edtprojecao1_leste').value]
		var bounds = [sw, ne];
		fitToBounds(projectionMap, bounds)
	}
});
</script>		