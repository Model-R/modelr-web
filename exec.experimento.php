<?php session_start();

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$operacao = $_REQUEST['op'];
$page = $_REQUEST['page'];
$filtro = $_REQUEST['filtro'];

if($page == 'dc'){
	$operacao = $_GET['op'];
}

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idexperimento = $_REQUEST['id'];
	$idprojeto = $_REQUEST['cmboxprojeto'];
	$experimento = $_REQUEST['edtexperimento'];
	$descricao = $_REQUEST['edtdescricao'];
	$group = $_REQUEST['edtgrupo'];
	$tipo = $_REQUEST['edttipo'];
	$idusuario = $_SESSION['s_idusuario'];

	$Experimento->idexperiment= $idexperimento;
	$Experimento->idproject= $idprojeto;
	$Experimento->name = $experimento;
	$Experimento->description = $descricao;
	$Experimento->group = $group;
	$Experimento->iduser = $idusuario;
	$Experimento->type = $tipo;
}
else
{
	$idexperimento = $_REQUEST['id'];
}

// echo $operacao;
// echo $idexperimento;
// exit;

if ($operacao=='I')
{
   if ($result = $Experimento->incluir())
	{
	// MENSAGEM 19 ==> CADASTRAR TECNICO
	 header("Location: cadexperimento.php?op=A&MSGCODIGO=82&tab=9&id=$result");
	}
	else
	{
	// MENSAGEM 20 ==> NÃO FOI POSSÍVEL CADASTRAR TECNICO
	 header("Location: cadexperimento.php?op=I&MSGCODIGO=83");
	}

}

if ($operacao=='A')
{

    if ($result = $Experimento->alterar($idexperimento))
	{
		header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=84&id=$idexperimento");
	}
	else
	{
	 header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=85&id=$idexperimento");
	}
   
}

if ($operacao=='LDDC')
{
   if ($result = $Experimento->limparDados($idexperimento, $filtro))
	{
	 header("Location: cadexperimento.php?MSGCODIGO=19&op=A&tab=10&id=$idexperimento");
	}
	else
	{
	 header("Location: cadexperimento.php?MSGCODIGO=20&op=A&tab=10&id=$idexperimento");
	}
}

if ($operacao=='LD')
{
   if ($result = $Experimento->limparDados($idexperimento))
	{
	 header("Location: consexperimento.php?MSGCODIGO=19&id=$idexperimento");
	}
	else
	{
	 header("Location: cadexperimento.php?MSGCODIGO=20");
	}
}

if ($operacao=='E')
{	
    $id = $_REQUEST['id'];
    if (!empty($id)){
		echo '!empty ' . $id;
 		$result = $Experimento->excluir($id);
	}
	else
	{
		$box=$_POST['id_experiment'];
		while (list ($key,$val) = @each($box)) {
   			$result = $Experimento->excluir($val);
		}
	}
	header("Location: consexperimento.php?MSGCODIGO=81");	
}

if ($operacao=='LE')
{
	$ws = file_get_contents("https://model-r.jbrj.gov.br/ws/?id=" . $_REQUEST['id']);
	$json = json_decode($ws);
	if(sizeof($json[0]->raster) > 0){
		$idexperimento = $_REQUEST['id'];
		if (!empty($idexperimento)){
			$Experimento->liberarExperimento($idexperimento);
			//$result = $Experimento->excluir($id);
		}
		else
		{
			$box=$_POST['id_experiment'];
			while (list ($key,$idexperimento) = @each($box)) {
				$Experimento->liberarExperimento($idexperimento);
				//$result = $Experimento->excluir($val);
			}
		}
		header("Location: consexperimento.php?MSGCODIGO=84");
	} else {
		header("Location: cadexperimento.php?op=A&tab=4&MSGCODIGO=78&id=" . $_REQUEST['id']);
	}	
}

if ($operacao == 'CN') { //change name
	$nome = $_REQUEST['nome'];
	if ($result = $Experimento->trocarNome($idexperimento, $nome))
	{
	 header("Location: consexperimento.php?MSGCODIGO=79");
	}
	else
	{
	 header("Location: cadexperimento.php?MSGCODIGO=80");
	}
}


// liberar experimento
// if ($operacao=='LE')
// {

//     if ($result = $Experimento->liberarExperimento($idexperimento))
// 	{
// 		header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=84&id=$idexperimento");
// 	}
// 	else
// 	{
// 	 header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=85&id=$idexperimento");
// 	}
   
// }

?>



