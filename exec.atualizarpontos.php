<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;
$idexperimento = $_REQUEST['id'];
$filtro = $_REQUEST['filtro'];

$idponto = explode(",",$_REQUEST['idponto']);
$idstatus = $_REQUEST['idstatus'];
$latinf = $_REQUEST['latinf'];
$longinf = $_REQUEST['longinf'];

if(dirname(__FILE__) != '/var/www/html/rafael/modelr'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
}

if(empty($_REQUEST['mult'])){ 
	$mult = false;
}
else {
	if($_REQUEST['mult'] == 'false'){
		$mult = false;
	} else {
		$mult = true;
	}
}

if(empty($_REQUEST['statusOnly'])){ 
	$statusOnly = false;
}
else {
	if($_REQUEST['statusOnly'] == 'false'){
		$statusOnly = false;
	} else {
		$statusOnly = true;
	}
}

$lista = $idponto;

// if(count($idponto) == 1){
// 	$lista = $idponto[0];
// } else {
// 	$lista = $idponto;
// }

$MSGCODIGO = 19;

if (($latinf != 'undefined') && (!empty($latinf)))
{
	//$Experimento->excluirPonto($idexperimento,$idponto,$idstatus,$latinf,$longinf);
	foreach($lista as $idponto){
		$sql = "update modelr.occurrence set idstatusoccurrence=$idstatus,lat2=$latinf, long2=$longinf ";
		
		$sql.="	where
		idoccurrence = $idponto";
		$res = pg_exec($conn,$sql);

	}
}
else if($mult == true || $statusOnly == true){
	foreach($lista as $idponto){
		$sql = "update modelr.occurrence set idstatusoccurrence=$idstatus ";
		
		$sql.="	where
		idoccurrence = $idponto";
		$res = pg_exec($conn,$sql);

	}
	$filtro = $idstatus;
}
else
{
	//$lista = $_REQUEST['table_records'];
	// FORA DO LIMITE DO BRASIL
	
	// // libera o experimento para a modelagem
	// if (($idstatus == '17') || ($idstatus=='4'))
	// {
	// 	$sql = "update modelr.experiment set idstatusexperiment = 2 where idexperiment = ".$idexperimento;
	// 	$res = pg_exec($conn,$sql);
	// }

	// coodenada zerada
	
	if (($idstatus=='13') || ($idstatus=='99'))
	{
		$sql = "update modelr.occurrence set idstatusoccurrence=13 where
		lat = 0 or long = 0 and
			idexperiment = ".$idexperimento;
		$MSGCODIGO = 73;
		$res = pg_exec($conn,$sql);
	}
	
	// fora do limite do brasil
	if (($idstatus=='10') || ($idstatus=='99'))
	{
		$sql = "update modelr.occurrence set idstatusoccurrence=10 where
			idexperiment = ".$idexperimento." and idstatusoccurrence <> 13 and
			idoccurrence in (
			select idoccurrence from modelr.occurrence o,
 base_geografica.\"shp_limite_brasil_250MIL\" shape
where
not contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || o.long || ' ' || o.lat || ')')) 
			)";
		$MSGCODIGO = 74;
		$res = pg_exec($conn,$sql);
	}
	
	// fora do municipio de origem
	if (($idstatus=='2') || ($idstatus=='99'))
	{
		$sql = "update modelr.occurrence set idstatusoccurrence=2 where
			idexperiment = ".$idexperimento." and
			(idstatusoccurrence <> 13 and idstatusoccurrence <> 10) and
			idoccurrence in (
select idoccurrence from modelr.occurrence o,
 base_geografica.\"municipios_2014\" shape
where
contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || o.long || ' ' || o.lat || ')' )) 
and (shape.nm_uf <> majorarea
or shape.nm_mun <> minorarea)
and majorarea <> '' and minorarea <> ''
)";
//shape.pais <> country
		$res = pg_exec($conn,$sql);

		//teste inverter coordenada
		// pago o que foi marcado como idstatusocurrence = 2
		$sql2 = 'select * from modelr.occurrence where (idstatusoccurrence = 2 or idstatusoccurrence = 8 or idstatusoccurrence = 10 or idstatusoccurrence = 11 or idstatusoccurrence = 19) and
				idexperiment = '.$idexperimento;
		$res2 = pg_exec($conn,$sql2);
		while ($row = pg_fetch_array($res2))
		{	
			$sql3 = "select * from modelr.occurrence o,
				 base_geografica.\"municipios_2014\" shape
				where
				idoccurrence = ".$row['idoccurrence']." and
				contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || o.lat || ' ' || o.long || ')' )) 
				and (shape.nm_uf = majorarea
				and shape.nm_mun = minorarea)";
//			shape.pais = country
			$res3 = pg_exec($conn,$sql3);
			while ($row2 = pg_fetch_array($res3))
			{	
				// troco o status para 4 // normal e inverto a coordenada
				$sql4 = "update modelr.occurrence set idstatusoccurrence=4, lat2 = ".$row2['long'].", long2 = ".$row2['lat']."
						where idoccurrence = ".$row2['idoccurrence'];
				$res4 = pg_exec($conn,$sql4);
			}
		}

		//teste trocar sinal de coordenada (latitude)
		$sql5 = 'select * from modelr.occurrence where (idstatusoccurrence = 2 or idstatusoccurrence = 8 or idstatusoccurrence = 10 or idstatusoccurrence = 11 or idstatusoccurrence = 19) and
				idexperiment = '.$idexperimento.' and lat > 0';
		$res5 = pg_exec($conn,$sql5);
		while ($row3 = pg_fetch_array($res5))
		{	
			$sql6 = "select * from modelr.occurrence o,
				base_geografica.\"municipios_2014\" shape
				where
				idoccurrence = ".$row3['idoccurrence']." and
				contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || o.long || ' ' || -1 * o.lat || ')' )) 
				and (shape.nm_uf = majorarea
				and shape.nm_mun = minorarea)";
		//			shape.pais = country
			$res6 = pg_exec($conn,$sql6);
			while ($row4 = pg_fetch_array($res6))
			{	
				// troco o status para 4 // normal e inverto a coordenada
				$sql7 = "update modelr.occurrence set idstatusoccurrence=4, lat2 = -1 * ".$row4['lat']."
						where idoccurrence = ".$row4['idoccurrence'];
				$res7 = pg_exec($conn,$sql7);
			}
		}

		//teste trocar sinal de coordenada (longitude)
		$sql8 = 'select * from modelr.occurrence where (idstatusoccurrence = 2 or idstatusoccurrence = 8 or idstatusoccurrence = 10 or idstatusoccurrence = 11 or idstatusoccurrence = 19) and
				idexperiment = '.$idexperimento.' and long > 0';
		$res8 = pg_exec($conn,$sql8);
		while ($row5 = pg_fetch_array($res8))
		{	
			$sql9 = "select * from modelr.occurrence o,
				base_geografica.\"municipios_2014\" shape
				where
				idoccurrence = ".$row5['idoccurrence']." and
				contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || -1 * o.long || ' ' || o.lat || ')' )) 
				and (shape.nm_uf = majorarea
				and shape.nm_mun = minorarea)";
		//			shape.pais = country
			$res9 = pg_exec($conn,$sql9);
			while ($row6 = pg_fetch_array($res9))
			{	
				// troco o status para 4 // normal e inverto a coordenada
				$sql10 = "update modelr.occurrence set idstatusoccurrence=4, long2 = -1 * ".$row6['long']."
						where idoccurrence = ".$row6['idoccurrence'];
				$res10 = pg_exec($conn,$sql10);
			}
		}

		//teste trocar sinal de coordenada (latitude e longitude)
		$sql11 = 'select * from modelr.occurrence where (idstatusoccurrence = 2 or idstatusoccurrence = 8 or idstatusoccurrence = 10 or idstatusoccurrence = 11 or idstatusoccurrence = 19) and
				idexperiment = '.$idexperimento.' and (long > 0) and (lat > 0)';
		$res11 = pg_exec($conn,$sql11);
		while ($row7 = pg_fetch_array($res11))
		{	
			$sql12 = "select * from modelr.occurrence o,
				base_geografica.\"municipios_2014\" shape
				where
				idoccurrence = ".$row7['idoccurrence']." and
				contains(GeomFromEWKT(shape.geom),GeomFromEWKT('SRID=4326;POINT(' || -1 * o.long || ' ' || -1 * o.lat || ')' )) 
				and (shape.nm_uf = majorarea
				and shape.nm_mun = minorarea)";
		//			shape.pais = country
			$res12 = pg_exec($conn,$sql12);
			while ($row8 = pg_fetch_array($res12))
			{	
				// echo "entrou";
				// print_r($row8);
				// exit;
				// troco o status para 4 // normal e inverto a coordenada
				$sql13 = "update modelr.occurrence set idstatusoccurrence=4, lat2 = -1 * ".$row8['lat'].", long2 = -1 * ".$row8['long']."
						where idoccurrence = ".$row8['idoccurrence'];
				$res13 = pg_exec($conn,$sql13);
			}
		}


		$MSGCODIGO = 73;
	}

	//marcar pontos com verificados pelo filtro
	$sql = "update modelr.occurrence set idstatusoccurrence=19 where
	idstatusoccurrence=8 and idexperiment = ".$idexperimento;
	$res = pg_exec($conn,$sql);
	
	if ($idstatus=='99')
	{
		// pontos duplicados 
		$Experimento->marcarduplicados($idexperimento);
		$MSGCODIGO = 75;
	}
	
	if ($idstatus=='99')
	{
		// pontos duplicados 
		$Experimento->marcarduplicatas($idexperimento);
		$MSGCODIGO = 75;
	}

}

//criar extent
if($idstatus == '4' || $idstatus == '17'){
	
	if (!file_exists($baseUrl . "temp/" . $idexperimento )) {
		mkdir($baseUrl . "temp/" . $idexperimento , 0777, true);
	}
	#ocorrencias.csv
	$ocorrenciasCSVPath = $baseUrl . 'temp/'. $idexperimento . '/ocorrencias.csv';
	$file = fopen($ocorrenciasCSVPath, 'w');
	fputcsv($file, array("taxon","lon","lat"), ";");
	
	$ws = file_get_contents("https://model-r.jbrj.gov.br/modelr-web/ws/?id=" . $idexperimento);
	$json = json_decode($ws);

	$occurrenceList = $json[0]->occurrences;
	$count = 0;
	foreach($occurrenceList as $occurrence){
		$item = [];
		if($occurrence->idstatusoccurrence == 4 || $occurrence->idstatusoccurrence == 17){
			if($occurrence->lat_ajustada != "") $lat = $occurrence->lat_ajustada;
			else $lat = $occurrence->lat;

			if($occurrence->lon_ajustada != "") $lon = $occurrence->lon_ajustada;
			else $lon = $occurrence->lon;
			array_push($item,$occurrence->taxon,$lon,$lat);
			fputcsv($file, $item, ";");
			$count = $count + 1;
		}
	}
	fclose($file);
	
	$ocorrenciasCSVPath = $baseUrl . 'temp/'. $idexperimento . '/ocorrencias.csv';
	exec("Rscript extent-points.r " . $idexperimento . ' ' . $ocorrenciasCSVPath, $a, $b);
	$oeste = str_replace('xmin',"",$a[1]);
	$oeste = str_replace(' ',"",$oeste);
	$oeste = str_replace(':',"",$oeste);
	$leste = str_replace("xmax","",$a[2]);
	$leste = str_replace(" ","",$leste);
	$leste = str_replace(":","",$leste);
	$sul = str_replace("ymin","",$a[3]);
	$sul = str_replace(" ","",$sul);
	$sul = str_replace(":","",$sul);
	$norte = str_replace("ymax","",$a[4]);
	$norte = str_replace(" ","",$norte);
	$norte = str_replace(":","",$norte);
	
	$extensao = $leste.';'.$oeste.';'.$norte.';'.$sul;
	$result = $Experimento->incluirExtensao($idexperimento, $extensao);
	$result = $Experimento->incluirProjecao($idexperimento, $extensao);
	
}

header("Location: cadexperimento.php?op=A&MSGCODIGO=$MSGCODIGO&tab=10&pag=2&id=$idexperimento&filtro=$filtro");
?>



