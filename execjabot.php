<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
require_once('classes/conexao.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$especies = $_REQUEST['especie'];
$municipios = isset($_GET["municipio"]) ? $_REQUEST['municipio'] : null;
$herbarios = isset($_GET["herbario"]) ? $_REQUEST['herbario'] : null;
$estados = isset($_GET["estado"]) ? $_REQUEST['estado'] : null;

if($especies === NULL && $municipios === NULL && $herbarios === NULL && $estados === NULL){
	echo "Adicione um campo válido, por favor !<br><br>	
	Campos disponíveis:<br>
	especie<br>
	herbario<br>
	estado<br>
	municipio<br><br>

	<b>Todos os campos aceitam mais de um valor, separados por ','</b><br><br>

	Exemplos:<br>
	https://model-r.jbrj.gov.br/modelr-web/execjabot.php?especie=prepusa montana<br>
	https://model-r.jbrj.gov.br/modelr-web/execjabot.php?especie=prepusa montana,ocotea catharinensis&herbario=RB<br>";
	exit;
}
$sql = "select numtombo,taxoncompleto,codtestemunho,coletor,numcoleta,latitude,longitude,
        pais,estado_prov as estado,cidade as municipio, siglacolecao as herbario, descrlocal as localidade
            from  
		publicacao.extracao_jabot_geral where";

if($especies !== NULL) {
	$especies = explode(",",$especies);
	$sql = $sql . " (";
	foreach ($especies as $especie) {
		$sql = $sql . " familia || ' ' || taxoncompleto ilike '%".$especie."%' or";
	}
	$sql = substr_replace($sql ,"", -2) . ") and";	
}

if($municipios !== NULL){
	$municipios = explode(",",$municipios);
	$sql = $sql . " (";
	foreach ($municipios as $municipio) {
		$sql = $sql . " cidade ilike '%".$municipio."%' or";
	}
	$sql = substr_replace($sql ,"", -2) . ") and";
}

if($herbarios !== NULL){
	$herbarios = explode(",",$herbarios);
	$sql = $sql . " (";
	foreach ($herbarios as $herbario) {
		$sql = $sql . " siglacolecao = '".$herbario."' or";
	}
	$sql = substr_replace($sql ,"", -2) . ") and";
}

if($estados !== NULL){
	$estados = explode(",",$estados);
	$sql = $sql . " (";
	foreach ($estados as $estado) {
		$sql = $sql . " estado_prov ilike '%".$estado."%' or";
	}
	$sql = substr_replace($sql ,"", -2) . ") and";
}

$sql = substr_replace($sql ,"", -3);
//echo $sql;
//exit;

$res = pg_exec($conn,$sql);
$totalregistroselecionados = pg_num_rows($res); 

$arrayresposta = "[";
while ($row = pg_fetch_array($res))
{   
	foreach ($row as $key => $value) {
		// $arr[3] será atualizado com cada valor de $arr...
		if(is_numeric($key)) {
			unset($row[$key]);
		}
	}
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
	// print_r($row);
	// exit;
	$json = json_encode($row);
	$arrayresposta = $arrayresposta . $json . ',';

}

$arrayresposta = substr($arrayresposta, 0, -1) . ']';
print_r($arrayresposta);
?>