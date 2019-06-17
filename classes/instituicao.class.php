<?php
class Instituicao	
{
	var $conn;
	var $idinstituicao;
	var $instituicao;

	function incluir()
	{
 		$sql = "insert into modelr.institution (institution
		) values (
		'".$this->instituicao."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idinstitution) from modelr.institution ";
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
		
       $sql = "update modelr.institution set 
	   institution  = '".$this->instituicao."' 
	   where idinstitution='".$id."' ";
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
		$sql = "delete from modelr.institution where idinstitution = '".$id."' ";
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
	   	$this->idinstituicao = $row['idinstitution'];
	   	$this->institution = $row['institution'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.institution  ";
		
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
		$sql.=' order by institution ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a instituição</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idinstitution'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idinstitution']."' ".$s." >".$row['institution']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.institution where idinstitution = '.$id;
		
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
		$sql = "select count(*) from modelr.institution" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>