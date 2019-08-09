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

$idtipoparticionamento = $_REQUEST['cmboxtipoparticionamento'];
$numpontos = $_REQUEST['edtnumpontos'];
$buffer = $_REQUEST['edtbuffer'];
$tss = $_REQUEST['edttss'];
$threshold_bin = $_REQUEST['edtbin'];
$numparticoes = $_REQUEST['edtnumparticoes'];
//$resolution = $_REQUEST['edtresolution'];
$repetitions = $_REQUEST['edtnumrepetitions'];
$trainpercent = $_REQUEST['edttrainpercent'];

$Experimento->idpartitiontype = $idtipoparticionamento;//integer,
$Experimento->num_partition = $numparticoes;//integer,
$Experimento->num_points = $numpontos ;//integer,
$Experimento->buffer = "'" . $buffer[0] . "'" ;//string
$Experimento->tss = $tss;
$Experimento->threshold_bin = $threshold_bin;
//$Experimento->resolution = "'" . $resolution[0] . "'";
$Experimento->repetitions = $repetitions;
$Experimento->trainpercent = $trainpercent;


$result = $Experimento->limparAlgoritmo($id);
$result = $Experimento->limparModelo($id);

$box=$_REQUEST['algoritmo'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirAlgoritmo($id,$val);
}

$box=$_REQUEST['modelos'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirModelo($id,$val);
}

// print_r($_REQUEST);
// exit;
if ($result = $Experimento->alterar($id))
{
	header("Location: cadexperimento.php?op=A&MSGCODIGO=84&id=$id&tab=$tab");
}
else
{
	header("Location: cadexperimento.php?op=A&MSGCODIGO=85&id=$id&tab=$tab");
}
?>



