<?php
class Raster	
{
	var $conn;
	var $idraster;
	var $idsource;
	var $raster;

	function incluir()
	{
 		$sql = "insert into modelr.raster (idsorce,raster
		) values (
		'".$idsource."',
		'".$raster."'
		)";
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	    	$sql = "select max(idraster) from raster ";
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
		
       $sql = "update modelr.raster set 
	   idsource  = '".$this->idsource."' ,
	   raster  = '".$this->raster."' 
	   where idraster='".$id."' ";
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
		$sql = "delete from modelr.raster where idraster = '".$id."' ";
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
	   	$this->idraster = $row['idraster'];
	   	$this->idsource = $row['idsource'];
	   
	   	$this->raster = $row['raster'];
	}
	
	function listaCombo($nomecombo,$id,$refresh='N',$classe)
	{
	   	$sql = "select * from modelr.raster  ";
		if (!empty($idtipocapital))
		{
			$sql.=' where idraster = '.$idalgoritmo;
		}
		$res = pg_exec($this->conn,$sql);

		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$sql.=' order by raster ';
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  ".$classe.">";
		$html .= "<option value=''>Selecione o Raster</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idraster'])
			{
			   $s = "selected";
			}
	      $html.="<option value='".$row['idraster']."' ".$s." >".$row['raster']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from modelr.raster where idraster = '.$id;
		
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
		$sql = "select count(*) from modelr.raster" ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>