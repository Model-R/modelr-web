<?php session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}
error_reporting(E_ALL);
ini_set('display_errors','1');
//print_r($_REQUEST);
//exit;

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];

$Experimento->excluirPontosDuplicados($idexperimento);

 header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=72&id=$idexperimento");
?>



