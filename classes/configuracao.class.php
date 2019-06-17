<?php

class Configuracao {

	var $conn;
	var $anoreferencia;
	var $emailrecebimento;
	var $relmesreferenciainicial;
	var $relmesreferenciafinal;
	var $relanoreferenciainicial;
	var $relanoreferenciafinal;

	function alterar()
	{
       $sql = "update configuracao set anoreferencia = ".$this->anoreferencia.",
	   relanoreferenciainicial = ".$this->relanoreferenciainicial.",
	   relanoreferenciafinal = ".$this->relanoreferenciafinal.",
	   relmesreferenciainicial = ".$this->relmesreferenciainicial.",
	   relmesreferenciafinal = ".$this->relmesreferenciafinal.",
	   emailrecebimento = '".$this->emailrecebimento."' ";
	   $resultado = pg_exec($this->conn,$sql);
       if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}
		
	function getConfiguracao()
	{
		$sql = 'select * from configuracao';
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
	
	function getDados($row)
	{

		   	$this->anoreferencia= $row['anoreferencia'];
		   	$this->emailrecebimento= $row['emailrecebimento'];
		   	$this->relanoreferenciainicial= $row['relanoreferenciainicial'];
		   	$this->relanoreferenciafinal= $row['relanoreferenciafinal'];
		   	$this->relmesreferenciainicial= $row['relmesreferenciainicial'];
		   	$this->relmesreferenciafinal= $row['relmesreferenciafinal'];
	}
}

?>