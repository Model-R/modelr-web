<?php 
error_reporting(E_ALL);
ini_set('display_errors','1');

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');
require_once('../classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();


if (isset($_GET['id']))
{
	if (isset($_GET['status']))
	{	
		$sql = '';
		$id = preg_replace('/[^[:alnum:]_]/', '',$_GET['id']);
		$status = intval($_GET['status']);
		$sql.=" update modelr.experiment set idstatusexperiment = '".$status."' where
		md5(cast(idexperiment as text)) = '".$id."'";
		
		$res = pg_exec($conn,$sql);
		
		if ($res == true)
		{
			//$json_str = utf8_decode('{"experiment":[{"idexperiment":"'.$id.'","update": "true","msg": ""}]}');
			$json_str = iconv('UTF-8', 'windows-1252//IGNORE', '{"experiment":[{"idexperiment":"'.$id.'","update": "true","msg": ""}]}');
		}
		else
		{
			//$json_str = utf8_decode('{"experiment":[{"idexperiment":"'.$id.'","update": "false","msg": "Não foi possível alterar o status do experimento"}]}');
			$json_str = iconv('UTF-8', 'windows-1252//IGNORE', '{"experiment":[{"idexperiment":"'.$id.'","update": "false","msg": "Não foi possível alterar o status do experimento"}]}');
		}
	}
	else
	{
		$id = preg_replace('/[^[:alnum:]_]/', '',$_GET['id']);
		//$json_str = utf8_decode('{"experiment":[{"idexperiment":"'.$id.'","update": "false","msg": "Status não informado"}]}');
		$json_str = iconv('UTF-8', 'windows-1252//IGNORE', '{"experiment":[{"idexperiment":"'.$id.'","update": "false","msg": "Status não informado"}]}');
	}
}
else
{
	//$json_str = utf8_decode('{"experiment":[{"idexperiment":"","update": "false","msg": "ID não encontrado"}]}');
	$json_str = iconv('UTF-8', 'windows-1252//IGNORE', '{"experiment":[{"idexperiment":"","update": "false","msg": "ID não encontrado"}]}');
}
echo $json_str;
?>