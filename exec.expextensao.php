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

$extensao1 = $_REQUEST['edtextensao1_leste'].';'.$_REQUEST['edtextensao1_oeste'].';'.$_REQUEST['edtextensao1_norte'].';'.$_REQUEST['edtextensao1_sul'];

$Experimento->extent_model = $extensao1;

if ($result = $Experimento->incluirExtensao($id, $extensao1) && $result = $Experimento->incluirProjecao($id, $extensao1))
{
	header("Location: cadexperimento.php?op=A&MSGCODIGO=84&id=$id&tab=$tab");
}
else
{
	header("Location: cadexperimento.php?op=A&MSGCODIGO=85&id=$id&tab=$tab");
}
?>

