<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?>
<!DOCTYPE html>
<?php 

	require_once('classes/conexao.class.php');
	require_once('classes/paginacao.en.class.php');
	require_once('classes/guiaremessa.class.php');
 
   	
   $FORM_NAME = 'Guia Remessa';
   $FORM_ACTION = 'exec.guiaremessa.php';
   $FORM_BACK = 'consusuario.php';

    
	
	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		
		
		 	 $html = '
                     <thead>
					 <tr valign="top" class="tab_bg_2"> 
                      <th width="2%">#</th>
					    <th width="5%">ID Usuario</th>
					  <th width="35%">Nome Usuario</th>
					  <th width="28%">Login</th>
					
                      </tr>
					  </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
           // Verifica se foi devolvido
 
            // se tiver algum diferente de 1 n�o foi totalmente devolvido             		   
				
				$sql = 'select * from jabot.itemguiaremessa 
				where idguiaremessa = '.$row['idguiaremessa'];

			$resultremessa = pg_exec($this->conn,$sql);
			$resultremessa = pg_fetch_all($resultremessa);

			
					
					
					
		  //-----------------------------------------
		  // Verifica o prazo de devolu��o, se esta no prazo ou se ja venceu o prazo do emprestimo


     		$data_hoje = date('Y-m-d');  
            $data_devolucao1 = $row["dataprevisaodevolucao"]; 			
 
			$diferenca = strtotime($data_devolucao1) - strtotime($data_hoje);

		
			//--------------------------------------------------------------------------
			
			// Data de  Devolu��o formatada
				
				$data_formatada = explode('-',$row["dataprevisaodevolucao"]);
				$data_devolucao =  $data_formatada["2"].' / '.$data_formatada["1"].' / '.$data_formatada["0"];  
			//----------------------------------------------------------------------------
			
			
			

			$html = ' 
		
                      <td align="center" class=" " role="alert" > <input type="checkbox" name="id_[]" id="id_" value="'.$row["idguiaremessa"].'" /></td>
					  <td nowrap class=" " role="alert"><a href="cadusuario.php?op=A&id='.$row['codusuario'].'">'.$row["codusuario"].'</a></td>
					  <td nowrap  class=" " role="alert"><a href="cadusuario.php?op=A&id='.$row['codusuario'].'">'.utf8_encode($row["nomecompleto"]).'</a></td>
					   <td nowrap class=" " role="alert">'.utf8_encode($row["nomelogin"]).'</td> 
			
					 
					  
					  ';
			





					 
		 		echo $html;
				echo "";
		}// function
		
	}
	

	
	
	
    $clConexao = new Conexao;
	$conn = $clConexao->Conectar();
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
 $GuiaRemessa = new GuiaRemessa();
	$GuiaRemessa->conn = $conn; 
	
	
	
	
	
	
	function listaperfil()
	{
	
		
				$sql2 = "select * from acesso.papel
				where id_sistema = 42";
				
				print $sql2;
               $result2 = pg_exec($conn,$sql2);

			   return  $result2;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	//---------CONTADOR
	$contaodrclasse = $GuiaRemessa->contador(); 
	$contaodrclasse = pg_fetch_all($contaodrclasse);
	 
	  $cot1 = 0;
  $cot2 = 0;
	 foreach($contaodrclasse as $value){
	
 

     		$data_hoje = date('Y-m-d');  
            $data_devolucao1 = $value["dataprevisaodevolucao"]; 			
 
			$diferenca = strtotime($data_devolucao1) - strtotime($data_hoje);

			$dias = floor($diferenca / (60 * 60 * 24));
		
		    if($dias < 0){
			$cot1 = $cot1 + 1;
			}elseif($dias <= 5){
			
			}else{
			$cot2 = $cot2 + 1;
			}

	 }

	
	

//-------------------------------------------	
	

	
	
	
    $sql = "
		select * from public.usuario us where us.codusuario = us.codusuario
    ";

	$filtronome = '';
	if (isset($_REQUEST['edtfiltronome']))
	{
		$filtronome = $_REQUEST['edtfiltronome'];
	}
	
	$filtroopen = false;
	if (!empty($filtronome))
	{
		$sql.=" 
		
		and us.nomecompleto ilike '%".$filtronome."%'";
		$filtroopen = true;
	}
	
	$filtrologin = '';
	if (isset($_REQUEST['edtfiltrologin']))
	{
		$filtrologin = $_REQUEST['edtfiltrologin'];
	}

	if (!empty($filtrologin))
	{
		$sql.=" and us.nomelogin ilike '%".$filtrologin."%'";
		$filtroopen = true;
	}
 
 

 //---edtfiltrosit
 	$filtrosituacao = '';
	
	//print_r($_REQUEST);
	if (isset($_REQUEST['edtfiltrosit']))
	{
		$filtrosituacao = $_REQUEST['edtfiltrosit'];
	}

	if (!empty($filtrosituacao))
	{
	
        $dataa = date("Y-m-d");
    
if($_REQUEST['edtfiltrosit'] == "prazo"){
        $sql.=" and gr.dataprevisaodevolucao > '".$dataa."'";
		}elseif($_REQUEST['edtfiltrosit'] == "vencido"){
		 $sql.=" and gr.dataprevisaodevolucao < '".$dataa."'";
		}
		$filtroopen = true;
	}
 //------------------------------------------------
 
 
 
 


	//echo $sql;

	$nr = 10;
	if (isset($_REQUEST['nr']))
	{
		$nr = $_REQUEST['nr'];
	}
	$p = 1;
	if (isset($_REQUEST['p']))
	{
		$p = $_REQUEST['p'];
	}
	$o = 0;
	if (isset($_REQUEST['o']))
	{
		$o = $_REQUEST['o'];
	}

	
    $paginacao->sql = $sql; // a sele��o sem o filtro
	$paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$paginacao->order = $o; // como ser� ordenado o resultado
	$paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1 � sinal que � listagem por linha
	$paginacao->numero_linhas = $nr; // quantidade de linhas por p�ginas
	$paginacao->quadro = ''; // conte�do em a ser exibido
	$paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$paginacao->largura_coluna = '100%';
	$paginacao->mostra_informe = 'T';//
	$paginacao->pagina = $p;//$_REQUEST['p']; // p�gina que est�
	$paginacao->tamanho_imagem = '60';
	$paginacao->codbasedados = '0';
	$paginacao->separador = '' ; // sepador linha que separa as rows
	//$paginacao->paginar();
	

?> 
<html>

<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jabot - Usuário</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	
    <!-- Page-Level Plugin CSS - Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="media/js/demo_table.css" rel="stylesheet">
	<?php include "css.php";?>
   
	<script type="text/javascript" language="javascript" src="media/js/gwmajax.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	
</head>

<body>
<?php include "menu.php";?>

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir o(s) registro(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>


    <div id="wrapper">

       <div id="page-wrapper">
            <div class="row">
                
      <div class="col-lg-12"> 
        <h1 class="page-header">Usuário</h1>
        <div id="alert_placeholder"> </div>
      </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
      <div class="col-lg-12"> 
        <div class="panel panel-default"> 
          <form action="consusuario.php" name="frm" id="frm" method="post">
            <?php echo '<input type="hidden" name="sql_filtro" id="sql_filtro" value="'.$sql.'">';?>
            <div class="panel-heading"> 
              <div class="btn-group"> 
               
                
              
              </div>
              <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>-->
              <button type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> 
              <span class="glyphicon glyphicon-filter"></span> Filtro </button>
              <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="voltar();"> 
                <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
              </div>
			  
			   <div class="btn-group"> 
               <button type="button" class="btn btn-default"  <?php echo $disabled;?> onClick="novorecebimento();"> 
                <span class="glyphicon glyphicon-plus"></span> 
                <?php echo $disabled;?>
                Relatorio</button>
              </div>
            </div>
            <div id="collapseOne" class="panel-collapse collapse <?php if ($filtroopen==true){ echo "in";} else {echo "out";}?>"> 
              <div class="panel-body"> 
                <div class="row-fluid"> 
                  <div class="row"> 
                    <div class="col-lg-3"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Nome</span> 
					  <?php
					  $resultperfil = listaperfil();
					  $resultperfil = pg_fetch_all($resultperfil);
print_r($resultperfil);
					  
					  ?>
					  
					  
					  
                        <input type="text" class="form-control"  name="edtfiltronome" id="edtfiltronome" value="<?php echo $filtronome;?>">
                      </div>
                    </div>
                    <div class="col-lg-3"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Login</span> 
                        <input type="text" class="form-control"  name="edtfiltrologin" id="edtfiltrologin" value="<?php echo $filtrologin;?>">
                      </div>
                    </div>
                 
                  </div>
                  <div class="row"> 
                    <div class="col-lg-12"><br>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-lg-9"> </div>
                    <div class="col-lg-3"> 
                      <div class="btn-group"> 
                        <button type="button" class="btn btn-success" onClick="filterApply();"> 
                        <span class="glyphicon glyphicon-ok-circle"></span> Filtrar 
                        </button>
                        <button type="button" class="btn btn-danger" onClick="removeFilter();"> 
                        <span class="glyphicon glyphicon-remove-circle"></span> 
                        Limpar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body"> 
              <div style="overflow:auto;"> 
                <div class="table-responsive"> 
                  <?php $paginacao->paginar();?>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
          </form>
          <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
      </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
	</div>
	
    <!-- /#wrapper -->

	
    <!-- Core Scripts - Include with every page -->
	<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.tooltip.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/bootbox.min.js"></script>
		<script type="text/javascript" charset="utf-8">

	function checkData() {
		var chks = document.getElementsByName('id_[]');
		var hasChecked = false;
		var conta = 0;
		for (var i=0 ; i< chks.length; i++)
		{
			if (chks[i].checked){
				conta = conta + 1;		
				hasChecked = true;
			}
		}
		if (hasChecked)
		{
	    	return true;
		}
		else
		{
			return false;
		}
	}

	function montapaginacao(p,nr)
	{
		document.getElementById('frm').action='consusuario.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').action='consusuario.php';
    	document.getElementById('frm').submit();
	}

	function novo()
	{
		window.location.href = 'cadguiaremessa.php?op=I';
	}

		function cadinstituicao()
	{
		window.location.href = 'cadinstituicao.php?op=I';
	}
		
		function consinstituicao()
	{
		window.location.href = 'consinstituicao.php?op=I';
	}
	
		function voltar()
			{
				window.location.href = '<?php echo $FORM_BACK;?>';
			}
			
			
			
	function novorecebimento()
	{
		window.location.href = 'relatoriousuario.php?op=I';
	}
	
	function removeFilter()
	{
		window.location.href = 'consusuario.php';
	}


  function showalert(message,alerttype) {
    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">�</a><span>'+message+'</span></div>');
    setTimeout(function() {
		 // this will automatically close the alert and remove this if the users doesnt close it in 5 secs
      $("#alertdiv").remove();
	  }, 5000);
  }

			function showExcluir()
			{
				$('#myModal').modal({
  					keyboard: true
				})
			}
			function excluir()
			{
				$('#myModal').modal('hide');
				document.getElementById('frm').action='exec.guiaremessa.php?op=E';
    			document.getElementById('frm').submit();
			}		
		
			$(document).ready(function() {
			} );
		</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

	
	<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>


</body>

</html>