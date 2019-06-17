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
require_once('classes/fonte.class.php');
require_once('classes/statusoccurrence.class.php');

$Experimento = new Experimento();
$Experimento->conn = $conn;

$TipoParticionamento = new TipoParticionamento();
$TipoParticionamento->conn = $conn;

$Fonte = new Fonte();
$Fonte->conn = $conn;

$StatusOccurrence = new StatusOccurrence();
$StatusOccurrence->conn = $conn;

$idsource = $_REQUEST['cmboxfonte'];

$especie = $_REQUEST['edtespecie'];
$tab = $_REQUEST['secundarytab'];

$extensao2_norte = '6.41';
$extensao2_sul = '-32.490';
$extensao2_leste = '-34';
$extensao2_oeste = '-62';

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

if(empty($extent_model) || $extent_model == ';;;' || $extent_model == '')
{
    $extensao1_norte = '-2.60';
    $extensao1_sul = '-34.03';
    $extensao1_leste = '-34.70';
    $extensao1_oeste = '-57.19';
} else {
    $extents = explode(';', $extent_model);
    $extensao1_norte = $extents[2];
    $extensao1_sul = $extents[3];
    $extensao1_leste = $extents[1];
    $extensao1_oeste = $extents[0];
}
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
<body class="nav-md">

<!-- loading-  Carregando... -->
			<div id="loading" style="display: none;  
					background: #FFFFFF;  
					position: absolute;  
					width: 400px;  
					top: 50%;  
					left: 50%;  
					margin-left: -200px;  
					margin-top: -100px;  
					border-style: solid;  
					border-color: black;  
					border-width: 1px;  
					text-align: center;  
					text-transform: uppercase;  
					font-family: arial;  
					font-weight: bold;  
					color: black;  
					z-index: 3;">  
				<br><img alt="Loading..." src="images/ajax-loader.gif" width="150">  
				<br>Processando...  
				<br> 
			</div> 
		
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel2">Arquivo CSV</h4>
				</div>
				<div class="modal-body">
					<h4>Selecione o Arquivo</h4>
					<form action="/action_page.php">
						<input type="file" name="pic" accept="image/*" class="form-control">
					</form>
					<p></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary">Enviar</button>
				</div>
			</div>
		</div>
	</div>
	
	 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Editar ponto</h4>
                </div>
                <div class="modal-body">
                    <h4><div id="divtaxon"></div></h4>
                    <p>Dados originais<br>
                    <div id="dadosoriginais"></div><br>
                    <div id="divimagem"></div><br>
                    <b>Dados inferidos</b><br>
                    <?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence',$idstatusoccurrence,'N','class="form-control"','1,4,6,7,16,17');?>
                    <br>
                    Latitude:<input type="text" name="edtlatitude" id="edtlatitude" class="form-control"><br>
                    Longitude:<input type="text" name="edtlongitude" id="edtlongitude" class="form-control"><br>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="edidocorrencia" id="edidocorrencia">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="atualizarPontos(document.getElementById('edidocorrencia').value,document.getElementById('cmboxstatusoccurrence').value,document.getElementById('edtlatitude').value,document.getElementById('edtlongitude').value)">Salvar</button>
                </div>

            </div>
        </div>
    </div>

	 <div class="modal fade" id="myModalstatusoccurrence" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Status Ocorrência</h4>
                </div>
                <div class="modal-body">
                    <p>
                    <?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence222',$idstatusoccurrence222,'N','class="form-control"','1,4,6,7,16,17');?>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="atualizarPontos('',document.getElementById('cmboxstatusoccurrence222').value)">Salvar</button>
                </div>

            </div>
        </div>
    </div>								
								
								
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    
					<?php //require "menu.php";?>
                </div>
            </div>

				<!-- page content -->
			<div class="right_col_mod" role="main">
				<div class="">
					<div class="clearfix">
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								
								<div class="x_content">
									<form name='frmmodelgem' id='frmmodelgem' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate>
										<input id="op" value="<?php echo $op;?>" name="op" type="hidden">
										<input id="id" value="<?php echo $id;?>" name="id" type="hidden">
										<input id="edtexperimento" value="<?php echo $name;?>" name="edtexperimento" type="hidden">
										<input id="edtdescricao" value="<?php echo $description;?>" name="edtdescricao" type="hidden">
										
										
										<div class="x_content">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" <?php if ($tab=='5') echo 'class="active"';?>><a href="#tab_content5" id="home-tab" role="tab"  data-toggle="tab"  aria-expanded="true">Dados Abióticos</a>
                                                    </li>
                                                    <li role="presentation" <?php if ($tab=='6') echo 'class="active"';?>><a href="#tab_content6" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Extensão</a>
													</li>
													<li role="presentation" <?php if ($tab=='7') echo 'class="active"';?>><a href="#tab_content7" id="home-tab" role="tab"  data-toggle="tab"  aria-expanded="true">Modelagem</a>
													</li>
												</ul>
												<div id="myTabContent" class="tab-content">
										
                         <div  class="tab-pane fade <?php if ($tab=='6') echo 'in active';?>" id="tab_content6" >
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Extensão Criação <small></small></h2>
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
								</div>
								</div>
                            </div>
                            <div class="form-group">
                                    <div class="send-button">
                                        <button id="send" type="button" onclick="enviarModelagem(6)" class="btn btn-success">Salvar</button>
                                    </div>
                                </div>
                        </div>
						</div> <!-- row -->
						</div> <!-- table panel -->
                        
						<div class="tab-pane fade<?php if ($tab=='5') echo ' in active';?>" id="tab_content5">
						
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dados Abióticos <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								
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
												
												echo $Fonte->listaCombo('cmboxfonte',$idsource ,'onchange="atualizarTab(4)"','class="form-control"');?>
                                            </div>
                                        </div>
                                   <div class="x_content">
								 <p style="padding: 5px;">
								 <?php 
								
								 if($idsource != 1) {
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
                                 
                                 } else {
                                    include_once "templates/biooracleparams.php";
                                 }?>	 
                                    <!-- end pop-over -->

                                </div>
                                    <!-- end pop-over -->

                                
                                    <!-- end pop-over -->
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="send-button">
                                        <button id="send" type="button" onclick="enviarModelagem(5)" class="btn btn-success">Salvar</button>
                                    </div>
                                </div>
                        </div>
						
						</div> <!-- row -->
						</div> <!-- table panel -->
						<!--
						active out
						active in 
						-->
						<div class="tab-pane fade<?php if ($tab=='7') echo ' in active';?>" id="tab_content7" >
						
						<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Modelagem <small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
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
                                                    <div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbufferfalse" value="FALSE" <?php if ($_REQUEST['edtbuffer'][0]=='false') echo "checked";?> />Nenhuma</div>
                                                    <div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbuffermedim" value="mean" <?php if ($_REQUEST['edtbuffer'][0]=='mean') echo "checked";?>/>Média</div>
                                                    <div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbuffermedian" value="median" <?php if ($_REQUEST['edtbuffer'][0]=='median') echo "checked";?>/>Mediana</div>
                                                    <div><input onchange="document.getElementById('lblbuffer').value=this.value" type="radio" name="edtbuffer[]" id="checkbuffermax" value="max" <?php if ($_REQUEST['edtbuffer'][0]=='max') echo "checked";?>/>Máxima</div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input id="lblbuffer" onchange="parseEdtBuffer()" value="<?php echo $buffer;?>"  name="lblbuffer" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor entre mínima,média,mediana e máxima">
                                            </div>
                                        </div>
										<div class="item form-group" id="resolution_item">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resolution">Resolução
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="radio-group-buffer">
                                                    <div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer2_5" value="2.5" <?php if ($_REQUEST['edtresolution'][0]=='2.5') echo "checked";?> />2.5</div>
                                                    <div><input onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer5" value="5" <?php if ($_REQUEST['edtresolution'][0]=='5') echo "checked";?>/>5</div>
                                                    <div><input checked onchange="document.getElementById('lblresolution').value=this.value" type="radio" name="edtresolution[]" id="checkbuffer10" value="10" <?php if ($_REQUEST['edtresolution'][0]=='10') echo "checked";?>/>10</div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input id="lblresolution" onchange="document.getElementById('edtresolution').value= this.value " value="<?php echo $resolution;?>"  name="lblresolution" class="form-control col-md-2 col-xs-12" data-toggle="tooltip" data-placement="top" title="Valor entre 2.5,5,10">
                                            </div>
                                        </div>
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
                                           <input <?php if ($Experimento->usaAlgoritmo($id,$row['idalgorithm'])) echo "checked";?> type="checkbox" name="algoritmo[]" id="checkalgoritmo<?php echo $row['idalgorithm'];?>" value="<?php echo $row['idalgorithm'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['algorithm'];?>
                                            <br />
									 
								 <?php } ?>
                                    <!-- end pop-over -->

                                </div>
                            
                            </div>
										
									</div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="send-button">
                                        <button id="send" type="button" onclick="enviarModelagem(7)" class="btn btn-success">Salvar</button>
                                        <?php
                                            if ($liberado && $_SESSION['s_idtipousuario'] != '5') {?>
                                                <button type="button" class="btn btn-success" onClick='liberarExperimento(7)'>Liberar Experimeto para Modelagem</button>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                    if ($liberado == false) {?>
                                        <div style="display: flex; justify-content: center; margin-top: 50px;">
                                            <span> * Marque um ponto como "Conferido (Liberado para Modelagem)" para habilitar o botão de Liberar Experimento</span>
                                        </div>
                                    <?php
                                    }
                                ?>
                        </div>

                        </div> <!-- row -->
						</div> <!-- table panel -->
						
						
						</div> <!-- myTabContent -->
						
						
						
						</div> <!-- tabpanel -->
						</div>
						
										
						
						
						
						
						
						</div> <!-- div class="" -->
						</form>
						</div>
										
                                        <!-- <div class="ln_solid"></div>
										<div class="form-group">
                                            <div class="col-md-6 col-md-offset-5">
                                                <button id="send" type="button" onclick="enviar()" class="btn btn-success">Salvar</button>
                                            </div>
                                        </div> -->
										
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- footer content -->
            <footer>
                <div class="">
                    
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
                
            </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

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

// This example adds a user-editable rectangle to the map.
function selecionaTodos2(isChecked) {
	//alert('');
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos2').checked;
				
	}
	
}

function selecionaTodos(isChecked) {
	//alert('');
	var chks = document.getElementsByName('table_records[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos').checked;
				
	}
	
}

function atualizarTab(tab)
{
	//$('.nav-tabs a[href="#tab_content5"]').tab('show')
	document.getElementById('frmmodelgem').action="cadexperimento.php?op=A&id="+ '<?php echo $id?>' +"&tab="+tab+"&secundarytab=5";
	document.getElementById('frmmodelgem').submit();
}

var mainMap;
var rectangleExtension;

function initMapModelagem() {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>

  var mapMod = new google.maps.Map(document.getElementById('mapMod'), {
    center: {lat: -24.5452, lng: -42.5389},
    mapTypeId: 'terrain',
    gestureHandling: 'greedy',
        mapTypeControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['terrain','roadmap', 'satellite']
        },
        styles: [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#FFA800"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": "#53FF00"},
                    {"saturation": -73},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": "#FBFF00"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": "#00FFFD"},
                    {"saturation": 0},
                    {"lightness": 30},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#00BFFF"},
                    {"saturation": 6},
                    {"lightness": 8},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#679714"},
                    {"saturation": 33.4},
                    {"lightness": -25.4},
                    {"gamma": 1}
                ]
            }
        ],
   // center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 2
  });

/*    var map2 = new google.maps.Map(document.getElementById('map2'), {
    center: {lat: -24.5452, lng: -42.5389},
    //center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 2
  });
*/
  
// [START region_rectangle]
  var bounds1 = {
    north: <?php echo $extensao1_norte;?>,
    south: <?php echo $extensao1_sul ;?>,
    east: <?php echo $extensao1_leste ;?>,
    west: <?php echo $extensao1_oeste ;?>
  };

/*  var bounds2 = {
    north: <?php echo $extensao2_norte;?>,
    south: <?php echo $extensao2_sul ;?>,
    east: <?php echo $extensao2_leste ;?>,
    west: <?php echo $extensao2_oeste ;?>
  };
  */
  // Define a rectangle and set its editable property to true.
  var rectangle = new google.maps.Rectangle({
    bounds: bounds1,
    editable: true,
	draggable: true
  });


/*  var rectangle2 = new google.maps.Rectangle({
    bounds: bounds2,
    editable: true,
	draggable: true
  });
  */
  // [END region_rectangle]
  rectangle.setMap(mapMod);
 // rectangle2.setMap(map2);
  
  rectangle.addListener('bounds_changed', showNewRect);
  
  rectangleExtension = rectangle;
  
   function showNewRect(event) {
        var ne = rectangle.getBounds().getNorthEast();
        var sw = rectangle.getBounds().getSouthWest();

        document.getElementById('edtextensao1_norte').value=ne.lat();
        document.getElementById('edtextensao1_sul').value=sw.lat();
        document.getElementById('edtextensao1_oeste').value=sw.lng();
        document.getElementById('edtextensao1_leste').value=ne.lng();
		
      }
 
/*  rectangle2.addListener('bounds_changed', showNewRect2);
  
   function showNewRect2(event) {
        var ne = rectangle2.getBounds().getNorthEast();
        var sw = rectangle2.getBounds().getSouthWest();

        document.getElementById('edtextensao2_oeste').value=ne.lat();
        document.getElementById('edtextensao2_sul').value=sw.lat();
        document.getElementById('edtextensao2_leste').value=sw.lng();
        document.getElementById('edtextensao2_norte').value=ne.lng();
		
      }
 */
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

    // Info Window Content
	
//	var infoWindowContent = [
//		<?php echo $info;?>
 //   ];

//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
//    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
       // bounds.extend(position);
//		var icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
//		if (markers[i][7]!='')
//		{
//			icone = 'http://maps.google.com/mapfiles/ms/icons/'+markers[i][7];
//		}
		
    /*    marker = new google.maps.Marker({
            position: position,
            map: map2,
			draggable: false,
            title: markers[i][0]
        });
      */  
		marker2 = new google.maps.Marker({
            position: position,
            map: mapMod,
			draggable: false,
            title: markers[i][0]
        });
        
    }
	mainMap = mapMod;
}

function contaSelecionados(objeto)
{
    var chks = objeto;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		if (chks[i].checked){
			conta = conta + 1;
		}
	}
	return conta;
}

function abreModelStatusOcorrencia()
{
	if (contaSelecionados(document.getElementsByName('table_records[]'))>0)
	{
		$('#myModalstatusoccurrence').modal('show');
	}
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja alterar o status','warning');
	}
}


function enviarModelagem(tab)
		{
			//exibe('loading', 'Processando ...');
            //console.log(document.getElementById('frmmodelgem'));
			document.getElementById('frmmodelgem').action='exec.modelagem.php?secundarytab='+tab+'&id=' + '<?php echo $id?>';
			document.getElementById('frmmodelgem').submit();
		}	
		
		
function saveShape()
{
	//exibe('loading', 'Processando ...');
	console.log('shape ', document.getElementById('shape').value);
	//document.getElementById('shape').value
	//document.getElementById('frmmodelgem').submit();
	printshape()
}	

function printshape()
{	
	console.log('entrou print shape')
	console.log(mapOverlay, 'overlay')
	if(mapOverlay) mapOverlay.setMap(null);
	imageBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(-33.77584, -73.94917),
        new google.maps.LatLng(5.224162 , -34.84917));
		
	document.getElementById('edtextensao1_norte').value= -73.98005; //xmin
	document.getElementById('edtextensao1_sul').value= -43.6135; //xmax
	document.getElementById('edtextensao1_oeste').value=5.250803; //ymax
	document.getElementById('edtextensao1_leste').value=-16.30544; //ymin
		
	var path = 'http://model-r.jbrj.gov.br/v2/shapes/amazonia/imagem-brasil (1).png';
	mapOverlay = new google.maps.GroundOverlay(path,imageBounds,{opacity:0.7});
		
	rectangleExtension.setMap(null);
	mapOverlay.setMap(mainMap);
}	

function getShapeExtent () {
	
}

    </script>
	
    <script>
	
	

<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];

?>

$(document ).ready(function() {
	//alert('');
 	//$('.nav-tabs a[href="#tab_content<?php echo $tab;?>"]').tab('show')
	initMapModelagem();
	
});
		
$('.nav-tabs a[href="#tab_content3"]').click(function(){
    $(this).tab('show');
})	

$('.nav-tabs a[href="#tab_content4"]').click(function(){
    // setTimeout(function() {
    //     $('#tab_content5').addClass('active in');
	// }, 500) 
    // console.log($('#tab_content5'))
})

$('.nav-tabs a[href="#tab_content6"]').click(function(){
	google.maps.event.trigger(window, 'resize', {});
        initMapModelagem();
})

$('.nav-tabs').on('shown.bs.tab', function () {
    google.maps.event.trigger(window, 'resize', {});
    initMapModelagem();
    initMap();
  });

$('.nav-tabs a[href="#tab_content4"]').click(function(){
	setTimeout(function() {
        $('#tab_content7').addClass('active in');
	}, 500)
})

function toggle(isChecked) {
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=isChecked
	}
}	
	
// initialize the validator function
validator.message['date'] = 'not a real date';

// validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
$('form')
	.on('blur', 'input[required], input.optional, select.required', validator.checkField)
	.on('change', 'select.required', validator.checkField)
	.on('keypress', 'input[required][pattern]', validator.keypress);

$('.multi.required')
	.on('keyup blur', 'input', function () {
		validator.checkField.apply($(this).siblings().last()[0]);
	});

// bind the validation to the form submit event
//$('#send').click('submit');//.prop('disabled', true);

$('form').submit(function (e) {
	e.preventDefault();
	var submit = true;
	// evaluate the form using generic validaing
	if (!validator.checkAll($(this))) {
		submit = false;
	}

	if (submit)
		this.submit();
	return false;
});

/* FOR DEMO ONLY */
$('#vfields').change(function () {
	$('form').toggleClass('mode2');
}).prop('checked', false);

$('#alerts').change(function () {
	validator.defaults.alerts = (this.checked) ? false : true;
	if (this.checked)
		$('form .alert').remove();
}).prop('checked', false);

function liberarExperimento(tab){
	if(<?php echo $_SESSION['s_idtipousuario'];?> == 6 ){
		exibe('loading', 'Processando ...')
		document.getElementById('frm').action='setupmodelagem.php?expid=' + <?php echo $id;?>;
		document.getElementById('frm').submit();
	} else {
		document.getElementById('frm').action='exec.experimento.php?page=dc&op=LE&id=' + <?php echo $id;?>;
		document.getElementById('frm').submit();
	} 
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

</body>

</html>