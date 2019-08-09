<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');

class Experimento	
{
	var $conn;
	var $idexperiment;
	var $name;
	var $description;
	var $group;
	
	var $idpartitiontype ;//integer,
	var $num_partition ;//integer,
	var $num_points ;//integer,
	var $buffer ;//numeric(10,2),
	var $extent_model;
	var $extent_projection;
	var $tss;
	var $threshold_bin;
	var $resolution;
	var $repetitions;
	var $trainpercent;

	var $pngCutPath;
	var $rasterCutPath;
	var $pngBinPath;
	var $pngContPath;
	var $isImageCut;
	var $pngPath;
	var $rasterPath;
	var $rasterPngPath;
	var $tiffPath;
	
	var $iduser;
	var $type;
	var $automaticfilter;

	var $statusExperiment;
	
	function trocarNome($id,$nome)
	{
		$sql = "update modelr.experiment set name = '".$nome."' where idexperiment=".$id;
		$resultado = pg_exec($this->conn,$sql);
		
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function incluirRaster($id,$idraster)
	{
		$sql = 'insert into modelr.experiment_use_raster (idexperiment,idraster)
		values ('.$id.','.$idraster.')';
//		echo $sql.'<br>';
		
		$resultado = pg_exec($this->conn,$sql);
		
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function limparRaster($id)
	{	
		$sql = "delete from modelr.experiment_use_raster where idexperiment = '".$id."'; ";
		
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function incluirBioOracleRaster($id,$idraster,$params)
	{	
		$sql = "select * from modelr.experiment_use_raster where idexperiment=" . $id . " and idraster=" . $idraster .";";
		$res = pg_exec($this->conn,$sql);

		if (pg_num_rows($res)>0)
		{
			$sql = "update modelr.experiment_use_raster set params = '".$params."' where idexperiment=".$id." and idraster=" . $idraster. ";";
			$resultado = pg_exec($this->conn,$sql);
		}
		else {
			$sql = "insert into modelr.experiment_use_raster (idexperiment,idraster,params)
			values (".$id.",".$idraster.",'".$params."')";
			
			$resultado = pg_exec($this->conn,$sql);
		}
		
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function incluirResolucao($id,$resolution)
	{
		$sql = "update modelr.experiment set 
		   resolution = ".$resolution."where idexperiment='".$id."' ";
		$res2 = pg_exec($this->conn,$sql);
		//print_r($sql);
		//print_r($res2);
		//exit;
	}
	
	function incluirAlgoritmo($id,$idalgoritmos)
	{
		$sql = 'insert into modelr.experiment_use_algorithm (idexperiment,idalgorithm)
		values ('.$id.','.$idalgoritmos.')';
		$res2 = pg_exec($this->conn,$sql);
	}

	function incluirModelo($id,$idmodelo)
	{
		$sql = 'insert into modelr.experiment_use_model (idexperiment,idmodel)
		values ('.$id.','.$idmodelo.')';
		$res2 = pg_exec($this->conn,$sql);
	}
	
	function limparAlgoritmo($id)
	{
		$sql = "delete from modelr.experiment_use_algorithm where idexperiment = '".$id."'; ";
		$res2 = pg_exec($this->conn,$sql);
	}

	function limparModelo($id)
	{
		$sql = "delete from modelr.experiment_use_model where idexperiment = '".$id."'; ";
		$res2 = pg_exec($this->conn,$sql);
	}

	function incluirExtensao($id, $extent)
	{
		$sql = "update modelr.experiment set 
		extent_model = '".$extent."'
		where idexperiment='".$id."' ";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function incluirAutomaticFilter($id, $filter)
	{
		$sql = "update modelr.experiment set 
		automatic_filter = ".$filter."
		where idexperiment='".$id."' ";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function incluirProjecao($id, $extent)
	{
		$sql = "update modelr.experiment set 
		extent_projection = '".$extent."'
		where idexperiment='".$id."' ";
		// echo $sql;
		// exit;
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function usaAlgoritmo($id,$idalgoritmos)
	{

		$sql = 'select * from modelr.experiment_use_algorithm where idexperiment = '.$id.';';
		$res = pg_exec($this->conn,$sql);

		if (pg_num_rows($res)>0)
		{
			$sql2 = 'select * from modelr.experiment_use_algorithm where idexperiment = '.$id.' and idalgorithm = '.$idalgoritmos.';';
			$res2 = pg_exec($this->conn,$sql2);
			if (pg_num_rows($res2)>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}		
	}

	function usaModelo($id,$idmodelo)
	{

		$sql = 'select * from modelr.experiment_use_model where idexperiment = '.$id.';';
		$res = pg_exec($this->conn,$sql);

		if (pg_num_rows($res)>0)
		{
			$sql2 = 'select * from modelr.experiment_use_model where idexperiment = '.$id.' and idmodel = '.$idmodelo.';';
			$res2 = pg_exec($this->conn,$sql2);
			if (pg_num_rows($res2)>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}		
	}

	function usaRaster($id,$idraster)
	{	
		$sql = 'select * from modelr.experiment_use_raster where idexperiment = '.$id.' and idraster = '.$idraster.';';
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			return true;
		}
		else
		{	
			$sql2 = 'select * from modelr.experiment_use_raster where idexperiment = '.$id.';';
			$res2 = pg_exec($this->conn,$sql2);
			if (pg_num_rows($res2)>0){
				return false;
			} 
		}		
	}	
	
	function usaBioRaster($id,$idraster,$value)
	{	
		$sql = 'select params from modelr.experiment_use_raster where idexperiment = '.$id.' and idraster = '.$idraster.';';
		$res = pg_exec($this->conn,$sql);
		if (pg_num_rows($res)>0)
		{
			while ($row = pg_fetch_array($res))
			{				
				$values = explode(",",$row['params']);
				$key = array_search($value,$values);
				if($key === false) return false;
				else return true;
			}
		}
		
	}	
	
	function marcarduplicatas($idexperimento)
	{
		$sql = "select * from modelr.occurrence where idexperiment = $idexperimento order by idoccurrence";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{				
			$sql2 = "update modelr.occurrence set idstatusoccurrence=18 where idexperiment = $idexperimento and
			lat = ".$row['lat']." and
			long = ".$row['long']." and
			taxon = '".$row['taxon']."' and
			collector = '".$row['collector']."' and
			collectnumber = '".$row['collectnumber']."' and
			idoccurrence > ".$row['idoccurrence'];
//			echo $sql2;
//			echo ';<br>';
			$res2 = pg_exec($this->conn,$sql2);
		}
//		exit;
	}
	
	function marcarduplicados($idexperimento)
	{
		$sql = "select * from modelr.occurrence where idexperiment = $idexperimento order by idoccurrence";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{				
			$sql2 = "update modelr.occurrence set idstatusoccurrence=20 where idexperiment = $idexperimento and
			lat = ".$row['lat']." and
			long = ".$row['long']." and
			taxon = '".$row['taxon']."' and
			idoccurrence > ".$row['idoccurrence'];
//			echo $sql2;
//			echo ';<br>';
			$res2 = pg_exec($this->conn,$sql2);
		}
//		exit;
	}

	
	function excluirpontosduplicados($idexperimento)
	{
		$sql = "select * from modelr.occurrence where idexperiment = $idexperimento order by idoccurrence";
		$res = pg_exec($this->conn,$sql);
		while ($row = pg_fetch_array($res))
		{				
			$sql2 = "delete from modelr.occurrence where idexperiment = $idexperimento and
			lat = ".$row['lat']." and
			long = ".$row['long']." and
			taxon = '".$row['taxon']."' and
			collector = '".$row['collector']."' and
			collectnumber = '".$row['collectnumber']."' and
			idoccurrence > ".$row['idoccurrence'];
//			echo $sql2;
//			echo ';<br>';
			$res2 = pg_exec($this->conn,$sql2);
		}
//		exit;
	}

	function excluirPonto($idexperimento,$idponto,$idstatus,$latinf,$longinf)
	{
		// if (($idstatus == '17') || ($idstatus=='4'))
		// {
		// 	$sql = "update modelr.experiment set idstatusexperiment = 2 where idexperiment = ".$idexperimento;
		// 	$res = pg_exec($this->conn,$sql);
		// }
		
		$sql = "update modelr.occurrence set idstatusoccurrence = ".$idstatus; 
		if ((!empty($latinf)) && (!empty($longinf)))
		{
			$sql.= ", lat2 = ".$latinf.", long2 = ".$longinf." ";
		}
	
		$sql.="	where idoccurrence = $idponto";
		$res = pg_exec($this->conn,$sql);
	}
	function alterarstatusponto($idexperimento,$idponto,$idstatus)
	{
		$sql = "update modelr.occurrence set idstatusoccurrence = ".$idstatus." where idoccurrence = $idponto";
		$res = pg_exec($this->conn,$sql);
//		echo $sql;
//		exit;
	}

	function adicionarOcorrencia($idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$p,$e,$m,$herbario,$tombo,$codtestemunho,$fonte,$localidade)
	{	
		// echo $idexperimento;
		// exit;
		
 		$sql = "insert into modelr.occurrence (idexperiment,
		iddatasource,
		lat,
		long,
		taxon,
		herbario,
		numtombo,
		collector,
		collectnumber,
		server,
		path,
		file,
		idstatusoccurrence,
		country,
		majorarea,
		minorarea,
		codtestemunho,
		fonte,
		locality
		) values (
		'".$idexperimento."',
		'".$idfontedados."',
		".$lat.",
		".$long.",
		'".$taxon."',
		'".$herbario."',
		'".$tombo."',
		'".$coletor."',
		'".$numcoleta."',
		'".$imagemservidor."',
		'".$imagemcaminho."',
		'".$imagemarquivo."',
		8,
		'".$p."',
		'".$e."',
		'".$m."',
		".$codtestemunho.",
		'".$fonte."',
		'".$localidade."'
		)";
		
		// echo $sql . "<br>";
		// exit;
		// 8 status occurrence = OK
		$resultado = pg_exec($this->conn,$sql);
		//echo $resultado;
		//echo '<br>';
		//echo '<br>';
		//exit;
		
		//if ($resultado){

	   	//}
		
	}
	
	function limparDados($idexperimento, $filtro)
	{
		
		if(empty($filtro)){
			$sql = "update modelr.experiment set idstatusexperiment = 1 where idexperiment = ".$idexperimento.";
			delete from modelr.occurrence where idexperiment = ".$idexperimento;
		} else {
			$sql = "delete from modelr.occurrence where idexperiment = ".$idexperimento . "and idstatusoccurrence=" . $filtro;
		}
 	
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	
	function incluir()
	{
 		$sql = "insert into modelr.experiment (name,description,group_name,iduser,idstatusexperiment,type,idpartitiontype,num_partition,num_points,tss,threshold_bin,buffer,resolution,repetitions,trainpercent
		) values (
		'".$this->name."',
		'".$this->description."',
		'".$this->group."',
		'".$this->iduser."',1,
		'".$this->type."',
		1,
		3,
		1000,
		0.60,
		0.50,
		'mean',
		10,
		1,
		50
		)";
		
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idexperiment) from modelr.experiment";
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);

			// $this->incluirAlgoritmo($row[0],2);
			// $this->incluirAlgoritmo($row[0],5);

			return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function clonar($id, $sp)
	{
 		$sql = "insert into modelr.experiment (idproject,name,description,num_partition,projection,datetime_inicio,datetime_fim,idstatusexperiment,extent_model,extent_projection,idpartitiontype,num_points,tss,threshold_bin,iduser,type,automatic_filter,buffer,group_name)
		 select idproject,name || ' ' || '" . $sp . "',description,num_partition,projection,datetime_inicio,datetime_fim,1,extent_model,extent_projection,idpartitiontype,num_points,tss,threshold_bin,iduser,type,automatic_filter,buffer,group_name
		 from modelr.experiment
		 where idexperiment=" . $id;
		
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idexperiment) from modelr.experiment";
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function alterar($id)
	{
		//name  = '".$this->name."', 
	   //description = '".$this->description."' ,
	   
		//idpartitiontype = '".$this->idpartitiontype."',
//	   num_points = '".$this->num_points."',
	   if (empty($this->num_partition))
	   {
			$this->num_partition = 'null';
	   }
	   if (empty($this->buffer))
	   {
			$this->buffer = 'null';
	   }
	   else
	   {
		   $this->buffer = str_replace(',','.',$this->buffer);
	   }
	   
	   if (empty($this->idpartitiontype))
	   {
			$this->idpartitiontype = 'null';
	   }

	   if (empty($this->num_points))
	   {
			$this->num_points = 'null';
	   }
	   
	   if (empty($this->tss))
	   {
			$this->tss = 'null';
	   }
	   else
	   {
		   $this->tss = str_replace(',','.',$this->tss);
	   }

	   if (empty($this->threshold_bin))
	   {
			$this->threshold_bin = 'null';
	   }
	   else
	   {
		   $this->threshold_bin = str_replace(',','.',$this->threshold_bin);
	   }
	   
	   if (empty($this->repetitions))
	   {
			$this->repetitions= '1';
	   }
	   if (empty($this->trainpercent))
	   {
			$this->trainpercent= '20';
	   }
			   
			   
       $sql = "update modelr.experiment set 
	   num_partition = ".$this->num_partition.",
	   buffer = ".$this->buffer.",
       idpartitiontype = ".$this->idpartitiontype.",
	   num_points = ".$this->num_points.",
	   tss = ".$this->tss.",
	   threshold_bin = ".$this->threshold_bin.",
	   repetitions  = ".$this->repetitions.",
	   trainpercent  = ".$this->trainpercent."
	   where idexperiment='".$id."' ";
	   
	   $resultado = pg_exec($this->conn,$sql);
	 
	   if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	function excluir($id)
	{
		$sql = "delete from modelr.experiment_result where idexperiment = '".$id."'; ";
		$sql .= "delete from modelr.experiment_use_algorithm where idexperiment = '".$id."'; ";
		$sql .= "delete from modelr.experiment_use_raster where idexperiment = '".$id."'; ";
		$sql .= "delete from modelr.occurrence where idexperiment = '".$id."'; ";
		$sql .= "delete from modelr.experiment where idexperiment = '".$id."'; ";
		
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function getDados($row)
	{
		$this->idexperiment = $row['idexperiment'];
		//$this->idproject = $row['idproject'];
		$this->name = $row['name'];
		$this->description = $row['description'];
		$this->group = $row['group_name'];
		$this->idpartitiontype = $row['idpartitiontype'];
		$this->num_partition = $row['num_partition'];
		$this->buffer = $row['buffer'];
		$this->resolution = $row['resolution'];
		$this->repetitions= $row['repetitions'];
		$this->trainpercent= $row['trainpercent'];
		$this->tss = $row['tss'];
		$this->threshold_bin = $row['threshold_bin'];
		$this->num_points = $row['num_points'];
		$this->iduser = $row['iduser'];
		$this->extent_model = $row['extent_model'];
		$this->extent_projection = $row['extent_projection'];
		$this->automaticfilter = $row['automatic_filter'];
	}

	function getPathDados($row)
	{	
		$this->pngCutPath = $row['png_cut_path'];
		$this->rasterCutPath = $row['raster_cut_path'];
		$this->pngBinPath = $row['png_bin_path'];
		$this->pngContPath = $row['png_cont_path'];
		$this->pngPath = $row['png_path'];
		$this->rasterPath = $row['raster_path'];
		$this->tiffPath = $row['tiff_path'];
		$this->rasterPngPath = $row['raster_png_path'];
		$this->isImageCut = $row['isImageCut'];
	}
	
	function alterarPathImagemMapa($idexperimento,$pngPath,$tiffPath, $rasterPngPath)
	{
		$sql = 'update modelr.experiment_result set png_path = ' . $pngPath . ', tiff_path = ' . $tiffPath . ', raster_png_path = ' . $rasterPngPath . ', "isImageCut" = false where idresulttype=303 and idexperiment = ' . $idexperimento;
		$res = pg_exec($this->conn,$sql);
	}
	
	function alterarPathPngRaster($idexperimento,$pngPath,$rasterPath)
	{
		$sql = 'update modelr.experiment_result set png_cut_path = ' . $pngPath . ', raster_cut_path = ' . $rasterPath . ', "isImageCut" = true where idresulttype=303 and idexperiment = ' . $idexperimento;
		$res = pg_exec($this->conn,$sql);
	}
	
	function limparCorteRaster($idexperimento)
	{	
		$sql = 'update modelr.experiment_result set png_cut_path = null, raster_cut_path = null, "imageCutValidated" = false,"isImageCut" = false where idresulttype=303 and idexperiment = ' . $idexperimento;
		$res = pg_exec($this->conn,$sql);
	}
	
	function validarCorteRaster($idexperimento)
	{	
		$sql = 'update modelr.experiment_result set "imageCutValidated" = true where idresulttype=303 and idexperiment = ' . $idexperimento;
		$res = pg_exec($this->conn,$sql);
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe,$idusuario='')
	{
	   	$sql = "select * from modelr.experiment, modelr.project  where experiment.idexperiment = experiment.idexperiment ";
		if (!empty($idusuario))
		{
			$sql.=' and experiment.iduser = '.$idusuario;
		}
			
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by name ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o experimento</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idexperimento'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idexperimento']."' ".$s." >".$row['name']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
		   $sql = 'select * from modelr.experiment where idexperiment = '.$id;
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
			$row = pg_fetch_array($result);
		   	$this->getDados($row);
			return 1;
		}
		else
		{
    		return 0;
		}
	}

	function getPath($id)
	{	
		if (empty($id)){
	    	$id = 0;
	   	}
		   $sql = 'select * from modelr.experiment_result where idexperiment = '.$id . ' and idresulttype=303';
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
			$row = pg_fetch_array($result);
		   	$this->getPathDados($row);
			return 1;
		}
		else
		{
    		return 0;
		}
	}

	function getStatus($id)
	{
		$sql = 'select * from modelr.experiment where idexperiment = '.$id;
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
			$row = pg_fetch_array($result);
			$this->statusExperiment = $row['idstatusexperiment'];
			return 1;
		}
		else
		{
    		return 0;
		}
		
	}

	function liberarExperimento($id)
	{
		$sql = "update modelr.experiment set 
	   idstatusexperiment=2 where idexperiment='".$id."' ";
	   $resultado = pg_exec($this->conn,$sql);
	 
	   if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
		
	}

	function conta()
	{
		$sql = "select count(*) from modelr.experiment" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}

}
?>