<?php session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}

require_once('classes/usuario.class.php');
require_once('classes/conexao.class.php');
$senha = $_REQUEST['edtsenha'];
$id = $_REQUEST['id'];
$novasenha = $_REQUEST['edtsenha'];
$confirmacaosenha = $_REQUEST['edtsenha2'];
$conexao = new Conexao;
$conn = $conexao->Conectar();
$usuario = new Usuario();
$usuario->conn = $conn;
$usuario->iduser = $_SESSION['s_idusuario'];
if ($usuario->trocarSenha($senha,$novasenha,$confirmacaosenha))
{
	// MENSAGEM 2 ==> SENHA CADASTRADA COM SUCESSO
	 header("Location: trocarsenha.php?op=A&MSGCODIGO=2&id=$id");
}
else
{
	// MENSAGEM 3 ==> NÃO FOI POSSÍVEL ALTERAR/CADASTRAR A SENHA
	 header("Location: trocarsenha.php?op=A&MSGCODIGO=3&id=$id");
}
?>