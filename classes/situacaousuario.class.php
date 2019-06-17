<?php
class SituacaoUsuario	
{
	var $conn;
	var $idsituacaousuario;
	var $situacaousuario;

	function incluir()
	{
 		$sql = "insert into modelr.situacaousuario (situacaousuario
		) values (
		'".$this->situacaousuario."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idsituacaousuario) from modelr.situacaousuario ";
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
		
       $sql = "update modelr.situacaousuario set 
	   situacaousuario  = '".$this->situacaousuario."' 
	   where idsituacaousuario='".$id."' ";
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
		$sql = "delete from modelr.situacaousuario where idsituacaousuario = '".$id."' ";
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
	   	$this->idsituacaousuario = $row['idsituacaousuario'];
	   	$this->situacaousuario = $row['situacaousuario'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.statususer  ";
		
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
		$sql.=' order by statususer ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione a situação do usuário</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idstatususer'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idstatususer']."' ".$s." >".$row['statususer']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.situacaousuario where idsituacaousuario = '.$id;
		
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
		$sql = "select count(*) from modelr.situacaousuario" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>