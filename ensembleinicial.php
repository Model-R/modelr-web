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

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$hash = md5($id);

$Experimento->getById($id);
$Experimento->getPath($id);
$idexperiment = 	   	$Experimento->idexperiment;//= $row['nomepropriedade'];
$pngCutPath = $Experimento->pngCutPath;
$rasterCutPath = $Experimento->rasterCutPath;
$pngBinPath = $Experimento->pngBinPath;
$pngContPath = $Experimento->pngContPath;
$isImageCut = $Experimento->isImageCut;
$isImageCut = $isImageCut === 't'? true: false;
$pngPath = $Experimento->pngPath;
$tiffPath = $Experimento->tiffPath;
$rasterPngPath = $Experimento->rasterPngPath;

$rasterPngPath = str_replace("/var/www/html/rafael/modelr","https://model-r.jbrj.gov.br",$rasterPngPath);        
$novoRaster;

if(dirname(__FILE__) !== '/var/www/html/rafael/modelr'){
    $imageModelFolder = "../temp/result/" . $hash;
    $baseUrl = "../";
} else {
    $imageModelFolder = "temp/result/" . $hash;
    $baseUrl = "./";
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

<div class="col-md-12 col-sm-12 col-xs-12">							
								
<div class="x_content">

<div class="row">
	<div class="x_title">
		<h2>Ensemble Inicial <small></small><a  class="btn btn-default btn-sm" onClick="downloadZip();" data-toggle="tooltip" data-placement="top" title="Baixar ZIP" style="margin-top: 4px;">Download</a></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
<?php	
$sql = "select distinct(taxon) from modelr.occurrence where idexperiment=" . $id  . "and (idstatusoccurrence = 17 or idstatusoccurrence = 4)";								
$res = pg_exec($conn,$sql);
$results_array = array();
$contador = 0;
while ($row = pg_fetch_array($res))
{
	$log_directory = $imageModelFolder.'/'.$row['taxon'].'/present/final_models';
	if (is_dir($log_directory))
	{   
        $contador = $contador + 1;
        echo '<div class="col-md-12 image-model" >';
        if(count(scandir($log_directory)) > 2){
            echo '<h2 style="margin-top: 20px; margin-bottom:20px;">' . $row['taxon'] . '</h2>';
        }
			if ($handle = opendir($log_directory))
			{
					//Notice the parentheses I added:
					while(($file = readdir($handle)) !== FALSE)
					{
						$tamanho = strlen($file); 
						list ($arquivo, $ext) = preg_split ('[.]', $file);
						
						$ext = substr($file,-3);
						
						if (($file != 'ensemble_geral_legend.png') &&
							($file != 'ensemble_geral.png')
						)
						{
                        if ($ext=='png') 
                        {
                            //echo $ext.'<br>';
                            ?>
                            <div class="col-md-3 image-model">
                                <a href="<?php echo $log_directory.'/'.$file;?>" target="result">
                                    <img src="<?php echo $log_directory.'/'.$file;?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
                                    <p><?php //echo $log_directory.'/'.$file;?></a><br>
                                    <a href="<?php echo $log_directory.'/'.$file;?>" class="btn btn-default btn-sm download-button" download data-toggle="tooltip" data-placement="top" title data-original-title="Baixar arquivo PNG"><i class="fa fa-download"></i>PNG</a>
                                    <a href="<?php echo str_replace('png','tif',$log_directory.'/'.$file);?>" class="btn btn-default btn-sm download-button" download data-toggle="tooltip" data-placement="top" title data-original-title="Baixar arquivo Raster"><i class="fa fa-download"></i>RASTER</a>
                                    <?php //echo str_replace('.png','.tiff',$log_directory.'/'.$file);?>
                                    </p>
                                    
                                
                            </div>
                            <?php
                            $results_array[] = $file;
                            $conta_arquivos++;
                        }
						}
					}
					closedir($handle);
            }
            echo '</div>';
	}
}
 ?>
			   <!-- end pop-over -->

			
				<!-- end pop-over -->
		</div>
	</div>


			</div>								
				
			</div>

	</div> <!-- table panel -->

</div>	


<!-- scripts -->

<script>
function downloadZip(tipo){
	document.getElementById('frmmodelos').target="_blank";
	document.getElementById('frmmodelos').method="POST";
	document.getElementById('frmmodelos').action='<?php echo $baseUrl;?>downloadZip.php?arquivo=<?php echo $id;?>';
	document.getElementById('frmmodelos').submit();
}
</script>