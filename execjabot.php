<?php
require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$especie = $_REQUEST['especie'];

$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,
        pais,estado_prov as estado,cidade as municipio, siglacolecao as herbario, descrlocal as localidade
            from  
		publicacao.extracao_jabot_geral where familia || ' ' || taxoncompleto ilike '%".$especie."%'";

$res = pg_exec($conn,$sql);
$totalregistroselecionados = pg_num_rows($res); 

$arrayresposta = "[";
while ($row = pg_fetch_array($res))
{   
	$codigobarras= str_pad($row['codtestemunho'], 8, "0", STR_PAD_LEFT);	
	$sqlimagem = "select * from jabot.imagem where codigobarras = '".$codigobarras."' limit 1";
	$resimagem = pg_exec($conn,$sqlimagem);
	$rowimagem = pg_fetch_array($resimagem);
	$servidor = $rowimagem ['servidor'];
	$path =  $rowimagem ['path'];
	$arquivo =  $rowimagem ['arquivo'];
	$row['servidor'] = $rowimagem ['servidor'];
	$row['path'] = $rowimagem ['path'];
	$row['arquivo'] = $rowimagem ['arquivo'];
	$json = json_encode($row);
	$arrayresposta = $arrayresposta . $json . ',';

}

$arrayresposta = substr($arrayresposta, 0, -1) . ']';
print_r($arrayresposta);	
?>