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

$Experimento->getById($expid);
$Experimento->getPath($expid);

$isImageCut = $Experimento->isImageCut;
$isImageCut = $isImageCut === 't'? true: false;

if(dirname(__FILE__) != '/var/www/html/rafael/modelr'){
	$baseUrl = '../';
} else {
	$baseUrl = './';
}

if($isImageCut){
	$pngCutPath = $Experimento->pngCutPath;
    $rasterCutPath = "'" . $Experimento->rasterCutPath . "'";
} else {
	$pngCutPath = $Experimento->rasterPngPath;
	$rasterCutPath = "'" . $Experimento->tiffPath . "'";
}

$Experimento->alterarPathPngRaster($expid, "'".$baseUrl."temp/" . $expid ."/png_map-" . $expid . ".png'", "'".$baseUrl."temp/" . $expid ."/raster_crop-" . $expid . ".tif'");

$filePath = $baseUrl . '../../../../../../mnt/dados/modelr/json/polygon-' . $expid . '.json';
$file = fopen($filePath, 'w');

$arrayPolygon = json_decode($_REQUEST['array'], true);
foreach($arrayPolygon as $polygon){
    $type = $polygon['type'];
	if($type != 'circle'){
		$vertices = explode(';',$polygon['vertices']);
		$result = [];
		foreach($vertices as $v){
			$result[] = [explode(',',$v)[1], explode(',',$v)[0]];
		}
		$coordinates[] = [$result];
		
		$myObj->type = "MultiPolygon";
		$myObj->coordinates = $coordinates;
		$myJSON = json_encode($myObj, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
		fwrite($file, $myJSON);
		fclose($file);

	} else {
		$vertices = explode(';',$polygon['vertices']);
		foreach($vertices as $v){
			$vertices = explode(';',$polygon['vertices']);
			$result = [];
			foreach($vertices as $v){
				$result[] = [explode(',',$v)[1], explode(',',$v)[0]];
			}
			$coordinates[] = [$result];
		}
		
		$myObj->type = "Circle";
		$myObj->coordinates = $coordinates;
		$myObj->radius = $polygon['radius'];
		$myJSON = json_encode($myObj, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
		fwrite($file, $myJSON);
		fclose($file);
	}
    
}

if (!file_exists($baseUrl . "temp/" . $expid )) {
    mkdir($baseUrl . "temp/" . $expid , 0777, true);
}


exec("Rscript R/script_pos.R $expid $filePath $rasterCutPath");

return 'success';

?>