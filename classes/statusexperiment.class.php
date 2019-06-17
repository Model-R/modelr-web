<?php
class StatusExperiment	
{
	var $conn;
	var $idstatusExperiment;
	var $statusExperiment;

	function incluir()
	{
 		/*$sql = "insert into modelr.source (source
		) values (
		'".$this->source."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idsource) from modelr.source ";
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
		*/
	}
	
	function alterar($id)
	{
		/*
       $sql = "update modelr.source set 
	   source  = '".$this->source."' 
	   where idsource='".$id."' ";
	   $resultado = @pg_exec($this->conn,$sql);
       if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	   */
	}

	function excluir($id)
	{
		/*$sql = "delete from modelr.source where idsource = '".$id."' ";
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
		*/
	}
	
	
	function getDados($row)
	{
	   	$this->idstatusexperiment = $row['idstatusexperiment'];
	   	$this->statusexperiment = $row['statusexperiment'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.statusexperiment where idstatusexperiment = idstatusexperiment ";
		
		
		$sql.=' order by statusexperiment.statusexperiment ';
		$res = pg_exec($this->conn,$sql);
		
		$s = '';
		if (!empty($refresh))
		{
			if ($refresh == 'S')
			{
				$s = " onChange='submit();'";
			}
			else
			{
				$s = $refresh;
			}
		}
		
		//echo $sql;
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''></Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idstatusoccurence'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idstatusexperiment']."' ".$s." >".$row['statusexperiment']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.statusexperiment where idstatusexperiment = '.$id;
		
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
		$sql = "select count(*) from modelr.statusexperiment" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>