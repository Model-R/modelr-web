<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$id = $_REQUEST['expid'];

//-------------------------------------------------------------
//Atualizar parâmetros antes de executar a modelagem

$idtipoparticionamento = $_REQUEST['cmboxtipoparticionamento'];
$numpontos = $_REQUEST['edtnumpontos'];
$buffer = $_REQUEST['edtbuffer'];
$tss = $_REQUEST['edttss'];
$threshBin = $_REQUEST['edtbin'];
$numparticoes = $_REQUEST['edtnumparticoes'];
//$resolution = $_REQUEST['edtresolution'];
$repetitions = $_REQUEST['edtnumrepetitions'];
$trainpercent = $_REQUEST['edttrainpercent'];

$Experimento->idpartitiontype = $idtipoparticionamento;//integer,
$Experimento->num_partition = $numparticoes;//integer,
$Experimento->num_points = $numpontos ;//integer,
$Experimento->buffer = "'" . $buffer[0] . "'" ;//string
$Experimento->tss = $tss;
$Experimento->threshold_bin = $threshBin;
//$Experimento->resolution = "'" . $resolution[0] . "'";
$Experimento->repetitions = $repetitions;
$Experimento->trainpercent = $trainpercent;


$result = $Experimento->limparAlgoritmo($id);

$box=$_REQUEST['algoritmo'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirAlgoritmo($id,$val);
}

$result = $Experimento->LimparModelo($id);

$box=$_REQUEST['modelos'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirModelo($id,$val);
}

$result = $Experimento->alterar($id);

//-------------------------------------------------------------
$ws = file_get_contents("https://model-r.jbrj.gov.br/modelr-web/ws/?id=" . $id);
$json = json_decode($ws); 
// print_r($json);
// exit;

if(dirname(__FILE__) !== '/var/www/html/rafael/modelr'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
}
if($_SESSION['s_idtipousuario']==6 && sizeof($json[0]->raster) == 0){
	header("Location: cadexperimento.php?op=A&tab=6&MSGCODIGO=78&id=" . $id);
	exit;
}

# preciso enviar ocorrencias.csv, raster.csv, partitions, buffer, num_points, tss, hash id
#hash id

$hashId = $json[0]->idexperiment;

#Change experiment status
$sql =" update modelr.experiment set idstatusexperiment = '3' where
		md5(cast(idexperiment as text)) = '".$hashId."'";
		
		$res = pg_exec($conn,$sql);
		
rrmdir($baseUrl . "temp/result/" . $hashId);
removeRowExperimentResult($conn, $id);

//echo 'hashId: ' . $hashId;
//echo '<br>';
#partitions
$partitions = $json[0]->num_partition;
//echo 'partitions: ' . $partitions;
//echo '<br>';
#buffer
$buffer = $json[0]->buffer;
//echo 'buffer: ' . $buffer;
//echo '<br>';
#num_points
$num_points = $json[0]->num_points;
//echo 'num_points: ' . $num_points;
//echo '<br>';
#tss
$tss = $json[0]->tss;
//echo 'tss: ' . $tss;
//echo '<br>';
#threshold_bin
$threshold_bin = $json[0]->threshold_bin;
//echo 'threshold_bin: ' . $threshold_bin;
//echo '<br>';
#partition type
$partitiontype = strtolower($json[0]->partitiontype);
//echo 'partitiontype: ' . $partitiontype;
//echo '<br>';
$resolution= $json[0]->resolution;
//echo 'resolution: ' . $resolution;
//echo '<br>';
$repetitions= $json[0]->num_repetitions;
//echo 'repetitions: ' . $repetitions;
//echo '<br>';
$trainpercent= $json[0]->trainpercent;
//echo 'trainpercent: ' . $trainpercent;
//echo '<br>';
#raster.csv
$rasterList = $json[0]->raster;
$rasterPathList = [];

echo $resolution;
#checar se usuário é Reflora - Raster -> PCA
if($_SESSION['s_idtipousuario']==5){
	$path = 'mnt/dados/modelr/env';
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_05.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_06.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_12.tif' . "'");
	array_push($rasterPathList,"'" . $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_13.tif' . "'");
} else {
	foreach($rasterList as $raster){
		$path = 'mnt/dados/modelr/env';
		if($raster->source == 'Worldclim v1' || $raster->source == 'WordClim v1'){
			$path = $path . '/Worldclim1/'.$resolution.'min/' . strtolower(explode(" ",$raster->raster)[0]) . '.bil';
			array_push($rasterPathList,"'" . $path . "'");
		} else if($raster->source == 'Worldclim v2' || $raster->source == 'WordClim v2'){
			$bio = str_replace("bio","",strtolower(explode(" ",$raster->raster)[0]));
			if($bio < 10) {
				$path = $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_0' . $bio . '.tif';
				array_push($rasterPathList,"'" . $path . "'");
			} else {
				$path = $path . '/Worldclim2/'.$resolution.'min/wc2.0_bio_'.$resolution.'m_' . $bio . '.tif';
				array_push($rasterPathList,"'" . $path . "'");
			}
		} else if($raster->source == 'Chelsa'){
			$bio = str_replace("bio","",strtolower(explode(" ",$raster->raster)[0]));
			$path = $path . '/Chelsa/CHELSA_bio10_' . $bio . '.tif';
			array_push($rasterPathList,"'" . $path . "'");
		} else if($raster->source == 'PCA'){
			$path = $path . '/PCA/1Km_.eigenvariables.tif';
			array_push($rasterPathList,"'" . $path . "'");
		} else {
			$params = explode(",",$raster->params);
			foreach($params as $param){
				$path = 'mnt/dados/modelr/env';
	//			echo $raster->raster;
		//		echo '<br>';
				if($raster->raster == 'pH'){
					$path = $path . '/Biooracle/Surface/Present.Surface.' . $raster->raster .'.tif';
				} else {
					$path = $path . '/Biooracle/Surface/Present.Surface.' . $raster->raster . ' '. $param .'.tif';
				}
				array_push($rasterPathList,"'" . str_replace(' ', '.', $path) . "'");
			}
		}
	}
}

if (!file_exists($baseUrl . "temp/" . $id )) {
    mkdir($baseUrl . "temp/" . $id , 0777, true);
}
if (!file_exists($baseUrl . "temp/result/" . $hashId )) {
    mkdir($baseUrl . "temp/result/" . $hashId  , 0777, true);
}

$rasterCSVPath = $baseUrl . 'temp/'. $id . '/raster.csv';
$file = fopen($rasterCSVPath, 'w');
fputcsv($file, $rasterPathList, ";");
fclose($file);
 
#ocorrencias.csv
$ocorrenciasCSVPath = $baseUrl . 'temp/'. $id . '/ocorrencias.csv';
$file = fopen($ocorrenciasCSVPath, 'w');
fputcsv($file, array("taxon","lon","lat"), ";");

$occurrenceList = $json[0]->occurrences;
$count = 0;
$speciesName;
foreach($occurrenceList as $occurrence){
    $item = [];
	if($occurrence->idstatusoccurrence == 4 || $occurrence->idstatusoccurrence == 17){
		array_push($item,$occurrence->taxon,$occurrence->lon,$occurrence->lat);
		fputcsv($file, $item, ";");
		$count = $count + 1;
		$speciesName = $occurrence->taxon;
	}
}
fclose($file);

#algorithms.csv
$algorithmJSONList = $json[0]->algorithm;
$algorithmList = [];
foreach($algorithmJSONList as $algorithm){
	//print_r($algorithm->algorithm);
	array_push($algorithmList,$algorithm->algorithm);
}

#Mahalanobis;Maxent;GLM;Bioclim;Random Forest;Domain;SVM 
$arrayAlg = array('F','F','F','F','F','F','F');
if(in_array("Mahalanobis", $algorithmList)){
	$arrayAlg[0] = 'TRUE';
}
if(in_array("Maxent", $algorithmList)){
	$arrayAlg[1] = 'TRUE';
}
if(in_array("GLM", $algorithmList)){
	$arrayAlg[2] = 'TRUE';
}
if(in_array("Bioclim", $algorithmList)){
	$arrayAlg[3] = 'TRUE';
}
if(in_array("Random Forest", $algorithmList)){
	$arrayAlg[4] = 'TRUE';
}
if(in_array("Domain", $algorithmList)){
	$arrayAlg[5] = 'TRUE';
}
if(in_array("SVM", $algorithmList)){
	$arrayAlg[6] = 'TRUE';
}

#models
$modelJSONList = $json[0]->model;
$modelList = [];
foreach($modelJSONList as $model){
	//print_r($model->model);
	array_push($modelList,$model->model);
}

#extent model

$ExtentModelPath = $baseUrl . "temp/" . $id . "/extent_model.json";
$file = fopen($ExtentModelPath, 'w');

$extent_model = $json[0]->extent_model;

if($extent_model == ""){
	$ExtentModelPath = $baseUrl . 'temp/dados/polygon-brazil.json';
	//echo $ExtentModelPath;
} else {
	$extent_model = explode(";",$extent_model);
	
	$east = $extent_model[0];
	$west = $extent_model[1];
	$north = $extent_model[2];
	$south = $extent_model[3];
	
	$result = [];
	$result[] = [$west,$north];
	$result[] = [$west,$south];
	$result[] = [$east,$south];
	$result[] = [$east,$north];
	$coordinates[] = [$result];
	
	$myObj->type = "MultiPolygon";
	$myObj->coordinates = $coordinates;
	$myJSON = json_encode($myObj, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);

	fwrite($file, $myJSON);
	fclose($file);
	print_r($myJSON);
}

#projection model
$ProjectionModelPath = $baseUrl . "temp/" . $id . "/projection_model.json";
$file2 = fopen($ProjectionModelPath, 'w');

$projection_model = $json[0]->extent_projection;
echo $projection_model;
echo '<br>';

if($projection_model == ""){
	$ProjectionModelPath = $baseUrl . 'temp/dados/polygon-brazil.json';
	////echo $ProjectionModelPath;
} else {
	$projection_model = explode(";",$projection_model);
	$west = $projection_model[0];
	$east = $projection_model[1];
	$north = $projection_model[2];
	$south = $projection_model[3];

	$result = [];
	$result[] = [$west,$north];
	$result[] = [$west,$south];
	$result[] = [$east,$south];
	$result[] = [$east,$north];
	$coordinates2[] = [$result];
	
	$myObj2->type = "MultiPolygon";
	$myObj2->coordinates = $coordinates2;
	$myJSON2 = json_encode($myObj2, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);

	fwrite($file2, $myJSON2);
	fclose($file2);
}

#start time
$time = $_SESSION['s_nome'] . " - experimento " . $id . " - Inicio: " . date("h:i:sa");



//---------------------------------------
$algString = implode(";",$arrayAlg);
$modelString = implode(";",$modelList);

// exec("Rscript script_number_valid_points.r " . $id . ' ' . $rasterCSVPath . ' '. $ocorrenciasCSVPath . ' ' . $ExtentModelPath, $a, $b);
// $returnData = explode(" ",$a[1]);
// if($returnData[0] < 10){
	// header("Location: cadexperimento.php?op=A&tab=6&MSGCODIGO=76&id=" . $id);
// } else {
	// echo "Rscript script_modelagem.r $id $hashId $repetitions $partitions $partitiontype $trainpercent '$buffer' $num_points $tss $threshold_bin '$rasterCSVPath' '$ocorrenciasCSVPath' '$algString' '$ExtentModelPath' '$ProjectionModelPath' '$modelString'";
	// exit;
	exec("Rscript script_modelagem.R $id $hashId $repetitions $partitions $partitiontype $trainpercent '$buffer' $num_points $tss $threshold_bin '$rasterCSVPath' '$ocorrenciasCSVPath' '$algString' '$ExtentModelPath' '$ProjectionModelPath' '$modelString' &");
	if (!file_exists($baseUrl . "temp/result/" . $hashId . "/" . $speciesName . ".csv")) {
		header("Location: cadexperimento.php?op=A&tab=6&MSGCODIGO=77&id=" . $id);
	} else {
		$csvFile = file($baseUrl . "temp/result/" . $hashId . "/" . $speciesName . "/present/final_models/".$speciesName."_final_statistics.csv");
		echo $baseUrl . "temp/result/" . $hashId . "/" . $speciesName . "/present/final_models/".$speciesName."_final_statistics.csv";
		echo "<br>";
		$data = [];
		foreach ($csvFile as $line) {
			$csvline = str_getcsv($line);
			if($csvline[2] != "kappa"){	
				addToExperimentResult($conn, $id, $csvline, $speciesName,$hashId);
			}
		}
		
		//procurar without_margins.png
		$dir = '/var/www/html/rafael/modelr/temp/result/'.$hashId.'/'.$speciesName.'/present/ensemble/';
		$files = scandir($dir);
		foreach ($files as $f) {
			if (strpos($f, 'without_margins') !== false) {
				addMapImageToExperimentResult($conn, $id, $speciesName,$hashId,$dir . $f);
			}
		}
		$sql =" update modelr.experiment set idstatusexperiment = '4' where
		md5(cast(idexperiment as text)) = '".$hashId."'";
		
		$res = pg_exec($conn,$sql);
		calculateTime($time);
		header("Location: cadexperimento.php?op=A&tab=14&id=" . $id);
	}
//}  


function rrmdir($dir) { 
	if (is_dir($dir)) { 
	  $objects = scandir($dir); 
	  foreach ($objects as $object) { 
		if ($object != "." && $object != "..") { 
		  if (is_dir($dir."/".$object))
			rrmdir($dir."/".$object);
		  else
			unlink($dir."/".$object); 
		} 
	  }
	  rmdir($dir); 
	} 
} 

function removeRowExperimentResult ($conn, $expid){
	$sql = "delete from modelr.experiment_result where idexperiment=" . $expid;
	//		echo $sql;

	$res = pg_exec($conn,$sql);
}

function addToExperimentResult ($conn, $expid, $expdata, $speciesName,$hashId) {
	$baseUrl = '/var/www/html/rafael/modelr/temp/result/'.$hashId.'/'.$speciesName.'/present/partitions/';
	for ($i = 1; $i <= 3; $i++) {
		$partition = $expdata[12];
		$algorithm = str_replace('"',"",$expdata[10]);

		if($i == 1){
			$raster_png_path = '';
			$png_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '001.png';
			$tiff_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '.tif';
		}
		else if($i == 2){
			$raster_png_path = '';
			$png_path = $baseUrl.$algorithm  . $speciesName . '_' . $partition . '002.png';
			$tiff_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '.tif';
		}
		else if($i == 3){
			$raster_png_path = '';
			$png_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '003.png';
			$tiff_path = $baseUrl.$algorithm . $speciesName . '_' . $partition . '.tif';
		}
		$unhashedid = $expid;
		$idresulttype = (100 + $i);
		$tss = $expdata[9];
		$auc = $expdata[8];
		$sensitivity = $expdata[7];
		$equal_sens_spec = $expdata[6];
		$prevalence = $expdata[5];
		$no_omission = $expdata[4];
		$spec_sens = $expdata[3];
		$kappa = $expdata[2];
		$sql = "insert into modelr.experiment_result (
				idexperiment ,  idresulttype ,  
			partition ,  algorithm ,  tss,  auc ,  sensitivity ,  equal_sens_spec ,
	  prevalence ,  no_omission ,  spec_sens, raster_bin_path, raster_cont_path, raster_cut_path,
	  png_bin_path, png_cont_path, png_cut_path , kappa, raster_path, raster_png_path, png_path, tiff_path
	  ) values
	  (".$unhashedid.",".$idresulttype.",".$partition.",
	  '".$algorithm."',".$tss.",".$auc.",".$sensitivity.",".$equal_sens_spec.",".$prevalence.",
	  ".$no_omission.",".$spec_sens.",
	  '','','','','','',".$kappa.",'','".$raster_png_path."','".$png_path."','".$tiff_path."'
	  );";
	//		echo $sql;
	
		$res = pg_exec($conn,$sql);
	}
}	

function addMapImageToExperimentResult ($conn, $expid, $speciesName,$hashId, $withoutMarginPng) {
	$baseUrl = '/var/www/html/rafael/modelr/temp/result/'.$hashId.'/'.$speciesName.'/present/ensemble/';
		$partition = '';
		$algorithm = '';
		$raster_png_path = $withoutMarginPng;
		$png_path = $baseUrl.$speciesName . '_cut_mean_th_ensemble_mean.png';
		$tiff_path = $baseUrl.$speciesName . '_cut_mean_th_ensemble_mean.tif';
		$unhashedid = $expid;
		$idresulttype = 303;
		$tss = '';
		$threshold_bin = '';
		$auc = '';
		$sensitivity = '';
		$equal_sens_spec = '';
		$prevalence = '';
		$no_omission = '';
		$spec_sens = '';
		$kappa = '';
		$sql = "insert into modelr.experiment_result (
				idexperiment ,  idresulttype ,  
			partition ,  algorithm ,  tss, auc ,  sensitivity ,  equal_sens_spec ,
	  prevalence ,  no_omission ,  spec_sens, raster_bin_path, raster_cont_path, raster_cut_path,
	  png_bin_path, png_cont_path, png_cut_path , kappa, raster_path, raster_png_path, png_path, tiff_path
	  ) values
	  (".$unhashedid.",".$idresulttype.",null,
	  '".$algorithm."',null,null,null,null,null,
	  null,null,
	  '','','','','','',null,'','".$raster_png_path."','".$png_path."','".$tiff_path."'
	  );";
	
		$res = pg_exec($conn,$sql);
}

function calculateTime ($time) {
	print_r($_SESSION);
	if (!file_exists($baseUrl . "temp/dados" )) {
		mkdir($baseUrl . "temp/dados", 0777, true);
	}
	$dadosPath = $baseUrl . 'temp/dados/listamodelagem.txt';
	$myfile = fopen($dadosPath, "w");
	$txt = $time . " - Final: ". date("h:i:sa") . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}	
?>