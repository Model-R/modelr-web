<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once('classes/usuario.class.php');
require_once('classes/conexao.class.php');
require_once('classes/experimento.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Usuario = new Usuario();
$Usuario->conn = $conn;

$Experimento = new Experimento();
$Experimento->conn = $conn;

if(!empty($_REQUEST['login'])){
	$login = $_REQUEST['login'].'.jabot';
	$name = $_REQUEST['name'];
	$password = $_REQUEST['password'];
	   
	  // $login = $json->login;
	   $especies = '';//$json->scientific_name;
	   //print_r($_REQUEST);
	   //exit;
	   if ($Usuario->getUsuarioByLogin($login)==0)
	   {
		   if (!empty($login))
		   {
			   // não é vazio;
			   $Usuario->login = $login;
			   $Usuario->name = $login;
			   $Usuario->password = $login;
			   $Usuario->email = '';
			   $Usuario->idstatususer = 1; //Taxonomista Geral
			   $Usuario->idusertype = 6;
			   $Usuario->idinstitution = 5;
			   $idusuario = $Usuario->incluir();
			   $Usuario->getById($idusuario);
		   }
	   }
	   
		$_SESSION['s_idusuario']=$Usuario->iduser;
		$_SESSION['s_nome']=$Usuario->name;
		$_SESSION['s_email']=$Usuario->email;
		$_SESSION['ID_SESSION']=session_id();
		$_SESSION['s_idsituacaousuario']=$Usuario->idstatususer;
		$_SESSION['s_idtipousuario']=$Usuario->idusertype;
		$_SESSION['s_sistema']='MODEL-R';
		$_SESSION['s_taxon']='';//$especies;
		
		
		$_SESSION['donoDaSessao']=md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		
		header("Location: consexperimento.php");
} else {
	header('Location: index.php');
}


?>
