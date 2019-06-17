<?php
class Projeto	
{
	var $conn;
	var $idproject;
	var $project;
	var $description;
	var $idusuario;

	function incluir()
	{
 		$sql = "insert into modelr.project (project,description,idusuario
		) values (
		'".$this->project."',
		'".$this->description."',
		'".$this->idusuario."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idproject) from modelr.project ";
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
		
       $sql = "update modelr.project set 
	   project  = '".$this->project."' ,
	   idusuario  = '".$this->idusuario."' ,
	   description  = '".$this->description."' 
	   where idproject='".$id."' ";
	   
   
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
		$sql = "delete from modelr.experiment where idproject = '".$id."'; ";
		$sql .= "delete from modelr.project where idproject = '".$id."' ";
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
	   	$this->idproject = $row['idproject'];
	   	$this->project = $row['project'];
	   	$this->description = $row['description'];
	   	$this->idusuario = $row['idusuario'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe,$idusuario='')
	{
	   	$sql = "select * from modelr.project where idproject = idproject ";
		
		if (!empty($idusuario))
		{
			$sql.=' and idusuario = '.$idusuario;
		}
		
		
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by name ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o projeto</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idproject'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idproject']."' ".$s." >".$row['project']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.project where idproject = '.$id;
		
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
		$sql = "select count(*) from  modelr.project" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>