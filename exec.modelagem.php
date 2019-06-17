<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');

print_r($_REQUEST);
exit;
$conexao = new Conexao;
$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$operacao = $_REQUEST['op'];
$id = $_REQUEST['id'];
$tab = $_REQUEST['tab'];

$extensao1 = $_REQUEST['edtextensao1_oeste'].';'.$_REQUEST['edtextensao1_leste'].';'.$_REQUEST['edtextensao1_norte'].';'.$_REQUEST['edtextensao1_sul'];
//$extensao2 = $_REQUEST['edtextensao2_oeste'].';'.$_REQUEST['edtextensao2_leste'].';'.$_REQUEST['edtextensao2_norte'].';'.$_REQUEST['edtextensao2_sul'];

$noRedirect = $_REQUEST['noRedirect'];

$nome = $_REQUEST['edtexperimento'];
$descricao = $_REQUEST['edtdescricao'];
$idfonte = $_REQUEST['cmboxfonte'];
$idtipoparticionamento = $_REQUEST['cmboxtipoparticionamento'];
$numpontos = $_REQUEST['edtnumpontos'];
$buffer = $_REQUEST['edtbuffer'];
$tss = $_REQUEST['edttss'];
$numparticoes = $_REQUEST['edtnumparticoes'];
$resolution = $_REQUEST['edtresolution'];
$repetitions = $_REQUEST['edtnumrepetitions'];
$trainpercent = $_REQUEST['edttrainpercent'];

$Experimento->name = $nome;//integer,
$Experimento->description = $descricao;//integer,
$Experimento->idpartitiontype = $idtipoparticionamento;//integer,
$Experimento->num_partition = $numparticoes;//integer,
$Experimento->num_points = $numpontos ;//integer,
$Experimento->buffer = "'" . $buffer[0] . "'" ;//string
$Experimento->tss = $tss;
$Experimento->extent_model = $extensao1;
$Experimento->resolution = "'" . $resolution[0] . "'";
$Experimento->repetitions = $repetitions;
$Experimento->trainpercent = $trainpercent;
//$Experimento->extent_projection = $extensao2;

if(!empty($_REQUEST['raster'])){
	$result = $Experimento->limparRaster($id);
}

if(!empty($_REQUEST['algoritmo'])){
	$result = $Experimento->limparAlgoritmo($id);
}

$box=$_REQUEST['raster'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirRaster($id,$val);
}

$box=$_REQUEST['algoritmo'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirAlgoritmo($id,$val);
}

$Experimento->incluirExtensao($id, $extensao1);


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


if($noRedirect == false || empty($noRedirect))
{
	if ($result = $Experimento->alterar($id))
	{
		header("Location: cadexperimento.php?op=A&MSGCODIGO=84&id=$id&op=$operacao&tab=$tab");
	}
	else
	{
		header("Location: cadexperimento.php?op=A&MSGCODIGO=85&id=$id&op=$operacao&tab=$tab");
	}
}
?>



