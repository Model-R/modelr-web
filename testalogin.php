<?php
session_start();
//session_destroy();
require_once('classes/conexao.class.php');
require_once('classes/usuario.class.php');
session_cache_expire(6000);
$Conexao = new Conexao;
$conn = $Conexao->Conectar();
$Usuario = new Usuario();
$Usuario->conn = $conn;
$login = $_REQUEST['edtlogin'];
$senha = $_REQUEST['edtsenha'];
//header("Location: consprojeto.php");

if (!$Usuario->autentica($login,$senha) ) 
{	
	header("Location: index.php?MSGCODIGO=10");
}
else
{	
	$Usuario->getUsuarioByLogin($login);
	// session_register("s_idusuario"); 
	// session_register("s_nome");
	// session_register("s_email"); 
	// session_register("s_idsituacaousuario"); 
	// session_register("s_idtipousuario"); 
	// session_register("s_sistema"); 
	// session_register("s_idprojeto"); 
	$_SESSION['s_idusuario']=$Usuario->iduser;
	$_SESSION['s_nome']=$Usuario->name;
	$_SESSION['s_email']=$Usuario->email;
	$_SESSION['ID_SESSION']=session_id();
	$_SESSION['s_idsituacaousuario']=$Usuario->idstatususer;
	$_SESSION['s_idtipousuario']=$Usuario->idusertype;
//	$_SESSION['s_idprojeto']=$Usuario->idprojeto;
	$_SESSION['s_sistema']='MODEL-R';
	$_SESSION['donoDaSessao']=md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
//	$_SESSION['donoDaSessao']='seg'.$_SERVER['REMOTE_ADDR'];//.$_SERVER['HTTP_USER_AGENT'];
//$_SESSION['donoDaSessao'];
	
//	if (!empty($Usuario->idprojeto))
//	{
		header("Location: consexperimento.php");
//	}
//	else
//	{
//		header("Location: consprojeto.php");
//	}
}

?>