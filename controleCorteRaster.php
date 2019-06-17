<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$expid = $_REQUEST['expid'];
$op = $_REQUEST['op'];
if($op == 'L'){
    $Experimento->limparCorteRaster($expid);
}

if($op == 'V'){
    $Experimento->validarCorteRaster($expid);
}

if($op == 'T'){
	//trocar mapa selecionado
	$png = $_REQUEST['png'];
	$specie = $_REQUEST['specie'];
	echo 'specie ' . $specie;
	$hash = md5($expid);
	$imageModelFolder = "temp/result/" . $hash;
	$imageBasePath = '/var/www/html/rafael/modelr/temp/result/' . $hash;
	
	if($specie == 'none'){
		$sql = "select distinct(taxon) from modelr.occurrence where idexperiment=" . $expid  . "and (idstatusoccurrence = 17 or idstatusoccurrence = 4)";
	} else {
		$sql = "select distinct(taxon) from modelr.occurrence where idexperiment=" . $expid  . "and (idstatusoccurrence = 17 or idstatusoccurrence = 4) and taxon = '" . $specie . "'";
	}	
	echo $sql;
	/* $res = pg_exec($conn,$sql);
	$results_array = array();
	$conta_arquivos = 0;
	while ($row = pg_fetch_array($res))
	{
		$log_directory = $imageModelFolder.'/'.$row['taxon'].'/present/ensemble';

		if (is_dir($log_directory))
		{
			if ($handle = opendir($log_directory)){
				//Notice the parentheses I added:
				while(($file = readdir($handle)) !== FALSE)
				{
					$tamanho = strlen($file); 
					list ($arquivo, $ext) = preg_split ('[.]', $file);
					
					{
					if (strpos($file, $png)) 
					{
						//echo $ext.'<br>';
						$ext = substr($file,-3);
						if($ext == 'tif'){
							$tiffPath = "'" . $imageBasePath . '/'. $row['taxon'].'/present/ensemble/' . $file . "'";
						} else {
							if(strpos($file, '_without_margins')){
								$rasterPngPath = "'" . $imageBasePath . '/'. $row['taxon'].'/present/ensemble/' . $file . "'";
								$returnRasterPngPath = $log_directory . "/" . $file;
							} else {
								$pngPath = "'" . $imageBasePath . '/'. $row['taxon'].'/present/ensemble/' . $file . "'";
							}
						}
					}
					}
				}
				closedir($handle);
			}
		}
	}
	//alterarPathImagemMapa
    $Experimento->alterarPathImagemMapa($expid,$pngPath,$tiffPath, $rasterPngPath);
	//echo retorna valores para javascript
	echo $returnRasterPngPath; */
}