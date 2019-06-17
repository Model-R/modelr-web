<?php session_start();

require_once('classes/usuario.class.php');
require_once('classes/conexao.class.php');

$conexao = new Conexao;

$conn = $conexao->Conectar();

$usuario = new Usuario();
$usuario->conn = $conn;

$operacao = $_REQUEST['op'];


if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idusuario = $_REQUEST['id'];
	$login = $_REQUEST['edtlogin'];
	$nome = $_REQUEST['edtnome'];
	$email = $_REQUEST['edtemail'];
	$senha = $_REQUEST['edtsenha'];
	$idsituacaousuario = $_REQUEST['cmboxsituacaousuario'];
	$idtipousuario = $_REQUEST['cmboxtipousuario'];
	$idinstituicaousuario = $_REQUEST['cmboxinstituicaousuario'];

	$usuario->login = $login;
	$usuario->name = $nome;
	$usuario->email = $email;
	$usuario->password = $senha;
	$usuario->idstatususer = $idsituacaousuario;
	$usuario->idusertype = $idtipousuario;
	$usuario->idinstitution = $idinstituicaousuario;
}

if ($operacao=='I')
{
   if ($result = $usuario->incluir())
	{
	// MENSAGEM 6 ==> CADASTRAR USUÁRIO
	 header("Location: consusuario.php?op=A&MSGCODIGO=6");
	}
	else
	{
	// MENSAGEM 7 ==> NÃO FOI POSSÍVEL CADASTRAR USUÁRIO
	 header("Location: consusuario.php?op=I&MSGCODIGO=7");
	}

}

if ($operacao=='A')
{
    if ($result = $usuario->alterar($idusuario))
	{
	// MENSAGEM 4 ==> ALTERAR USUÁRIO
	 header("Location: cadusuario.php?op=A&MSGCODIGO=4&id=$idusuario");
	}
	else
	{
	// MENSAGEM 5 ==> NÃO FOI POSSÍVEL ALTERAR USUÁRIO
	 header("Location: cadusuario.php?op=A&MSGCODIGO=5&id=$idusuario");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $usuario->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_usuario'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $usuario->excluir($val);
		}
	}
	header("Location: consusuario.php");	
}



?>



