<?php
class Algoritmo	
{
	var $conn;
	var $idalgorithm;
	var $algorithm;

	function incluir()
	{
 		$sql = "insert into modelr.algorithm (algorithm
		) values (
		'".$this->algorithm."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idalgorithm) from modelr.algorithm ";
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
		
       $sql = "update modelr.algorithm set 
	   algorithm  = '".$this->algorithm."' 
	   where idalgorithm='".$id."' ";
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
		$sql = "delete from modelr.algorithm where idalgorithm = '".$id."' ";
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
	   	$this->idalgorithm = $row['idalgorithm'];
	   	$this->algorithm = $row['algorithm'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.algorithm  ";
		
		$res = pg_exec($this->conn,$sql);
		
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by algorithm ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a algoritmo</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idalgorithm'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idalgorithm']."' ".$s." >".$row['algorithm']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.algorithm where idalgorithm = '.$id;
		
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
		$sql = "select count(*) from modelr.algorithm" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>