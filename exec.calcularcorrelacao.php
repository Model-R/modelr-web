<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$id = $_REQUEST['id'];
$tab = $_REQUEST['tab'];
$resolution = $_REQUEST['lblresolution'];

$result = $Experimento->incluirResolucao($id, $resolution);

if(!empty($_REQUEST['raster'])){
	$result = $Experimento->limparRaster($id);
}

$box=$_REQUEST['raster'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirRaster($id,$val);
}

//incluir raster Bio-Oracle
$rasterBio = array("Temperature","Salinity","Currents_velocity","Ice_thickness","Sea_ice_concentration","Nitrate","Phosphate","Silicate","Dissolved_molecular_oxygen","Iron","Chlorophyll","Phytoplankton","Primary_productivity","Calcite","pH","Photosynt_Avail_Radiation","Diffuse_attenuation","Cloud_cover");
foreach ($rasterBio as &$value) {
    $box=$_REQUEST[$value];
	$rasterid = $box[0]; 
	array_shift($box);
	$box = implode(",",$box);
	if($box != ''){
		$result = $Experimento->incluirBioOracleRaster($id,$rasterid,$box);
	}
}

$ws = file_get_contents("https://model-r.jbrj.gov.br/ws/?id=" . $id);
$json = json_decode($ws); 

if(dirname(__FILE__) == '/var/www/html/rafael/modelr/v2' || dirname(__FILE__) == '/var/www/html/rafael/modelr/v3'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
}

unlink($baseUrl . 'temp/'. $id . '/correlation-'. $id . '.png');

$resolution= $json[0]->resolution;
$rasterList = $json[0]->raster;
$rasterPathList = [];

#checar se usuário é Reflora - Raster -> PCA
if($_SESSION['s_idtipousuario']==5){
	$path = 'mnt/dados/modelr/env';
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_05.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_06.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_12.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_13.tif' . "'");
} else {
	foreach($rasterList as $raster){
		$path = 'mnt/dados/modelr/env';
		if($raster->source == 'Worldclim v1' || $raster->source == 'WordClim v1'){
			$path = $path . '/Worldclim1/'.$resolution.'min/' . strtolower(explode(" ",$raster->raster)[0]) . '.bil';
			array_push($rasterPathList,"'" . $path . "'");
		} else if($raster->source == 'Worldclim v2' || $raster->source == 'WordClim v2'){
			$bio = str_replace("bio","",strtolower(explode(" ",$raster->raster)[0]));
			if($bio < 10) {
				$path = $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_0' . $bio . '.tif';
				array_push($rasterPathList,"'" . $path . "'");
			} else {
				$path = $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_' . $bio . '.tif';
				array_push($rasterPathList,"'" . $path . "'");
			}
		} else if($raster->source == 'Chelsa'){
			$bio = str_replace("bio","",strtolower(explode(" ",$raster->raster)[0]));
			$path = $path . '/Chelsa/CHELSA_bio10_' . $bio . '.tif';
			array_push($rasterPathList,"'" . $path . "'");
		} else if($raster->source == 'PCA'){
			$path = $path . '/PCA/1Km_.eigenvariables.tif';
			array_push($rasterPathList,"'" . $path . "'");
		} else {
			$params = explode(",",$raster->params);
			foreach($params as $param){
				$path = 'mnt/dados/modelr/env';
				if($raster->raster == 'pH'){
					$path = $path . '/Biooracle/Surface/Present.Surface.' . $raster->raster .'.tif';
				} else {
					$path = $path . '/Biooracle/Surface/Present.Surface.' . $raster->raster . ' '. $param .'.tif';
				}
				array_push($rasterPathList,"'" . str_replace(' ', '.', $path) . "'");
			}
		}
	}
}

if (!file_exists($baseUrl . "temp/" . $id )) {
    mkdir($baseUrl . "temp/" . $id , 0777, true);
}

$rasterCSVPath = $baseUrl . 'temp/'. $id . '/raster.csv';
$file = fopen($rasterCSVPath, 'w');
fputcsv($file, $rasterPathList, ";");
fclose($file);

exec("Rscript raster-correlation.r " . $id . ' ' . $rasterCSVPath, $a, $b);
header("Location: cadexperimento.php?op=A&tab=11&MSGCODIGO=86&id=" . $id);
?>



