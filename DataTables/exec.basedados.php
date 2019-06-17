<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

//include('security.inc');

require_once('classes/conexao.class.php');
require_once('classes/basededados.jabot.class.php'); 

print "<pre>";
print_r ($_REQUEST);


$NOMEFUNCAO = 'basedados';
$NOMETABELA = 'basedados';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso!';
$I_INSERIDO_COM_SUCESSO = 'Inserido com sucesso!';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar!';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar!';
$E_ITEM_EXCLUIDO_COM_SUCESSO = 'Item excluido com sucesso!';

$conexao = new Conexao;
$conn = $conexao->Conectar();

$BaseDados = new BaseDados();
$BaseDados->conn = $conn; 

$operacao = $_REQUEST['op'];

//$codusuario = $_SESSION[codusuario]; 


$id = $_REQUEST['id'];
if(!empty($_REQUEST['nomebase'])){
$nomebase = $_REQUEST['nomebase'];
}else{
$nomebase = NULL;
}
if(!empty($_REQUEST['cmboxpessoajuridica'])){
$codinstituicao = $_REQUEST['cmboxpessoajuridica'];
}else{
$codinstituicao = NULL;
}
if(!empty($_REQUEST['imprimir'])){
$imprimir = $_REQUEST['imprimir'];
}else{
$imprimir = NULL;
}
if(!empty($_REQUEST['descbase'])){
$descricaobase = $_REQUEST['descbase'];
}else{
$descricaobase = NULL;
}
if(!empty($_REQUEST['historico'])){
$historico = $_REQUEST['historico'];
}else{
$historico = NULL;
}
if(!empty($_REQUEST['fontesrecursos'])){
$fonterecursos = $_REQUEST['fontesrecursos'];
}else{
$fonterecursos = NULL;
}
if(!empty($_REQUEST['publicar'])){
$publicar = $_REQUEST['publicar'];
}else{
$publicar = NULL;
}
if(!empty($_REQUEST['cmboxcolecaobotanica'])){
$colbotpadrao = $_REQUEST['cmboxcolecaobotanica'];
}else{
$colbotpadrao = NULL;
}
if(!empty($_REQUEST['cmboxtipocolecaobotanica'])){
$tipocolbotpadrao = $_REQUEST['cmboxtipocolecaobotanica'];
}else{
$tipocolbotpadrao = NULL;
}
if(!empty($_REQUEST['cmboxtaxon'])){
$taxongenero = $_REQUEST['cmboxtaxon'];
}else{
$taxongenero = NULL;
}
if(!empty($_REQUEST['cmboxunidadegeopolitica'])){
$unidgeo = $_REQUEST['cmboxunidadegeopolitica'];
}else{
$unidgeo = NULL;
}
if(empty($taxongenero)){
	$taxongenero = "null";
}


$tipobase = "E"; 

	$BaseDados->nomebase = $nomebase;
 	$BaseDados->codinstituicao = $codinstituicao;
 	$BaseDados->imprimir = $imprimir;
 	$BaseDados->descricaobase = $descricaobase;
 	$BaseDados->historico = $historico;
 	$BaseDados->fonterecursos = $fonterecursos;
 	$BaseDados->publicar = $publicar;
 	$BaseDados->colbotpadrao = $colbotpadrao;
 	$BaseDados->tipocolbotpadrao = $tipocolbotpadrao;
 	$BaseDados->taxongenero = $taxongenero;
 	$BaseDados->unidgeo = $unidgeo;
 	$BaseDados->tipobase = $tipobase;


if (($operacao=='I') )
{	
// Verifica se Base já existe
	$sql = "SELECT * FROM jabot.basedados WHERE nomebase = '$nomebase'";
	$result = pg_exec($conn, $sql);
	$confere = pg_num_rows($result);
	//print $confere;
	
	if($confere > 0){
		echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?op=I&resp=NN'</script>";
	}else{	
	
	$result = $BaseDados->incluir();
	
//	exit;
	  
		  if (!$result)
		{		   
		   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?op=I&resp=N'</script>";
		}
		else
		{		
			echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?resp=I'</script>";
		}	
	}
 

}


if ($operacao=='A')
{
   $result = $BaseDados->alterar($id);
   if (!$result)
	{
	  // echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_ALTERAR."')</script>";	
	   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?op=A&id=".$id."&resp=N'</script>";
	}
	else
	{
		//echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	

	    echo "<script language='javascript'>location.href='consbasedados.php?op=A&id=".$id."&resp=A'</script>";
	}
}

/*
if ($operacao=='E')
{
	$id = $_REQUEST['idbasedados'];
    if (!empty($id)){
 		$result = $BaseDados->excluir($id);
	}
	else
	{
		$box=$_REQUEST['id_'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $BaseDados->excluir($val);
		}
	} 
 	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?op=A&id=".$id."'</script>";
}
*/

?>