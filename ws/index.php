<?php 
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');
require_once('../classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar(); 

$sql = 'select * from modelr.experiment left join modelr.partitiontype on
(experiment.idpartitiontype = partitiontype.idpartitiontype )
, modelr.statusexperiment 
where experiment.idstatusexperiment = statusexperiment.idstatusexperiment 
 ';

if (isset($_GET['id']))
{
	$id = intval($_GET['id']);
	$sql.=' and experiment.idexperiment = '.$id;
}
if (isset($_GET['idexperiment']))
{
	$idexperiment = $_GET['idexperiment'];
	$sql.=" and md5(cast(experiment.idexperiment as text)) = '".$idexperiment."' ";
}
if (isset($_GET['status']))
{
	$id = intval($_GET['status']);
	$sql.=' and experiment.idstatusexperiment = '.$id;
}


$res = pg_exec($conn,$sql);
$qtd = pg_num_rows($res);

$json_str = '[';
$c = 0;
while ($row = pg_fetch_array($res))
{	
	$c++;
	$sql2 = 'select * from modelr.occurrence where idexperiment = '.$row['idexperiment'];
	$res2 = pg_exec($conn,$sql2);
	$qtd2 = pg_num_rows($res2);
	$c2 = 0;
	$json_str2='[';
	while ($row2 = pg_fetch_array($res2))
	{
		$c2++;
		if ($c2<$qtd2)
		{	
			$json_str2.='{"taxon":"'.$row2['taxon'].'", "lat":"'.$row2['lat'].'", "lon": "'.$row2['long'].'", "lat_ajustada": "'.$row2['lat2'].'", "lon_ajustada": "'.$row2['long2'].'", "idstatusoccurrence": "'.$row2['idstatusoccurrence'].'"},';
		}
		else
		{
			$json_str2.='{"taxon":"'.$row2['taxon'].'", "lat":"'.$row2['lat'].'", "lon": "'.$row2['long'].'", "lat_ajustada": "'.$row2['lat2'].'", "lon_ajustada": "'.$row2['long2'].'", "idstatusoccurrence": "'.$row2['idstatusoccurrence'].'"}';
		}
		
	}
	$json_str2 .=']';
	
	// VARIÁVEIS ABIÓTICAS
	$sql3 = 'select r.idraster,r.raster,r.resolution,r.period, s.source, eur.params from modelr.experiment_use_raster eur,
modelr.raster r, modelr.source s where
eur.idraster = r.idraster and
r.idsource = s.idsource and
eur.idexperiment = '.$row['idexperiment'];
	$res3 = pg_exec($conn,$sql3);
	$qtd3 = pg_num_rows($res3);
	$c3 = 0;
	$json_str3='[';
	while ($row3 = pg_fetch_array($res3))
	{
		$c3++;
		if ($c3<$qtd3)
		{	
			$json_str3.='{"raster":"'.$row3['raster'].'", "source":"'.$row3['source'].'", "period":"'.$row3['period'].'", "resolution":"'.$row3['resolution'].'", "idraster": "'.$row3['idraster'].'","params":"'.$row3['params'].'"},';
		}
		else
		{
			$json_str3.='{"raster":"'.$row3['raster'].'", "source":"'.$row3['source'].'", "period":"'.$row3['period'].'", "resolution":"'.$row3['resolution'].'", "idraster": "'.$row3['idraster'].'","params":"'.$row3['params'].'"}';
		}
	}
	$json_str3 .=']';
	
	
	// Algoritmos
	$sql4 = 'select a.idalgorithm ,a.algorithm from modelr.experiment_use_algorithm eua, modelr.algorithm a where
eua.idalgorithm = a.idalgorithm and
eua.idexperiment = '.$row['idexperiment'];
	$res4 = pg_exec($conn,$sql4);
	$qtd4 = pg_num_rows($res4);
	$c4 = 0;
	$json_str4='[';
	while ($row4 = pg_fetch_array($res4))
	{
		$c4++;
		if ($c4<$qtd4)
		{	
			$json_str4.='{"algorithm":"'.$row4['algorithm'].'", "idalgorithm":"'.$row4['idalgorithm'].'"},';
		}
		else
		{
			$json_str4.='{"algorithm":"'.$row4['algorithm'].'", "idalgorithm":"'.$row4['idalgorithm'].'"}';
		}
	}
	$json_str4 .=']';

	// Modelos
	$sql5 = 'select a.idmodel,a.model from modelr.experiment_use_model eua, modelr.models a where
eua.idmodel = a.idmodel and
eua.idexperiment = '.$row['idexperiment'];
	$res5 = pg_exec($conn,$sql5);
	$qtd5 = pg_num_rows($res5);
	$c5 = 0;
	$json_str5='[';
	while ($row5 = pg_fetch_array($res5))
	{
		$c5++;
		if ($c5<$qtd5)
		{	
			$json_str5.='{"model":"'.$row5['model'].'", "idmodel":"'.$row5['idmodel'].'"},';
		}
		else
		{
			$json_str5.='{"model":"'.$row5['model'].'", "idmodel":"'.$row5['idmodel'].'"}';
		}
	}
	$json_str5 .=']';
	
			
	if ($c<$qtd)
	{	
		$json_str.='{"idexperiment":"'.md5($row['idexperiment']).'", "id":"'.$row['idexperiment'].'", "name":"'.$row['name'].'", "description": "'.$row['name'].'", "num_repetitions": "'.$row['repetitions'].'", "num_partition": "'.$row['num_partition'].'", "trainpercent": "'.$row['trainpercent'].'", "extent_model": "'.$row['extent_model'].'", "extent_projection": "'.$row['extent_projection'].'", "buffer": "'.$row['buffer'].'", "num_points": "'.$row['num_points'].'",  "tss": "'.$row['tss'].'", "threshold_bin": "'.$row['threshold_bin'].'", "statusexperiment": "'.$row['statusexperiment'].'","partitiontype": "'.$row['partitiontype'].'","resolution": "'.$row['resolution'].'", "occurrences": '.$json_str2.',"raster": '.$json_str3.',"algorithm": '.$json_str4.', "model": '.$json_str5.'},';
	}
	else
	{
		$json_str.='{"idexperiment":"'.md5($row['idexperiment']).'", "id":"'.$row['idexperiment'].'", "name":"'.$row['name'].'", "description": "'.$row['name'].'", "num_repetitions": "'.$row['repetitions'].'", "num_partition": "'.$row['num_partition'].'", "trainpercent": "'.$row['trainpercent'].'", "extent_model": "'.$row['extent_model'].'", "extent_projection": "'.$row['extent_projection'].'", "buffer": "'.$row['buffer'].'", "num_points": "'.$row['num_points'].'",  "tss": "'.$row['tss'].'", "threshold_bin": "'.$row['threshold_bin'].'", "statusexperiment": "'.$row['statusexperiment'].'","partitiontype": "'.$row['partitiontype'].'","resolution": "'.$row['resolution'].'", "occurrences": '.$json_str2.', "raster": '.$json_str3.',"algorithm": '.$json_str4.', "model": '.$json_str5.'}';
	}
}
$json_str .=']';
echo $json_str;
?>