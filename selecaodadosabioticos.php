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
require_once('classes/fonte.class.php');

$Experimento = new Experimento();
$Experimento->conn = $conn;

$Fonte = new Fonte();
$Fonte->conn = $conn;

$msgcodigo = $_REQUEST['MSGCODIGO'];

$idsource = $_REQUEST['cmboxfonte'];

$Experimento->getById($id);
$idexperiment = $Experimento->idexperiment;//= $row['nomepropriedade'];
$idproject = $Experimento->idproject ;//= $row['nomepropriedade'];
$name = $Experimento->name ;//= $row['inscricaoestadual'];
$description = $Experimento->description ;//= $row['inscricaoestadual'];
$idtipoparticionamento = $Experimento->idpartitiontype;
$num_partition = $Experimento->num_partition; //definindo 3 como padrão
$buffer = $Experimento->buffer;
$resolution = $Experimento->resolution;
$repetitions= $Experimento->repetitions;
$trainpercent= $Experimento->trainpercent;
$numpontos = $Experimento->num_points;
$tss = $Experimento->tss;
$extent_model = $Experimento->extent_model;

if (empty($resolution))
{
    $resolution = '10';
}

if(dirname(__FILE__) !== '/var/www/html/rafael/modelr'){
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
      #mapMod {
        height: 65%;
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

<body>
	<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Dados Abióticos <small></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form name='frmmodelgem' id='frmmodelgem' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate>
					
					<div class="item form-group" id="resolution_item">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="resolution">Resolução
						</label>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="radio-group-buffer">
								<div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer2_5" value="2.5" <?php if ($resolution=='2.5') echo "checked";?> />2.5</div>
								<div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer5" value="5" <?php if ($resolution=='5') echo "checked";?>/>5</div>
								<div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer10" value="10" <?php if ($resolution=='10') echo "checked";?>/>10</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2">
							<input id="lblresolution" onchange="document.getElementById('edtresolution').value= this.value " value="<?php echo $resolution;?>"  name="lblresolution" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor entre 2.5,5,10">
						</div>
					</div>
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Fonte<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php 
							$sqlsource = "select distinct idsource from modelr.experiment_use_raster eur,
	modelr.raster r where
	eur.idraster = r.idraster and eur.idexperiment = ".$idexperiment." limit 1 ";
	$ressource = pg_exec($conn,$sqlsource);
	$rowsource = pg_fetch_array($ressource);
							
							 if (!empty($_REQUEST['cmboxfonte']))
			 {
				 $idsource = $_REQUEST['cmboxfonte'];
			 }
			 else
			 {
				 $idsource = $rowsource['idsource'];
			 }
							
							echo $Fonte->listaCombo('cmboxfonte',$idsource ,'onchange="atualizarTab(11)"','class="form-control"');?>
						</div>
					</div>
			   <div class="x_content">
			 <p style="padding: 5px;">
			 <?php 
				
			if($idsource == 1){
				include_once "templates/biooracleparams.php";
			}
			else if($idsource == 2 || $idsource == 3) {
				$sql = 'select * from modelr.raster where idsource = '.$idsource;
	
				$res = pg_exec($conn,$sql);
				while ($row = pg_fetch_array($res))
				{
					?>
	<!--                                           <input type="checkbox" name="raster[]" id="checkraster<?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['raster'];?>
						<br />
	-->		
					<input <?php if ($Experimento->usaRaster($id,$row['idraster'])) echo "checked";?> type="checkbox" name="raster[]" id="checkraster<?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['raster'];?>
						<br />


						
			 <?php }
			 
			} else if($idsource == 4){
				include_once "templates/chelsa.php";
			} else if($idsource == 5){
				include_once "templates/pca.php";
			}?>	 
				<!-- end pop-over -->

			</div>
				<!-- end pop-over -->

			
				<!-- end pop-over -->
				
			</form>
			</div>
		</div>
		<div class="form-group">
				<div class="send-button">
					<button id="send" type="button" onclick="enviarDadosAbioticos(11)" class="btn btn-success">Salvar</button>
					<button id="correlation" type="button" onclick="calcularCorrelacao(11)" class="btn btn-success">Calcular Correlação</button>
				</div>
			</div>
	</div>
	<?php if (file_exists($baseUrl . 'temp/' . $id . '/correlation-' . $id . '.png')) { ?>
		<div class="col-md-6 col-sm-6 col-xs-12" style="text-align: center;">
			<img src="<?php echo $baseUrl;?>temp/<?php echo $id;?>/correlation-<?php echo $id;?>.png?<?php echo rand();?>">
		</div>
	<?php } ?>
	</div> <!-- row -->

	<!-- CUSTOM NOTIFICATION -->

	<div id="custom_notifications" class="custom-notifications dsp_none">
		<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
		</ul>
		<div class="clearfix"></div>
		<div id="notif-group" class="tabbed_notifications"></div>
	</div>

	<!-- ---------------------- SCRIPTS ---------------------------- -->
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

	function teste () {
		console.log('teste');
	}
	function enviarDadosAbioticos(tab)
	{
		document.getElementById('frmmodelgem').action='exec.dadosabioticos.php?tab='+tab+'&id=' + '<?php echo $id?>';
		document.getElementById('frmmodelgem').submit();
	}	
			
	function atualizarTab(tab)
	{
		var source = document.getElementById('cmboxfonte').value;
		document.getElementById('frmmodelgem').action="cadexperimento.php?op=A&id="+ '<?php echo $id?>' +"&tab="+tab + "&cmboxfonte=" + source;
		document.getElementById('frmmodelgem').submit();
	}
	
	function calcularCorrelacao (tab) {
		exibe('loading','Calculando');
		document.getElementById('frmmodelgem').action='exec.calcularcorrelacao.php?tab='+tab+'&id=' + '<?php echo $id?>';
		document.getElementById('frmmodelgem').submit();
	}

	</script>
</body>
</html>