<?php
class Usuario
{
	var $conn;
/*	var $idusuario;
	var $login;
	var $senha;
	var $nome;
	var $email;
	var $idsituacaousuario;	
	var $idtipousuario;
	var $idprojeto;
*/
	var $iduser;// serial NOT NULL,
	var $name;// character varying(100),
	var $login;// character varying(100) NOT NULL,
	var $password;// character varying(50),
	var $email;// character varying(150) NOT NULL,
	var $idstatususer;// integer NOT NULL,
	var $idusertype;// integer,	
	var $idinstitution;// integer,	
	
	
	
	function incluir()
	{
		if (empty($this->idstatususer))
		{
			$this->idstatususer = '1';
		}
		if (empty($this->idusertype))
		{
			$this->idusertype = '1';
		}
		if (empty($this->password))
		{
			$this->password = 'trocar';
		}
		
 		$sql = "insert into modelr.user (login,password,name,email,idstatususer,idusertype,idinstitution) values 
									('".$this->login."','".$this->password."','".$this->name."','".$this->email."',".$this->idstatususer.",".$this->idusertype.",".$this->idinstitution.")";

		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
			$sql = "select max(iduser) from modelr.user";
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
		if (empty($this->idstatususer))
		{
			$this->idstatususer = 'null';
		}
		if (empty($this->idusertype))
		{
			$this->idusertype = 'null';
		}

		if (empty($this->password))
		{
			$sql = "update modelr.user set name = '".$this->name."', 
			email = '".$this->email."'
			, login = '".$this->login."'
			, idusertype = '".$this->idusertype."'
			, idstatususer = ".$this->idstatususer." 
			, idinstitution = ".$this->idinstitution." 
			 where iduser='".$id."' ";	
		} else {
			$sql = "update modelr.user set password = '".$this->password."', name = '".$this->name."', 
			email = '".$this->email."'
			, login = '".$this->login."'
			, idusertype = '".$this->idusertype."'
			, idstatususer = ".$this->idstatususer." 
			, idinstitution = ".$this->idinstitution." 
			 where iduser='".$id."' ";
		}
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
		$sql = "delete from modelr.user where iduser = '".$id."' ";
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
		   	$this->iduser = $row['iduser'];
		   	//$this->usuario = $row['usuario'];
		   	$this->login = $row['login'];
		   	$this->name = $row["name"];
		   	$this->email = $row['email'];
		   	//$this->datacadastro = $row['datacadastro'];
		   	$this->idstatususer= $row['idstatususer'];
		   	$this->idusertype= $row['idusertype'];
		   	$this->idinstitution= $row['idinstitution'];
			
			
			
			/*$sql = 'select * from modelr.project where idusuario = '.$row['idusuario'];
			$res = pg_exec($this->conn,$sql);
			$qtd = pg_num_rows($res);
			
			if ($qtd==1)
			{
				$row = pg_fetch_array($res);
				$this->idprojeto = $row['idproject'];
			}
			*/
			
	}


	function autentica($login,$senha)
	{
	   	$sql = "select * from modelr.user where login = '".$login."' and password='".$senha."'  ";
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
	

	function listaCombo($nomecombo,$id,$refresh,$classe='')
	{
		global $combo_usuario;
		
	   	$sql = "select * from modelr.user where iduser = iduser ";
		$sql.=" order by name ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classe.">";
		$html.="<option value = ''>Selecione o usu&aacute;rio</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['iduser'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['iduser']."' ".$s." >".$row['name']." (".$row['login'].") </option> ";
	    }
		$html .= '</select>';
		return $html;	
	}


	function getUsuarioByLogin($login){
	   	$sql = "select * from modelr.user where login = '".$login."'";
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

	   	$sql = 'select * from modelr.user where iduser = '.$id;
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
	
	$sql = "select * from modelr.user where email = '".$email."'";
	$res = pg_exec($this->conn,$sql);
	if (pg_num_rows($res)>0)
	{
	$sql = "update modelr.user set password='".$senha."' where email = '".$email."'";
	$resultado = pg_exec($this->conn,$sql);
//	echo $sql;
//	exit;
//	if (resultado)
	$destinatario = $email;
	$assunto= 'Nova senha Model-R';
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
	else
	{
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

		$sql = " select * from modelr.user where iduser = '".$this->iduser."'";

		$result = pg_exec($this->conn,$sql);

		if ((pg_num_rows($result)>0) && ($r = true)  ){
			$sql = " update modelr.user set password = '".$novasenha."' where iduser = '".$this->iduser."'";
			if ($resultado = pg_exec($this->conn,$sql))
			{
			   $r = true;
			}
		}
		return $r;

	}

	function existeNome($nome)
	{
		$sql_nome = "select name from modelr.user where upper(name) = upper('".$nome."')" ;
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
		$sql_login = "select login from modelr.user where upper(login) = upper('".$login."')" ;
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
		$sql_usuario = "select email from modelr.user where upper(email) = upper('".$email."')" ;
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