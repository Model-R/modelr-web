<?php

class Conexao{
//	function Conectar($host = 'localhost',$dbname = 'postgres',$user = 'postgres',$password = 'arcade1')
	//
//	function Conectar($host = 'postgresql01.progti.com',$dbname = 'progti',$user = 'progti',$password = '102030v')

//	function Conectar($host = 'localhost',$dbname = 'baldecheio',$user = 'postgres',$password = 'arcade1')
//  tempustecnologia5 - Balde Cheio
//Pg5d3WEdm
//	function Conectar($host = 'jb051.jbrj.gov.br',$dbname = 'Jardim',$user = 'modelr',$password = 'Cf3TY7kl67hfd')
	function Conectar($host = 'jb051.jbrj.gov.br',$dbname = 'Jardim',$user = 'postgres',$password = 'Pg5d3WEdm')
	{
		$conn = pg_connect("host=$host dbname = $dbname user = $user password = $password ");
		return $conn;
	}
}

?>