<?php session_start();
?><!DOCTYPE html>
<html lang="pt-BR">
<?php	  
require_once('classes/conexao.class.php');
require_once('classes/usuario.class.php');
require_once('classes/situacaousuario.class.php');
require_once('classes/tipousuario.class.php');
require_once('classes/instituicao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Usuario = new Usuario();
$Usuario->conn = $conn;

$SituacaoUsuario = new SituacaoUsuario();
$SituacaoUsuario->conn = $conn;

$TipoUsuario = new TipoUsuario();
$TipoUsuario->conn = $conn;

$Instituicao = new Instituicao();
$Instituicao->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

if ($op=='A')
{
	$Usuario->getById($id);
	$nome = $Usuario->name;
	$senha = $Usuario->senha;
	$login = $Usuario->login;
	$email = $Usuario->email;
	$idtipousuario = $Usuario->idusertype;
	$idsituacaousuario = $Usuario->idstatususer;
	$idinstituicaousuario = $Instituicao->idinstituicao;
	
}

//echo $Usuario->idtecnico.'Rafael';
//exit;

?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cad. Usuário</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

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


<!-- Small modal -->
                                <div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Trocar Senha</h4>
                                            </div>
											<form name="frmsenha" id="frmsenha" class="form-horizontal form-label-left" action="exec.trocarsenha.php">
                                            <div class="modal-body">
												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Senha</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='id' name='id' type="hidden" class="form-control" value="<?php echo $id;?>">
												<input id='edtsenha' name='edtsenha' type="password" class="form-control" value="">
												</div>
												</div>

												<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Nova</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='edtnovasenha' name='edtnovasenha' type="password" class="form-control" value="">
												</div>
												</div>
                                                <div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Confirmar</label>
												<div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id='edtconfirmacao' name='edtconfirmacao' type="password" class="form-control" value="">
												</div>
												</div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
											</form>

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
            <!-- top navigation -->
			<?php require "menutop.php";?>

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="">

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><a href='consusuario.php'>Cad. Usuário <small>Cadastro de usuários</small></a></h2>
                                    <!-- <ul class="nav navbar-right panel_toolbox">
                                                                            <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                Ação
                                <span class="caret"></span>
                            </a>
                                        <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="cadusuario.php?op=I">Novo</a>
                                            </li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" onClick='showExcluir()'>Excluir</a>
                                            </li>
                                            <li role="presentation" class="divider"></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="imprimir('xls')">Gerar XLS</a>
                                            </li>
                                        </ul>
                                    </li>
                                    </ul> -->
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form name="form" action="exec.usuario.php" method="post" id="form" class="form-horizontal form-label-left" novalidate>
										<input id="op" name="op" type="hidden" value="<?php echo $op;?>">
										<input id="id" name="id" type="hidden" value="<?php echo $id;?>">
                                                   
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Login <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtlogin" value="<?php echo $login;?>" class="form-control col-md-7 col-xs-12" data-validate-length-range="4" name="edtlogin" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nome <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="edtnome" value="<?php echo $nome;?>" class="form-control col-md-7 col-xs-12" data-validate-length-range="4" name="edtnome" placeholder="" required="required" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="email" value="<?php echo $email;?>" id="edtemail" name="edtemail" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Situação Usuário <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $SituacaoUsuario->listaCombo('cmboxsituacaousuario',$idsituacaousuario,'N','class="form-control"');?>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Tipo Usuário <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $TipoUsuario->listaCombo('cmboxtipousuario',$idtipousuario,'N','class="form-control"');?>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Instituição do Usuário<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php echo $Instituicao->listaCombo('cmboxinstituicaousuario',$idinstituicaousuario,'N','class="form-control"');?>
                                            </div>
                                        </div>
                                        
                                       
										<div class="ln_solid"></div>
										
                                        <div class="form-group">
                                            <div class="form-group-buttons">
                                                <button type="submit" class="btn btn-primary">Cancelar</button>
                                                <button id="send" type="submit" class="btn btn-success">Enviar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- footer content -->
            <!--<footer>
                <div class="">
                    <p class="pull-right">Gentelella Alela! a Bootstrap 3 template by <a>Kimlabs</a>. |
                        <span class="lead"> <i class="fa fa-paw"></i> Gentelella Alela!</span>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
			-->
            <!-- /footer content -->
                
            </div>
            <!-- /page content -->
        </div>

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
    
	<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	
	
	<script>
	
			
<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
	
	
	
	function alterarSenha()
	{
		$('#myModal').modal({
  		keyboard: true
	})
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
    </script>

</body>

</html>