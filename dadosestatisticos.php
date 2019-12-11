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
			<h2>Dados estatísticos <small></small><a  class="btn btn-default btn-sm" onClick="imprimir();" data-toggle="tooltip" data-placement="top" title="Baixar CSV" style="margin-top: 4px;">CSV</a></h2>
			<form name='frmdadosestatisticos' id='frmdadosestatisticos' action='exec.modelagem.php' method="post" class="form-horizontal form-label-left" novalidate></form>
			<div class="clearfix"></div>
			<table class="table table-striped">
   
			<tbody>
			<thead>
				<tr>
				<th>algoritmo</th>
				<th>% treinamento</th>
				<th>partition</th>
				<th>kappa</th>
				<th>th spec_sens</th>
				<th>th no_omission</th>
				<th>prevalence</th>
				<th>th equal_sens_spec</th>
				<th>sensitivity</th>
				<th>AUC</th>
				<th>TSS</th>
				</tr>
			</thead>
			<?php
			
			$sql2 = 'select * from modelr.experiment where idexperiment='.$id;
			$res2 = pg_exec($conn,$sql2);
			while ($row2 = pg_fetch_array($res2))
			{
				if($row2['idpartitiontype'] == 1){
					$trainpercent = number_format(100 - (100/$row2['num_partition']), 2, ',', '');
				}else {
					$trainpercent = $row2['trainpercent'];
				}
			}
			$sql = 'select distinct algorithm,partition,kappa,spec_sens,no_omission,prevalence,equal_sens_spec,sensitivity,auc,tss from modelr.experiment_result where idexperiment='.$id.' order by partition,algorithm';
			$res = pg_exec($conn,$sql);
			while ($row = pg_fetch_array($res))
			{
				$kappa = $row['kappa'];
				$spec_sens = $row['spec_sens'];
				$no_omission = $row['no_omission'];
				$prevalence = $row['prevalence'];
				$equal_sens_spec = $row['equal_sens_spec'];
				$sensitivity = $row['sensitivity'];
				$auc = $row['auc'];
				$tss = $row['tss'];
				$algoritmo = $row['algorithm'];
				$partition = $row['partition'];
				echo '<tr>';
		   echo '<td>'.$algoritmo.'</td>';
		   echo '<td>'.$trainpercent.'</td>';
		   echo '<td>'.$partition.'</td>';
		   echo '<td>'.$kappa.'</td>';
		   echo '<td>'.$spec_sens.'</td>';
		   echo '<td>'.$no_omission.'</td>';
		   echo '<td>'.$prevalence.'</td>';
		   echo '<td>'.$equal_sens_spec.'</td>';
		   echo '<td>'.$sensitivity.'</td>';
		   echo '<td>'.$auc.'</td>';
		   echo '<td>'.number_format($tss,3,',','').'</td>';
		   echo '</tr>';
			}
		?>


	
			</tbody>
		</table>
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