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

if ($result)
{
	header("Location: cadexperimento.php?op=A&MSGCODIGO=84&id=$id&tab=$tab");
}
else
{
	header("Location: cadexperimento.php?op=A&MSGCODIGO=85&id=$id&tab=$tab");
}
?>



