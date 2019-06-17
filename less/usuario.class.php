<?php
class Usuario
{
	var $conn;
	var $idusuario;
	var $login;
	var $senha;
	var $nome;
	var $email;
	var $idsituacaousuario;	
	var $idtipousuario;

	
	function incluir()
	{
		if (empty($this->idsituacaousuario))
		{
			$this->idsituacaousuario = '1';
		}
		if (empty($this->idtipousuario))
		{
			$this->idtipousuario = '1';
		}
		if (empty($this->senha))
		{
			$this->senha = 'trocar';
		}
		
 		$sql = "insert into modelr.usuario (login,senha,nome,email,idsituacaousuario,idtipousuario) values 
									('".$this->login."','".$this->senha."','".$this->nome."','".$this->email."',".$this->idsituacaousuario.",".$this->idtipousuario.")";

		echo $sql;
		exit;
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
			$sql = "select max(idusuario) from usuario";
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
		if (empty($this->idsituacaousuario))
		{
			$this->idsituacaousuario = 'null';
		}
		if (empty($this->idtipousuario))
		{
			$this->idtipousuario = 'null';
		}
       		$sql = "update modelr.usuario set senha = '".$this->senha."', nome = '".$this->nome."', email = '".$this->email."'
			, login = '".$this->login."'
			, idtipousuario = '".$this->idtipousuario."'
			, idsituacaousuario = ".$this->idsituacaousuario." 
			 where idusuario='".$id."' ";
	   $resultado = pg_exec($this->conn,$sql);

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
		$sql = "delete from modelr.usuario where idusuario = '".$id."' ";
	   	$resultado = pg_exec($this->conn,$sql);
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
		   	$this->idusuario = $row['idusuario'];
		   	$this->usuario = $row['usuario'];
		   	$this->login = $row['login'];
		   	$this->nome = $row["nome"];
		   	$this->email = $row['email'];
		   	$this->datacadastro = $row['datacadastro'];
		   	$this->idsituacaousuario= $row['idsituacaousuario'];
		   	$this->idtipousuario= $row['idtipousuario'];
	}


	function autentica($login,$senha)
	{
	   	$sql = "select * from modelr.usuario where login = '".$login."' and senha='".$senha."'  ";
		//1 = ativo;
		//echo $sql;
		//exit;
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
	    	return true;
		}
		else
		{
	   		return 0;
		}
	}
	

	function listaCombo($nomecombo,$id,$refresh,$idcooperativa = '')
	{
		global $combo_usuario;
		
	   	$sql = "select * from modelr.usuario where idusuario = idusuario ";
		$sql.=" order by nome ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." style='width : 300px;'>";
		$html.="<option value = ''>Selecione o usu&aacute;rio</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idusuario'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idusuario']."' ".$s." >".$row['nome']." (".$row['login'].") </option> ";
	    }
		$html .= '</select>';
		return $html;	
	}


	function getUsuarioByLogin($login){
	   	$sql = "select * from modelr.usuario where login = '".$login."'";
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



	function getById($id)

	{

		if (empty($id)){

	    	$id = 0;

	   	}

	   	$sql = 'select * from modelr.usuario where idusuario = '.$id;
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



	function gerarSenha($numchar)

	{

   		$letras = "A,B,C,D,E,F,G,H,I,J,K,1,2,3,4,5,6,7,8,9,0";  

   		$array = explode(",", $letras);  

   		shuffle($array);  

   		$senha = implode($array, "");  

   		return substr($senha, 0, $numchar);  

	} 	



function enviarSenha($email){
	//$senha = $this->gerarSenha(6);
	
	$senha = 'trocar';
	//$sql = "update usuario set senha='".substr(md5($senha),0,5)."' where email = '".$email."'";
	$sql = "update modelr.usuario set senha='".$senha."' where email = '".$email."'";
	$resultado = pg_exec($this->conn,$sql);
//	echo $sql;
//	exit;
//	if (resultado)
	$destinatario = $email;
	$assunto= 'Nova Balde Cheio';
	//$senha = substr(md5($senha),0,5);
	//$senha = substr(md5($r),0,5);
	$corpo = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>:.. MODEL-R ..:</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	<!--
	.style2 {font-size: 24px}
	-->
	</style>
	</head>
	<body bgcolor="#ffffff">
	<center>
	<table border=0 width="100%">
	<tr>
	<td width="10%"><div align="center"><img src="" /></div></td>
	<td width="90%" align="left" class="style2" style="color:#93989E">Model-R</td>
	</tr>
	<tr>
		<td colspan="2" align="justify">
		<br/>
		Ol&aacute;, '.$email.'<br/><br/> 
		Esta &eacute; sua nova senha: '.$senha.' <br/><br/>
		Qualquer d&uacute;vida ou coment&aacute;rio, por favor entre em contato conosco atrav&eacute;s do nosso telefone (21)98032-7479.<br/><br/>
		Equipe Model-R<br/>
	</td>
	</tr>
	</table>
	</center>
	</font>
	</body>
	</html>
	'; 
	
	//para o envio em formato HTML
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html;charset=iso-8859-1\r\n";
	
	//endereo do remitente
	$headers .= "From: Model-R <rafael@jbrj.gov.br>\r\n";
	
	//endereo de resposta, se queremos que seja diferente a do remitente
	//$headers .= "Reply-To: thiagoluna@ig.com.br\r\n";
	
	//endereos que recebero uma copia 
	//$headers .= "Cc: thiagoluna@ig.com.br\r\n"; 
	//endereos que recebero uma copia oculta
	//$headers .= "Bcc: thiagoluna2@gmail.com\r\n";
	if ((mail($destinatario,$assunto,$corpo,$headers) ) && ($resultado)) {
	   //echo "<br/>Email enviado com um sucesso!!!<br/>Em breve o responderemos."; 
	   return true;
	} else {
	   //echo "<br/>Erro no envio do email!<br/>Por Favor, <a href='contato.php'>tente</a> novamente!";
	   return false;
	} 

}


	function trocarSenha($senha,$novasenha,$confirmacaosenha)
	{
	    $r = false;

		if ($novasenha==$confirmacaosenha)

		{

			$r = true;

		}

		$sql = " select * from modelr.usuario where idusuario = '".$this->idusuario."' and senha = '".$senha."'";

		$result = pg_exec($this->conn,$sql);

		if ((pg_num_rows($result)>0) && ($r = true)  ){

			$sql = " update modelr.usuario set senha = '".$novasenha."' where idusuario = '".$this->idusuario."' and senha = '".$senha."'";

			if ($resultado = pg_exec($this->conn,$sql))
			{

			   $r = true;

			}

		}

		return $r;

	}

	function existeNome($nome)
	{
		$sql_nome = "select nome from modelr.usuario where upper(nome) = upper('".$nome."')" ;
		$result_nome = pg_query($this->conn,$sql_nome);
		if (pg_num_rows($result_nome)>0){
			return true;
   		}
		else
		{
			return false;
		}
	}

	function existeLogin($login)
	{
		$sql_login = "select login from modelr.usuario where upper(login) = upper('".$login."')" ;
		$result_login = pg_query($this->conn,$sql_login);
		if (pg_num_rows($result_login)>0)
		{			
			return true;
   		} else 
		{
			return false;
		}
	}

	function existeEmail($email)
	{
		$sql_usuario = "select email from modelr.usuario where upper(email) = upper('".$email."')" ;
		$result_usuario = pg_query($this->conn,$sql_usuario);
		if (pg_num_rows($result_usuario)>0){
			return true;
   		}
		else
		{
			return false;
		}
	}
}

?>