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

	var $pngCutPath;
	
	var $iduser;
	var $type;
	var $automaticfilter;
	
	function incluirRaster($id,$idraster)
	{
		$sql = 'insert into modelr.experiment_use_raster (idexperiment,idraster)
		values ('.$id.','.$idraster.')';
//		echo $sql.'<br>';
		
		$res2 = pg_exec($this->conn,$sql);
	}
	
	function incluirAlgoritmo($id,$idalgoritmos)
	{
		$sql = 'insert into modelr.experiment_use_algorithm (idexperiment,idalgorithm)
		values ('.$id.','.$idalgoritmos.')';
		$res2 = pg_exec($this->conn,$sql);
	}

	function incluirExtensao($id, $extent)
	{
		$sql = "update modelr.experiment set 
		extent_model = '".$extent."'
		where idexperiment='".$id."' ";
		// echo $sql;
		// exit;
		$resultado = pg_exec($this->conn,$sql);
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
		else
		{
			if($idalgoritmos == 2 || $idalgoritmos == 5){
				return true;
			}
			else {
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
			if($idraster == 4 || $idraster == 5 || $idraster == 13 || $idraster == 14 || $idraster == 84 || $idraster == 85 || $idraster == 93 || $idraster == 94){
				return true;
			}
			else {
				return false;
			}
		}
		
	}	
	
	function marcarpontosduplicados($idexperimento)
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

	function adicionarOcorrencia($idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$p,$e,$m,$herbario,$tombo)
	{	
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
		minorarea
		) values (
		'".$idexperimento."',
		'".$idfontedados."',
		".$lat.",
		".$long.",
		'".$taxon."',
		'".$herbario."',
		".$tombo.",
		'".$coletor."',
		'".$numcoleta."',
		'".$imagemservidor."',
		'".$imagemcaminho."',
		'".$imagemarquivo."',
		8,
		'".$p."',
		'".$e."',
		'".$m."'
		)";
		// 8 status occurrence = OK
		$resultado = pg_exec($this->conn,$sql);
		
//		echo $sql;
//		exit;
		
		if ($resultado){

	   	}
	}
	
	function limparDados($idexperimento)
	{
		
 		$sql = "
		update modelr.experiment set idstatusexperiment = 1 where idexperiment = ".$idexperimento.";
		delete from modelr.occurrence where idexperiment = ".$idexperimento;
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
 		$sql = "insert into modelr.experiment (name,description,group_name,iduser,idstatusexperiment,type,automatic_filter
		) values (
		'".$this->name."',
		'".$this->description."',
		'".$this->group."',
		'".$this->iduser."',1,
		'".$this->type."',
		'".$this->automaticfilter."'
		)";
		
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

	function clonar($id, $sp)
	{
 		$sql = "insert into modelr.experiment (idproject,name,description,num_partition,projection,datetime_inicio,datetime_fim,idstatusexperiment,extent_model,extent_projection,idpartitiontype,num_points,tss,iduser,type,automatic_filter,buffer,group_name)
		 select idproject,name || ' ' || '" . $sp . "',description,num_partition,projection,datetime_inicio,datetime_fim,1,extent_model,extent_projection,idpartitiontype,num_points,tss,iduser,type,automatic_filter,buffer,group_name
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
			   
			   
       $sql = "update modelr.experiment set 
	   name='".$this->name."',
	   description='".$this->description."',
	   group_name='".$this->group."',
	   num_partition = ".$this->num_partition.",
	   buffer = ".$this->buffer.",
	   extent_model = '".$this->extent_model."',
       idpartitiontype = ".$this->idpartitiontype.",
	   num_points = ".$this->num_points.",
	   tss = ".$this->tss.",
	   extent_projection = '".$this->extent_projection."'
	   where idexperiment='".$id."' ";
	   $resultado = pg_exec($this->conn,$sql);
	//    echo $sql;
	//    exit;
	 
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
		$sql = "delete from modelr.experiment_use_algorithm where idexperiment = '".$id."'; ";
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
	   	$this->numpontos = $row['numpontos'];
	   	$this->buffer = $row['buffer'];
	   	$this->tss = $row['tss'];
		$this->num_points = $row['num_points'];
		$this->iduser = $row['iduser'];
		$this->extent_model = $row['extent_model'];
		$this->pngCutPath = $row['png_cut_path'];
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
		   echo $sql;
		   exit;
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