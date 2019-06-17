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
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();

$id=$_REQUEST['id'];
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
	
	<link href="css/metadados.css" rel="stylesheet" type="text/css" media="all">

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


    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	
</head>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Metadados<small></small><a  class="btn btn-default btn-sm" onClick="imprimir();" data-toggle="tooltip" data-placement="top" title="Baixar CSV" style="margin-top: 4px;">CSV</a></h2>
			<div class="clearfix"></div>
<!--			<table class="table table-striped" style="table-layout: fixed;width: 100%;">
   
    <tbody>
	<thead>
<tr>
<th>nome de espécies</th>
<th>número de registros liberados</th>
<th>variáveis</th>
<th>algoritmos</th>
<th>partitions</th>
<th>número de pseudo ausência</th>
<th>threshold cutoff</th>
<th>buffer</th>
</tr>
</thead>
	<?php
	$ws = file_get_contents("https://model-r.jbrj.gov.br/ws/?id=" . $id);
	$json = json_decode($ws);
	
	$particao = $json[0]->num_partition;
	#buffer
	$buffer = $json[0]->buffer;
	#pseudo
	$num_points = $json[0]->num_points;
	#tss
	$tss = $json[0]->tss;
	#resolution
	$resolution = $json[0]->resolution;
	
	$occurrenceList = $json[0]->occurrences;
	$organizedArray = [$json[0]->occurrences[0]->taxon];
	foreach($occurrenceList as $occurrence){
		if(!in_array($occurrence->taxon, $organizedArray)){
			array_push($organizedArray,$occurrence->taxon);
		}
	}
	
	$rasterList = [];
	foreach($json[0]->raster as $raster){
		if(!in_array($raster->raster, $rasterList)){
			array_push($rasterList,$raster->raster);
		}
	}
	
	$algorithmList = [];
	foreach($json[0]->algorithm as $algorithm){
		if(!in_array($algorithm->algorithm, $algorithmList)){
			array_push($algorithmList,$algorithm->algorithm);
		}
	}

?>

    </tbody>
  </table>-->
  
<div class="panel panel-default">
    
	<?php 
		foreach($organizedArray as $item){
			$count = 0;
			foreach($occurrenceList as $o){
				if($o->taxon == $item){
					if($o->idstatusoccurrence == 4 || $o->idstatusoccurrence == 17){
						$count = $count + 1;
					}
				}
			}
	?>
	<div class="panel-heading metadados-title" ><?php echo $item; ?></div>
	<div class="panel-body">
	
		<fieldset class="col-md-6 metadados-fieldset">    	
			<legend>Número de registros liberados</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo $count; ?></p>
				</div>
			</div>
			
		</fieldset>
		<fieldset class="col-md-6 metadados-fieldset">     	
			<legend>Variáveis</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo implode(", ",$rasterList); ?></p>
				</div>
			</div>
			
		</fieldset>	
		<fieldset class="col-md-6 metadados-fieldset">     	
			<legend>Resolução</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo $resolution; ?></p>
				</div>
			</div>
			
		</fieldset>	
		<fieldset class="col-md-6 metadados-fieldset">     	
			<legend>Algoritmos</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo implode(", ",$algorithmList); ?></p>
				</div>
			</div>
			
		</fieldset>
		<fieldset class="col-md-6 metadados-fieldset">    	
			<legend>Partitions</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo $particao; ?></p>
				</div>
			</div>
			
		</fieldset>	
		<fieldset class="col-md-6 metadados-fieldset">    	
			<legend>Número de pseudo ausência</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo $num_points; ?></p>
				</div>
			</div>
			
		</fieldset>
		<fieldset class="col-md-6 metadados-fieldset">    	
			<legend>Threshold cutoff</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo $tss; ?></p>
				</div>
			</div>
			
		</fieldset>	
		<fieldset class="col-md-6 metadados-fieldset">    	
			<legend>Buffer</legend>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<p><?php echo $buffer; ?></p>
				</div>
			</div>
			
		</fieldset>
		
		<div class="clearfix"></div>
	</div>
	
	<?php 
		}
	?>
                
</div>
        </div>
            </div>
                </div>
				
<!-- scripts -->

<script>
function imprimir(tipo){
	document.getElementById('frmdadosestatisticos').target="_blank";//"'cons<?php echo strtolower($FORM_ACTION);?>.php';
	document.getElementById('frmdadosestatisticos').action='exportCSV.php?table=data&expid=<?php echo $id;?>';
	document.getElementById('frmdadosestatisticos').submit();
} 
</script>