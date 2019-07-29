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
require_once('classes/tipoparticionamento.class.php');

$Experimento = new Experimento();
$Experimento->conn = $conn;

$TipoParticionamento = new TipoParticionamento();
$TipoParticionamento->conn = $conn;

$id = $_REQUEST['id'];

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
$liberado = false;

$sql = 'SELECT CAST(CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS BIT) FROM modelr.occurrence WHERE idstatusoccurrence = 17 AND idexperiment = '.$id;
$res = pg_exec($conn,$sql);
$row = pg_fetch_array($res);
if($row[0] == '1') $liberado = true;
else $liberado = false;

if (empty($num_partition))
{
    $num_partition = 3;
}
if (empty($numpontos))
{
    $numpontos = 1000;
}
if (empty($tss))
{
    $tss = 0.6;
}
if (empty($buffer))
{
    $buffer = 'mean';
    $_REQUEST['edtbuffer'][0] = 'mean';
} else $_REQUEST['edtbuffer'][0] = $buffer;

if (empty($resolution))
{
    $resolution = '10';
    $_REQUEST['edtresolution'][0] = '10';
} else $_REQUEST['edtresolution'][0] = $resolution;

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
	<link href="css/modelagem.css" rel="stylesheet">
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

<div id="msg-erro-modelagem">
	<span id="text-msg-erro-modelagem">Não foi possível realizar a Modelagem.</span>
</div>

<div class="row" id="modelagem-row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Modelagem <small></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form name='frmdadosmodelgem' id='frmdadosmodelgem' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate>
					<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
					<input id="id" value="<?php echo $id;?>" name="id" type="hidden">
					
					<div class="col-md-7 col-sm-7 col-xs-7">
							<div class="item form-group" id="partition_type_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Tipo Particionamento <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php echo $TipoParticionamento->listaCombo('cmboxtipoparticionamento',$idtipoparticionamento,'N','class="form-control"');?>
								</div>
							</div>
							<div class="item form-group" id="repetition_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Num. de Repetições <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input onchange="document.getElementById('lblnumrepetitions').value=this.value" id="edtnumrepetitions" value="<?php echo $repetitions;?>" type="range" min='1' max='10' name="edtnumrepetitions" class="form-control col-md-7 col-xs-12" required="required"><span id="lbl3"></span>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lblnumrepetitions" onchange="document.getElementById('edtnumrepetitions').value= this.value " value="<?php echo $repetitions;?>"  name="lblnumrepetitions" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor inteiro">
								</div>
							</div>
							<div class="item form-group" id="num_partition_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Num. de Partições <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input onchange="document.getElementById('lblnumparticoes').value=this.value" id="edtnumparticoes" value="<?php echo $num_partition;?>" type="range" min='3' max='50' name="edtnumparticoes" class="form-control col-md-7 col-xs-12" required="required"><span id="lbl3"></span>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lblnumparticoes" onchange="document.getElementById('edtnumparticoes').value= this.value " value="<?php echo $num_partition;?>"  name="lblnumparticoes" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor inteiro entre 3 e 50">
								</div>
							</div>
							<div class="item form-group" id="trainpercent_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">% Treino<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input onchange="document.getElementById('lbltrainpercent').value=this.value" id="edtlbltrainpercent" value="<?php echo $trainpercent;?>" type="range" min='0' max='100' name="edttrainpercent" class="form-control col-md-7 col-xs-12" required="required"><span id="lbl3"></span>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lbltrainpercent" onchange="document.getElementById('edttrainpercent').value= this.value " value="<?php echo $trainpercent;?>"  name="lbltrainpercent" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Porcentagem de Teste">
								</div>
							</div>
							<div class="item form-group" id="num_pontos_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Num. de Pontos <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input onchange="document.getElementById('lblnumpontos').value=this.value" id="edtnumpontos" value="<?php echo $numpontos;?>" type="range" min='100' max='2000' name="edtnumpontos" class="form-control col-md-7 col-xs-12" required="required"><span id="lbl2"></span>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lblnumpontos" onchange="document.getElementById('edtnumpontos').value= this.value " value="<?php echo $numpontos;?>"  name="edtnumpontos" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor inteiro entre 100 e 2000">
								</div>

							</div>
							<div class="item form-group" id="tss_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">TSS<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input onchange="document.getElementById('lbltss').value=this.value" id="edttss" value="<?php echo $tss;?>" type="range" min='0' max='1' step='0.1' name="edttss" class="form-control col-md-3 col-xs-5" required="required">
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lbltss" onchange="document.getElementById('edttss').value= this.value " value="<?php echo $tss;?>"  name="lbltss" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor decimal entre 0 e 1 (exemplo: 0.3)">
								</div>
							</div>
							<div class="item form-group" id="buffer_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Buffer<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="radio-group-buffer">
										<div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbufferfalse" value="NULL" <?php if ($_REQUEST['edtbuffer'][0]=='NULL') echo "checked";?> />Nenhuma</div>
										<div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbuffermedim" value="mean" <?php if ($_REQUEST['edtbuffer'][0]=='mean') echo "checked";?>/>Média</div>
										<div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbuffermedian" value="median" <?php if ($_REQUEST['edtbuffer'][0]=='median') echo "checked";?>/>Mediana</div>
										<div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbuffermax" value="max" <?php if ($_REQUEST['edtbuffer'][0]=='max') echo "checked";?>/>Máxima</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lblbuffer" onchange="parseEdtBuffer()" value="<?php echo $buffer;?>"  name="lblbuffer" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor entre mínima,média,mediana e máxima">
								</div>
							</div>
							<!--<div class="item form-group" id="resolution_item">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="resolution">Resolução
								</label>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="radio-group-buffer">
										<div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer2_5" value="2.5" <?php if ($_REQUEST['edtresolution'][0]=='2.5') echo "checked";?> />2.5</div>
										<div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer5" value="5" <?php if ($_REQUEST['edtresolution'][0]=='5') echo "checked";?>/>5</div>
										<div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer10" value="10" <?php if ($_REQUEST['edtresolution'][0]=='10') echo "checked";?>/>10</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<input id="lblresolution" onchange="document.getElementById('edtresolution').value= this.value " value="<?php echo $resolution;?>"  name="lblresolution" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor entre 2.5,5,10">
								</div>
							</div>-->
					</div>
					<div class="col-md-5 col-sm-5 col-xs-5">
						<div class="x_panel">
							<div class="x_title">
								<h2>Algoritmos <small>Marque os algoritmos que deseja utilizar</small></h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							 <p style="padding: 5px;">
							 <?php $sql = 'select * from modelr.algorithm';
							 $res = pg_exec($conn,$sql);
							 while ($row = pg_fetch_array($res))
							 {
								 ?>
								 <?php if($row['idalgorithm'] == 1 || $row['idalgorithm'] == 4 || $row['idalgorithm'] == 7) {?>
									<input <?php if ($Experimento->usaAlgoritmo($id,$row['idalgorithm'])) echo "checked";?> type="checkbox" name="algoritmo[]" id="checkalgoritmo<?php echo $row['idalgorithm'];?>" value="<?php echo $row['idalgorithm'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['algorithm'];?>
										<br />
								 <?php } else { ?>
									<input <?php if ($Experimento->usaAlgoritmo($id,$row['idalgorithm'])) echo "checked";?> type="checkbox" name="algoritmo[]" id="checkalgoritmo<?php echo $row['idalgorithm'];?>" value="<?php echo $row['idalgorithm'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['algorithm'];?>
										<br />
								 <?php } ?>
								 
							 <?php } ?>
								<!-- end pop-over -->

							</div>
						
						</div>				
					</div>
				</form>
			</div>
		</div>
		<div class="form-group">
				<div class="send-button">
					<button id="send" type="button" onclick="enviarDadosModelagem(6)" class="btn btn-success">Salvar</button>
					<?php if ($liberado) { 
						    if($_SESSION['s_idtipousuario'] == '2') {?>
								<button type="button" class="btn btn-success" onClick='liberarExperimento(6)'>Liberar Experimeto para Modelagem</button>
								<button type="button" class="btn btn-success" onClick='executarModelagem(6)'>Executar Modelagem</button>							
							<?php } 
							if($_SESSION['s_idtipousuario'] == '3') {?>
								<button type="button" class="btn btn-success" onClick='liberarExperimento(6)'>Liberar Experimeto para Modelagem</button>
							<?php } 
							if($_SESSION['s_idtipousuario'] == '6') {?>
								<button type="button" class="btn btn-success" onClick='executarModelagem(6)'>Executar Modelagem</button>							
							<?php } ?>
					<?php } ?>
				</div>
			</div>
			<?php
				if ($liberado == false) {?>
					<div style="display: flex; justify-content: center; margin-top: 50px;">
						<span style="font-size: 16px;color: red;"> * Marque um ponto como "Conferido (Liberado para Modelagem)" para habilitar o botão de Liberar Experimento</span>
					</div>
				<?php
				}
			?>
	</div>

</div> <!-- row -->

<!-- custom notification-->

<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
	</ul>
	<div class="clearfix"></div>
	



</div>


<!-- script -->

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

var msgcodigo = <?php if($MSGCODIGO){
						echo $MSGCODIGO;
				} else {
					echo 0;
				}?>;

if(msgcodigo == 76) {
	document.getElementById('text-msg-erro-modelagem').innerHTML = 'Não foi possível realizar a Modelagem. Menos de 10 Ocorrências.'
	document.getElementById('modelagem-row').className += " erro-modelagem";
	document.getElementById('msg-erro-modelagem').style.display = 'block';
}
				
if(msgcodigo == 77) {
	document.getElementById('text-msg-erro-modelagem').innerHTML = 'Não foi possível realizar a Modelagem.'
	document.getElementById('modelagem-row').className += " erro-modelagem";
	document.getElementById('msg-erro-modelagem').style.display = 'block';
}


function enviarDadosModelagem(tab)
{
	document.getElementById('frmdadosmodelgem').action='exec.dadosmodelagem.php?tab='+tab+'&id=' + '<?php echo $id?>';
	document.getElementById('frmdadosmodelgem').submit();
}	
		
$('#lblbuffer').keydown(function (e) {

    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();   
    } else {
        var key = e.keyCode; 
        if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }

    }

});

function parseLblBuffer(){
    if(document.getElementById('edtbuffer').value == 1){
        document.getElementById('lblbuffer').value = 'mínima';
    } 
    else if(document.getElementById('edtbuffer').value == 2){
        document.getElementById('lblbuffer').value = 'média';
    }
    else if(document.getElementById('edtbuffer').value == 3){
        document.getElementById('lblbuffer').value = 'mediana';
    }
    else if(document.getElementById('edtbuffer').value == 4){
        document.getElementById('lblbuffer').value = 'máxima';
    }
}

function parseEdtBuffer(){
    if(document.getElementById('lblbuffer').value == 'mínima'){
        document.getElementById('edtbuffer').value = 1;
    } 
    else if(document.getElementById('lblbuffer').value == 'média'){
        document.getElementById('edtbuffer').value = 2;
    }
    else if(document.getElementById('lblbuffer').value == 'mediana'){
        document.getElementById('edtbuffer').value = 3;
    }
    else if(document.getElementById('lblbuffer').value == 'máxima'){
        document.getElementById('edtbuffer').value = 4;
    }
}

function liberarExperimento(tab){
	document.getElementById('frm').action='exec.experimento.php?page=dc&op=LE&id=' + <?php echo $id;?>;
	document.getElementById('frm').submit();
}

function executarModelagem(tab){
	exibe('loading', 'Processando ...')
	document.getElementById('frmdadosmodelgem').action='setupmodelagem.php?expid=' + <?php echo $id;?>;
	document.getElementById('frmdadosmodelgem').submit();
}


var tipopartionamento
$("#cmboxtipoparticionamento").change(function(){
	tipopartionamento = document.getElementById('cmboxtipoparticionamento').value;
	if(tipopartionamento == 1){ //crossvalidation
		console.log('crossvalidation')
		document.getElementById('num_partition_item').style.display = 'block';
		document.getElementById('trainpercent_item').style.display = 'none';
	}
	else if (tipopartionamento == 2){ //bootstrap
		console.log('bootstrap')
		document.getElementById('num_partition_item').style.display = 'none';
		document.getElementById('trainpercent_item').style.display = 'block';
	}
});

tipopartionamento = <?php echo $idtipoparticionamento;?> + '';
console.log(tipopartionamento)
if(tipopartionamento == 0 || tipopartionamento == 1){ //crossvalidation
	console.log('crossvalidation')
	document.getElementById('num_partition_item').style.display = 'block';
	document.getElementById('trainpercent_item').style.display = 'none';
}
else if (tipopartionamento == 2){ //bootstrap
	console.log('bootstrap')
	document.getElementById('num_partition_item').style.display = 'none';
	document.getElementById('trainpercent_item').style.display = 'block';
}

</script>	