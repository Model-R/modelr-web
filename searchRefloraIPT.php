
<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');
header('Content-type: text/html; charset=utf-8');
setlocale( LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'Portuguese_Brazil');

if(dirname(__FILE__) != '/var/www/html/rafael/modelr'){
	$baseUrl = '../';
} else {
	$baseUrl = '';
}

if (!is_dir($baseUrl . "../modelr-data")) {
    mkdir($baseUrl . "../modelr-data/ipt/reflora/searches", 0777, true);
}

$expid = $_REQUEST['expid'];
$sp = $_REQUEST['sp'];

exec("Rscript  searchIPT/reflora/search_inside_ipts.R $expid '$sp'", $a, $b);

$json = getJsonFromCsv($baseUrl . "../modelr-data/ipt/reflora/searches/" . $sp . "_ocurrence_list-exp" . $expid . ".csv", ',');
echo $json;
exit;
function getJsonFromCsv($file,$delimiter) { 
    if (($handle = fopen($file, 'r')) === false) {
        die('Error opening file');
    }

    $headers = fgetcsv($handle, 4000, $delimiter);
    $csv2json = array();

    while ($row = fgetcsv($handle, 4000, $delimiter)) {
      $csv2json[] = array_combine($headers, $row);
    }

    fclose($handle);
    return json_encode($csv2json, JSON_UNESCAPED_UNICODE); 
}
?>