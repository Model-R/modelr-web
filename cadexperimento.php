<?php session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}
// error_reporting(E_ALL);
// ini_set('display_errors','1');
?><html lang="pt-BR">

<?php


require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');

$tab=$_REQUEST['tab'];
	
if($tab == 4 || $tab == 5){ //tab 4 e 5 não existem mais (tab Dados Bióticos e tab Dados Abióticos)
	//$stab = $tab; $tab = 1;
	$stab = 9; $tab = 1;
}
if($tab == 6){
	$stab = $tab; $tab = 2;		
}
if($tab == 7){ //tab 7 não existe mais (tab Dados Resultados)
	$stab = 13; $tab = 2;		
}
if($tab == 8){
	$stab = $tab; $tab = 3;		
}
if($tab == 9 || $tab == 10){
	//$ttab = $tab; 
	$stab = $tab; $tab = 1;	
}
if($tab == 11 || $tab == 12 || $tab == 18){
	//$ttab = $tab; 
	$stab = $tab; $tab = 1;		
}
if($tab == 13 || $tab == 14 || $tab == 15 || $tab == 16 || $tab == 17){
	//$ttab = $tab; 
	$stab = $tab; $tab = 2;		
}

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
if (empty($tab))
{
	$tab = 1;
}

$Experimento->getStatus($id);
$Experimento->getById($id);
$statusExperiment = $Experimento->statusExperiment;
$nome_experimeto = $Experimento->name;
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R </title>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	
	
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <!-- Bootstrap core CSS -->

    <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
	<link href="css/mainTab.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">
	
	<!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
	<!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />

    <!-- ------------- LEAFLET -------------->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script> 
   <script src = "leaflet/leaflet.editable.js"></script>
   <script src = "leaflet/functions.js"></script>

</head>
<script>
$(function(){
 $('.btn-circle').on('click',function(){
   $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
   $(this).addClass('btn-info').removeClass('btn-default').blur();
 });

 $('.next-step, .prev-step').on('click', function (e){
   var $activeTab = $('.tab-pane.active');

   $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

   if ( $(e.target).hasClass('next-step') )
   {
      var nextTab = $activeTab.next('.tab-pane').attr('id');
      $('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
      $('[href="#'+ nextTab +'"]').tab('show');
   }
   else
   {
      var prevTab = $activeTab.prev('.tab-pane').attr('id');
      $('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
      $('[href="#'+ prevTab +'"]').tab('show');
   }
 });
});
</script>
<body class="nav-md">					

    <?php require "./templates/loading.php";?>					

	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                </div>
            </div>
            <!-- top navigation -->
			<?php require "menutop.php";?>			
				<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="clearfix">
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Experimento: <?php echo $nome_experimeto;?></h2>
									<a style="font-size: 16px" href="consexperimento.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><small> Lista de Experimentos</small></a>
									<div class="clearfix">
									</div>
								</div>
								<div class="x_content">
                                <?php 
                                        // incluir opção de tipo de projeto e filtros automáticos na hora da criação do projeto
                                        // OPÇÃO FOR ALTERAR
                                        
                                    if ($op=='I'){?>
                                        <form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left" novalidate>
                                            <input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                                            <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                                            <div class="">
                                            
                                                <div>
                                                    <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtexperimento">Experimento <span class="required">*</span>
                                                    </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input id="edtexperimento" value="<?php echo $name;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Descrição
                                                    </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="edtdescricao" value="<?php echo $description;?>"  name="edtdescricao" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtgrupo">Grupo
                                                </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="edtgrupo" value="<?php echo $group;?>"  name="edtgrupo" class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>
                                            </div>

												<div class="">
													<div class="item form-group" style="display: flex;align-items: center;">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Tipo do Projeto</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<div class="radio-group-new-experiment">
																<form action="">
																	<div class="radio-terrestre"><input type="radio" name="edttipo" id="edttipoterrestre" value="terrestre" checked/> Terrestre</div>
																	<div class="radio-maritimo"><input type="radio" name="edttipo" id="edttipomaritimo" value="marinho"/> Marinho</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											<?php } ?>
										
                                            </form>
										</div>
											<?php 
											// SO MOSTRO O BOTÃO SE FOR INCLUIR. ASSIM O BOTÃO FICA NA PARTE DE BAIXO DA TELA QUANDO A
											// OPÇÃO FOR ALTERAR
											
										if ($op=='I'){?>
										<div class="form-group">
                                            <div class="new_experiment_send_button">
                                                <button id="send" onclick="enviarExp()" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Salvar experimento">Salvar</button>
                                            </div>
										</div>
										<?php } ?>
									<!--</div>-->
										<?php if ($op=='A')
										{?>
										<form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left" novalidate></form>
										<div class="x_content">
											<!--<div class="" role="tabpanel" data-example-id="togglable-tabs">-->
												<div class="process">
												   <div class="process-row nav nav-tabs">
														<div class="process-step">
														 <button type="button" <?php if ($tab=='1') echo 'class="btn btn-circle btn-info"';?> class="btn btn-default btn-circle" data-toggle="tab" href="#tab_content1"><i class="fa fa-pencil-square-o fa-2x"></i></button>
														 <p><small>Pré-tratamento</small></p>
														</div>
														<div class="process-step">
														 <button type="button" <?php if ($tab=='2') echo 'class="btn btn-circle btn-info"';?> class="btn btn-default btn-circle" data-toggle="tab" href="#tab_content2"><i class="fa fa-gears fa-2x"></i></button>
														 <p><small>Modelagem</small></p>
														</div>
														<div class="process-step">
														 <button type="button" <?php if ($tab=='3') echo 'class="btn btn-circle btn-info"';?> class="btn btn-default btn-circle" data-toggle="tab" href="#tab_content3"><i class="fa fa-globe fa-2x"></i></button>
														 <p><small>Pós-processamento</small></p>
														</div>
												   </div>
												</div>
                                                <!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                    <li role="presentation" <?php //if ($tab=='1') echo 'class="active"';?>><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Pré-tratamento</a>
                                                    </li>
													<li role="presentation" <?php //if ($tab=='2') echo 'class="active"';?>><a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Modelagem</a>
													</li>
													<li role="presentation" <?php //if ($tab=='3') echo 'class="active"';?>><a href="#tab_content3" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Pós-processamento</a>
                                                    </li>
												</ul>-->
												<div id="myTabContent" class="tab-content">
													<div class="tab-pane  <?php if ($tab=='1') echo 'in active';?>" id="tab_content1" aria-labelledby="home-tab">
                                                        <?php require "pretratamentotab.php";?>
													</div> <!-- table panel -->	
													<div  class="tab-pane fade <?php if ($tab=='2') echo 'in active';?>" id="tab_content2" aria-labelledby="home-tab">
                                                        <?php require "modelagemtab.php";?>
                                                    </div> <!-- table panel -->
                                                    <div  class="tab-pane <?php echo 'teste ' . $tab ?> fade <?php if ($tab=='3') echo 'in active';?>" id="tab_content3" aria-labelledby="home-tab">
														<?php require "posprocessamentotab.php";?>
                                                    </div> <!-- table panel -->
												</div> <!-- myTabContent -->
											<!--</div> <!-- tabpanel -->
										</div>
<?php }?>

     <!-- footer content -->
     <footer>
                <div class="" id="demo" style="display:none">
                    
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
    
<script>
        <?php 

require 'MSGCODIGO.php';
$MSGCODIGO = $_REQUEST['MSGCODIGO'];

?>

</script>
    <!--<script src="js/bootstrap.min.js"></script>-->

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>
	<!-- select2 -->
    <script src="js/select/select2.full.js"></script>
	
    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>			

    <script>
        function enviarExp(){
            exibe('loading', 'Criando Experimento');
            if ((document.getElementById('edtexperimento').value==''))
            {
                criarNotificacao('Atenção','Verifique o preenchimento','warning');
            }
            else
            {
                document.getElementById('frm').action='exec.experimento.php';
                document.getElementById('frm').submit();
            }
        }

    </script>

</body>

</html>