<?php // 5 minutos
session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}
//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];
$idfontedados = $_REQUEST['id'];
$lat = $_REQUEST['id'];
$long = $_REQUEST['id'];
$taxon = $_REQUEST['id'];
$coletor = $_REQUEST['id'];
$numcoleta = $_REQUEST['id'];
$imagemservidor = $_REQUEST['id'];
$imagemcaminho = $_REQUEST['id'];
$imagemarquivo = $_REQUEST['id'];
$pais = $_REQUEST['id'];
$estado = $_REQUEST['id'];
$municipio = $_REQUEST['id'];

$fontedados = 2;
$Experimento->adicionarOcorrencia($idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio);
// header("Location: cadexperimento.php?op=A&pag=2&MSGCODIGO=71&id=$idexperimento");
?>



