<?php
class TipoParticionamento	
{
	var $conn;
	var $idpartitiontype;
	var $partitiontype;

	function incluir()
	{
 		$sql = "insert into modelr.partitiontype (partitiontype
		) values (
		'".$partitiontype."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idpartitiontype) from modelr.partitiontype ";
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
		
       $sql = "update modelr.partitiontype set 
	   partitiontype  = '".$this->partitiontype."' 
	   where idpartitiontype='".$id."' ";
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
		$sql = "delete from modelr.partitiontype where idpartitiontype = '".$id."' ";
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
	   	$this->idpartitiontype = $row['idpartitiontype'];
	   	$this->partitiontype = $row['partitiontype'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.partitiontype  ";
	
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by partitiontype ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		//$html .= "<option value=''>Selecione o tipo de particionamento</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idpartitiontype'])
			{
			   $s = "selected";
			}

			//marcar kfold como padrão
			if($id == '' && $row['idpartitiontype'] == 1){
				$s = "selected";
			}
	      $html.="<option value='".$row['idpartitiontype']."' ".$s." >".$row['partitiontype']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.partitiontype where idpartitiontype = '.$id;
		
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
		$sql = "select count(*) from modelr.partitiontype" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>