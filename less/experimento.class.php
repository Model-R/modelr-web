<?php
class Experimento	
{
	var $conn;
	var $idexperiment;
	var $idproject;
	var $name;
	var $description;
	
	var $idpartitiontype ;//integer,
	var $numparticoes ;//integer,
	var $numpontos ;//integer,
	var $buffer ;//numeric(10,2),
	var $tsscorte ;//	
	
	
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

	function excluirponto($idexperimento,$idponto)
	{
		$sql = "delete from modelr.occurrence where idoccurrence = $idponto";
		$res = pg_exec($this->conn,$sql);
	}

	function adicionarOcorrencia($idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo)
	{
 		$sql = "insert into modelr.occurrence (idexperiment,
		iddatasource,
		lat,
		long,
		taxon,
		collector,
		collectnumber,
		server,
		path,
		file
		) values (
		'".$idexperimento."',
		'".$idfontedados."',
		".$lat.",
		".$long.",
		'".$taxon."',
		'".$coletor."',
		'".$numcoleta."',
		'".$imagemservidor."',
		'".$imagemcaminho."',
		'".$imagemarquivo."'
		)";
		
		$resultado = pg_exec($this->conn,$sql);
		
//		echo $sql;
//		exit;
		
		if ($resultado){

	   	}
	}
	
	function incluir()
	{
 		$sql = "insert into modelr.experiment (idprojeto,experimento
		) values (
		'".$this->idprojeto."',
		'".$this->experimento."',
		".$this->idtipoparticionamento.",
		".$this->numparticoes.",
		".$this->numpontos.",
		".$this->buffer.",
		".$this->tsscorte."
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idexperimento) from experimento";
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
		
       $sql = "update experimento set 
	   experimento  = '".$this->experimento."', 
	   idtipoparticionamento  = ".$this->idtipoparticionamento." ,
	   numparticoes  = ".$this->numparticoes.", 
	   numpontos  = ".$this->numpontos." ,
	   buffer  = ".$this->buffer." ,
	   tsscorte  = ".$this->tsscorte." 
	   where idexperimento='".$id."' ";
	   
	   $resultado = @pg_exec($this->conn,$sql);
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
		$sql = "delete from experimento where idexperimento = '".$id."' ";
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
	   	$this->idproject = $row['idproject'];
	   	$this->name = $row['name'];
	   	$this->description = $row['description'];
	   	$this->idtipoparticionamento = $row['idtipoparticionamento'];
	   	$this->numparticoes = $row['numparticoes'];
	   	$this->numpontos = $row['numpontos'];
	   	$this->buffer = $row['buffer'];
	   	$this->tsscorte = $row['tsscorte'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.experiment  ";
		if (!empty($idtipocapital))
		{
			$sql.=' where idexperiment = '.$idtipocapital;
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
	      $html.="<option value='".$row['idexperimento']."' ".$s." >".$row['experimento']."</option> ";
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


	function conta()
	{
		$sql = "select count(*) from modelr.experiment" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>