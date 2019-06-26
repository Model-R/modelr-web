<?php session_start();
// error_reporting(E_ALL);
// ini_set('display_errors','1');
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}
?><html lang="pt-BR">
<?php
require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$tab = $_REQUEST['tab'];
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

$Experimento->getById($id);
$Experimento->getPath($id);
$idexperiment = $Experimento->idexperiment;//= $row['nomepropriedade'];
$pngCutPath = $Experimento->pngCutPath;
$rasterCutPath = $Experimento->rasterCutPath;
$pngBinPath = $Experimento->pngBinPath;
$pngContPath = $Experimento->pngContPath;
$isImageCut = $Experimento->isImageCut;
$isImageCut = $isImageCut === 't'? true: false;
$pngPath = $Experimento->pngPath;
$tiffPath = $Experimento->tiffPath;
$rasterPngPath = $Experimento->rasterPngPath;
$projection = $Experimento->extent_projection;
$projection = explode(";",$projection);

$rasterPngPath = str_replace("/var/www/html/rafael/modelr","https://model-r.jbrj.gov.br",$rasterPngPath);        
$novoRaster;

if(dirname(__FILE__) != '/var/www/html/rafael/modelr'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
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
	  #map3 {
        height: 65%;
      }
    </style>
</head>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<form name='frmmapa' id='frmmapa' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate></form>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_content map-content">
		<input class="opacity-slider" type="range" min="0" max="1" step="0.1" value="1" onchange="setOpacity(imageOverlay, this.value)" data-toggle="tooltip" data-placement="top" title="Arraste para alterar transparência da imagem no Mapa">
		<?php require "templates/cortarraster.php";?>
		 <div id="map">
		 </div>
			<!-- end pop-over -->
		</div>
	</div>

	</div> <!-- table panel -->

</div>


<!-- custom notification-->

<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
	</ul>
	<div class="clearfix"></div>
	<div id="notif-group" class="tabbed_notifications"></div>
</div>

<!-- scripts -->

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

//---------------------------------- Map Shape Control

var drawingManager;
var selectedShape;
var imageOverlay;
var mapOverlay;
var imageBounds;
var polygonArray = [];

document.getElementById("cancelarCorteRaster").onclick = () => {
    
    removeLayer(mapresult, imageOverlay);
    console.log(rasterPngPath)
    if(rasterPngPath){
        imageOverlay = addImage (mapresult, imageBounds, rasterPngPath)
    } 

    isImageCut = false;
    
	document.getElementById("cancelarCorteRaster").style.display = 'none';
	if(document.getElementById("validarCorteRaster")){
	    document.getElementById("validarCorteRaster").style.display = 'none';
	}

     xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()  {
    }
    xmlhttp.open("GET",'controleCorteRaster.php?op=L&expid=<?php echo $idexperiment; ?>',true);
    xmlhttp.send();
};

var mapresult;

var pngCutPath;
var rasterCutPath;
var isImageCut;
var rasterPngPath;
var typePolygonCut;
var markerVisibility = true;

function initMapExpResultado() {
    if(!mapresult) {
        var mapResult = startMap('map', [-24.5452, -42.5389], 2);
        addDrawControl (mapResult)
        buildCustomControl (
            mapResult, 
            {
                position: 'topleft' 
            }, function (map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                container.innerHTML = "Apagar Polígono";
                container.style.backgroundColor = 'white';
                container.style.width = '100px';
                container.style.height = '30px';
                container.style.padding = '5px 0px 0px 3px';
                container.style.cursor = 'pointer';
                
                container.onclick = function(){
                    eraseRectangles(mapResult)
                }
                return container;
            }
        )
        buildCustomControl (
            mapResult, 
            {
                position: 'topleft' 
            }, function (map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                container.innerHTML = "Cortar Polígono";
                container.style.backgroundColor = 'white';
                container.style.width = '100px';
                container.style.height = '30px';
                container.style.padding = '5px 0px 0px 3px';
                container.style.cursor = 'pointer';
                
                container.onclick = function(){
                    cortarRaster();
                }
                return container;
            }
        )
    }
    else mapResult = mapresult;
    
	//leste oeste norte sul
	//-64.67653000000001;-30.924622499999998;6.404925371814875;-32.03960046758004
    //projection

    imageBounds = [[<?php echo $projection[3]?>, <?php echo $projection[1]?>],
                   [<?php echo $projection[2]?>, <?php echo $projection[0]?>]];

    // if(isImageCut){
    //     imageOverlay = addImage (mapResult, imageBounds, pngCutPath)
    // } else {
    //     imageOverlay = addImage (mapResult, imageBounds, rasterPngPath)
    // }
    mapresult = mapResult;
    printMarkers(mapResult);
}

function typeOfShape(shape){
    if(typeof shape.getPath === "function"){
        return "polygon";
    }else if(typeof shape.getRadius === "function"){
        return "circle";
    }else{
        return "unknown";
    }
}

function printMarkers(map) {
    <?php 
        $sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
        path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
    case when lat2 is not null then lat2 else lat end as lat, case when long2 is not null then long2
    else long end as long
     from modelr.occurrence, modelr.statusoccurrence where 
                                occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
                                idexperiment = ".$id. " and occurrence.idstatusoccurrence in (4,17) ";
    
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
        
        var googleMarkers = [];
        for( i = 0; i < markers.length; i++ ) {
            var marker2 = printMarker (map, [markers[i][1], markers[i][2]], markers[i][7]);            
            googleMarkers.push(marker2);
           
        }
        
        document.getElementById("tooglePontos").onclick = () => {
            for ( i = 0; i < googleMarkers.length; i++ ) {
                if(markerVisibility){
                    eraseMarkers (map)
                } else {
                    
                    addLayer(map, googleMarkers[i]);
                }
            }
            markerVisibility = !markerVisibility;
        };
}

function cortarRaster(){
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            
            removeLayer(mapresult, imageOverlay);
			imageBounds = [[<?php echo $projection[3]?>, <?php echo $projection[1]?>],
                   [<?php echo $projection[2]?>, <?php echo $projection[0]?>]];

            var imagePath = 'https://model-r.jbrj.gov.br/temp/' + <?php echo $id;?> + '/png_map-' + <?php echo $id;?> + '.png?' + Math.random()
            imageOverlay = addImage (mapresult, imageBounds, imagePath)
			<?php 
				$novoRaster = 'https://model-r.jbrj.gov.br/temp/' . $id .'/png_map-' . $id . '.png';
			?>
			isImageCut = true;
			pngCutPath = 'https://model-r.jbrj.gov.br/temp/' + <?php echo $id;?> + '/png_map-' + <?php echo $id;?> + '.png';
			document.getElementById("cancelarCorteRaster").style.display = 'flex';
		}
    }
    let PolygonArrayString = extractPolygonsVertices(mapresult);
    xmlhttp.open("GET",'cutGeoJson.php?table=polygon&array=[' + PolygonArrayString.join(':') + ']&expid=' + <?php echo $id;?>,true);
	xmlhttp.send();
} 

$(document ).ready(function() {
    pngCutPath = <?php echo "'" . $baseUrl . $pngCutPath . "'"; ?>;
    rasterCutPath = <?php echo "'" . $rasterCutPath . "'"; ?>;
    isImageCut = <?php echo "'". $isImageCut . "'" ; ?>;
    rasterPngPath = <?php echo "'". $rasterPngPath . "'"; ?>;
	initMapExpResultado();	
});
		
$('.nav-tabs a[href="#tab_content3"]').click(function(){
	//alert('3');
    $(this).tab('show');
});	

$('.nav-tabs').on('shown.bs.tab', function () {
    initMapExpResultado();
});

$('input[type=radio][name=tabs]').change(function(ev) {
	if(ev.target.id == 'tab8'){
		mapresult.invalidateSize();
	}
});
</script>