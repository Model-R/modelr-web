<?php 
session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{   
	header('Location: index.php');
}
?><!DOCTYPE html>
<html lang="en">
<head>
<?php 
      require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/experimento.class.php');
//	  require_once('classes/categoira.class.php');
	  $FORM_ACTION = 'experimento';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $valorfiltro = $_REQUEST['edtvalorfiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  
//	  $idproject = $_REQUEST['idproject'];
      $idusuario = $_SESSION['s_idusuario'];
    
	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
              $html = '
			 <thead>
                <tr class="headings">
                    <th>
                        <input type="checkbox" id="check-all" class="flat">
                    </th>
                    <th class="column-title">Experimento </th>
                    <th class="column-title">Grupo </th>
                    <th class="column-title">Descrição </th>
                    ';
			if ($_SESSION['s_idtipousuario']==2)
			{
				$html.='<th class="column-title">Usuário </th>';
			}
			$html.='						
                    <th class="column-title" style="width: 300px;">Ação </th>
                    <th class="column-title no-link last" style="width: 400px;"><span class="nobr">status</span>
                    </th>
                    <th class="bulk-actions" colspan="7">
                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                </tr>
            </thead>
            ';
        echo $html;
		}

		function desenha($row){
			$sqloccurrence = 'select count(*) from modelr.occurrence where idexperiment = '.$row['idexperiment'];
			$resoccurrence = pg_exec($this->conn,$sqloccurrence);
			$rowoccurrence = pg_fetch_array($resoccurrence);
			$qtd = $rowoccurrence[0];
			
			$sqloccurrenceok = 'select count(*) from modelr.occurrence where idexperiment = '.$row['idexperiment'].' and idstatusoccurrence in (4,17)';
			$resoccurrenceok = pg_exec($this->conn,$sqloccurrenceok);
			$rowoccurrenceok = pg_fetch_array($resoccurrenceok);
			$qtdok = $rowoccurrenceok[0];
            
			$disabled = '';
			if (($_SESSION['s_idtipousuario'])!=2)
			{
				
//				$disabled = 'disabled';
				$disabled = ''; // alterado apenas para a apresentação
			}
			
            $html = '<td class="a-center "><input type="checkbox" class="flat" name="id_experiment[]" id="id_experiment" value="'.$row["idexperiment"].'" ></td>
                                    <td class=" " id="'.$row["idexperiment"].'">'.$row['2'].' <a onClick="abreEditarNome('.$row["idexperiment"].')" style="border: 1px solid;float: right;padding: 5px;text-decoration: none;cursor: pointer;color: #3f5367;">Editar</a></td>
                                    <td class=" ">'.$row['group_name'].'</td>
                                    <td class=" ">'.$row['description'].'</td>';
			if ($_SESSION['s_idtipousuario']==2)
			{
				$html.='<td class=" ">'.$row['username'].'</td>';
			}			
			$html.='				<td class="actions" style="display: flex;justify-content: center;">
									<div>
										<a class="btn btn-app" href="cadexperimento.php?op='.'A'.'&tab='.'9'.'&id='.$row['idexperiment'].'" data-toggle="tooltip" data-placement="top" title="Pré-tratamento">
											<i class="fa fa-pencil-square-o"></i>
											<span class="badge bg-blue">'.$qtd.'</span>
										</a>
										<a class="btn btn-app" href="cadexperimento.php?op='.'A'.'&tab='.'6'.'&id='.$row['idexperiment'].'" data-toggle="tooltip" data-placement="top" title="Modelagem">
											<i class="fa fa-gears"></i>
										</a>
										<a class="btn btn-app" href="cadexperimento.php?op='.'A'.'&tab='.'8'.'&id='.$row['idexperiment'].'" data-toggle="tooltip" data-placement="top" title="Pós-processamento">
											<i class="fa fa-globe"></i>
										</a>
									</div>
									<a class="btn btn-app" onclick="confirmarLimparDados('.$row['idexperiment'].')" data-toggle="tooltip" data-placement="top" title="Limpar">
                                        <span class="badge bg-red">'.$qtd.'</span>
                                        <i class="fa fa-eraser"></i>
                                    </a>
                                   ';
									
									$idstatus = $row['idstatusexperiment'];
									$classe1='done';
									$classe2='done';
									$classe3='done';
									$classe4='done';
									
									if ($idstatus=='1')
									{
										$classe1 = 'selected';
									}
									if ($idstatus=='2')
									{
										$classe2 = 'selected';
									}
									if ($idstatus=='3')
									{
										$classe3 = 'selected';
									}
									if ($idstatus=='4')
									{
										$classe4 = 'selected';
									}
									$html.=' <td class=" last">
									<div id="wizard" class="form_wizard wizard_horizontal">
									<ul class="wizard_steps">
                                            <li>
                                                <a class="'.$classe1.'" href="#step-1">
                                                    <span class="step_no">1</span>
                                                    <span class="step_descr">
                                            Aguardando<br />
                                            <small></small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="'.$classe2.'" href="#step-2">
                                                    <span class="step_no">2</span>
                                                    <span class="step_descr">
                                            Liberado<br />
                                            <small></small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="'.$classe3.'" href="#step-3">
                                                    <span class="step_no">3</span>
                                                    <span class="step_descr">
                                            Em processamento<br />
                                            <small></small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="'.$classe4.'" href="#step-4">
                                                    <span class="step_no">4</span>
                                                    <span class="step_descr">
                                            Processado<br />
                                            <small></small>
                                        </span>
                                                </a>
                                            </li>
                                        </ul>
									</div>
									</td>';			
	echo $html;
				echo "";
		}// function
	}	  
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Paginacao = new MyPag();
$Paginacao->conn = $conn;
$sql = 'select *, u.name as username from modelr.experiment e, modelr.statusexperiment se, modelr.user u where 
e.idstatusexperiment = se.idstatusexperiment and
e.iduser = u.iduser
 ';
// echo $sql;

if ($_SESSION['s_idtipousuario']!='2')
{
   $sql.= " and e.iduser = ".$_SESSION['s_idusuario'];	
}

if ($tipofiltro=='EXPERIMENTO' || $tipofiltro==NULL)
{
   $sql.= " and e.name ilike '%".$valorfiltro."%'";	
}
if ($tipofiltro=='USUARIO')
{   
   $sql.= " and u.name ilike '%".$valorfiltro."%' ";	
}
if ($tipofiltro=='GRUPO')
{   
   $sql.= " and e.group_name ilike '%".$valorfiltro."%' ";	
}

if (($ordenapor=='EXPERIMENTO') || ($ordenapor==''))
{
   $sql.= " order by e.name";	
}
if (($ordenapor=='USUARIO'))
{
   $sql.= " order by u.name";	
}
if (($ordenapor=='GRUPO'))
{
   $sql.= " order by e.group_name";	
}


//echo $sql;

    $Paginacao->sql = $sql; // a  sem o filtro
	$Paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$Paginacao->order = $_REQUEST['o']; // como serᡯrdenado o resultado
	$Paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1  que  por linha
	$Paginacao->numero_linhas = $_REQUEST['nr']; // quantidade de linhas por p⨩nas
	$Paginacao->quadro = ''; // conte򤯠em a ser exibido
	$Paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$Paginacao->largura_coluna = '100%';
	$Paginacao->mostra_informe = 'T';//
	$Paginacao->pagina = $_REQUEST['p'];//$_REQUEST['p']; // p⨩na que est኉$paginacao->tamanho_imagem = '60';
	$Paginacao->separador = '' ; // sepador linha que separa as rows
?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Model-R</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
	<link href="css/consexperimento.css" rel="stylesheet">
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

<?php include_once 'templates/passoapasso.php'?>

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir o(s) registro(s) ? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ConfirmCleanModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmCleanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmCleanLabel">Limpar Dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja Limpar todos os dados desse Experimento ?</p>
                <div class="modal-footer cleanDataFooter">
                    <button type="button" data-dismiss="modal" id="cleanButton" class="btn btn-primary">Sim</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Não</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNameModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNameLabel">Editar nome experimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="editNameForm" id="editNameForm" method="post" action="">
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Nome:</label>
                        <input type="text" class="form-control" name="edtname" id="edtname">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="editarNome()">Enviar</button>
                </div>
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

            <!-- top navigation -->
			<?php require "menutop.php";?>


            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>

                    <?php ?>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title_consexperimentos">
                                    <h2> Experimentos </h2>
                                    <div class="print-options">
                                        <a  class="btn btn-default btn-sm" onClick="imprimirExp('PDF');" data-toggle="tooltip" data-placement="top" title="Exportar tabela em PDF"><?php echo " PDF ";?></a>
                                        <a  class="btn btn-default btn-sm" onClick="imprimirExp('CSV');"data-toggle="tooltip" data-placement="top" title="Exportar tabela em CSV"><?php echo " CSV";?></a>
                                    </div>

                                    <?php 
                                        include_once 'templates/consexperimento.instrucao.php';
                                    ?>
         
                                </div>
								<form class="form-inline" name="frm" id="frm" method="post">
								<input type="hidden" name="sql" id="sql" value="<?php echo $Paginacao->sql;?>">
                                <div class="x_content">
                                   
                                <p>
                                    <div class="filters">
                                        <div class="filter-group">
                                            <?php 
                                                if ($_SESSION['s_idtipousuario']=='2')
                                                {
                                                    include_once 'templates/tipofiltro.php';
                                                }
                                            ?>
                                            <div class="form-group" style="display: flex;align-items: baseline;">
                                                <label for="edtvalorfiltro" style="margin-right: 5px;">Nome</label>
                                                <input id="edtvalorfiltro" name="edtvalorfiltro" class="form-control" placeholder="Nome" value="<?php echo $valorfiltro;?>">
                                            </div>
                                            <?php 
                                                if ($_SESSION['s_idtipousuario']=='2')
                                                {
                                                    include_once 'templates/ordenarfiltro.php';
                                                }
                                            ?>
                                            <button type="button" class="btn btn-success" onClick='filterApply()' data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar experimentos">Filtrar</button>
                                        </div>
                                        <div class="row-action">
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#passoapassoModal" data-toggle="tooltip" data-placement="top" title data-original-title="Passo a Passo do experimento">Fluxo Experimento</button>
                                            <button type="button" class="btn btn-success" onClick='novo()' data-toggle="tooltip" data-placement="top" title data-original-title="Criar novo experimento">Novo</button>
                                            <button type="button" class="btn btn-danger" onClick='showExcluir()' data-toggle="tooltip" data-placement="top" title data-original-title="Excluir experimento">Excluir</button>
                                        </div>
                                    </div>
                            </p>
							    <div style="overflow:auto;"> 
                <div class="table-responsive"> 
								<?php $Paginacao->paginar();?>
								</div>
								</div>
                              </div>
								</form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right"> 
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
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
	
	<!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	

    <!-- print pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>	
	
	<script>
	
<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
		
	var limparExperimento;
	var expid;
    $('#ConfirmCleanModal').modal({ show: false});

    function confirmarLimparDados(idexperimento)
	{   
        limparExperimento = idexperimento;
        $('#ConfirmCleanModal').modal('show');
	}
    $("#cleanButton").click(function() {
        document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?id='+limparExperimento+'&op=LD';
		document.getElementById('frm').submit();
    });
 
	function modelar(idexperimento)
	{
		document.getElementById('frm').action='cadmodelagem.php?id='+idexperimento;
		document.getElementById('frm').submit();
	}
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').target = '_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').target = '_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
	}

	function imprimirExp(tipo)
	{
		document.getElementById('frm').target="_blank";//"'cons<?php echo strtolower($FORM_ACTION);?>.php';
		if (tipo=='PDF')
		{
            //console.log(document.getElementById('frm').action='export' + tipo + '.php?table=exp')
			document.getElementById('frm').action='export' + tipo + '.php?table=exp&expid=<?php echo $idusuario;?>';
			document.getElementById('frm').submit();
		}
		if (tipo=='CSV')
		{
			//console.log(document.getElementById('frm').action='export' + tipo + '.php?table=exp')
			document.getElementById('frm').action='export' + tipo + '.php?table=exp&expid=<?php echo $idusuario;?>';
			document.getElementById('frm').submit();
		}
	}

	function novo()
	{   
		window.location.href = 'cad<?php echo strtolower($FORM_ACTION);?>.php?op=I&idusuario=<?php echo $idusuario;?>';
	}
	
	function resultado(id)
	{
		window.location.href = 'resultado.php?&id='+id;
	}
	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}

	function showExcluir()
	{
		$('#myModal').modal({
  		keyboard: true
	})
	}
	
	function excluir()
	{	
        if(document.getElementById('check-all').checked){
            var inputs = document.getElementsByName('id_experiment[]');
            for(let input of inputs) {
                input.checked = true;
            }
        }
		$('#myModal').modal('hide');
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?op=E';
        console.log('exec.<?php echo strtolower($FORM_ACTION);?>.php?op=E')
  		document.getElementById('frm').submit();
	}	

    function liberarExperimento()
	{   
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?op=LE';
  		document.getElementById('frm').submit();
	}

	function abreEditarNome(id)
	{	
		console.log(document.getElementById(id.toString()))
		var element = document.getElementById(id.toString());
		var nome = element.innerText || element.textContent;
		nome = nome.replace('Editar', '')
		document.getElementById('edtname').value= nome;
		expid = id;
		$('#editNameModal').modal('show');
	}	
	
	function editarNome () {
		var nome = document.getElementById('edtname').value;
		document.getElementById('frm').action='exec.experimento.php?id='+expid+'&nome='+nome+'&op=CN';
		document.getElementById('frm').submit();
	}

	</script>

</body>

</html>