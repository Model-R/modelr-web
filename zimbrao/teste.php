<?php
header('Content-type: text/html; charset=utf-8');

// A chave de criptografia - manter segura!
$key = base64_decode( 'Wk0xOWhnRyMkdz04WC0rJg==' );

// A mesagem e o vetor inicial, separados por ':', vem no parametro 'result'. O método usado será o POST.
$part = explode( ':', $_POST['result'] );

// A Mensagem é usada da forma que vem. Já o vetor inicial 'iv' precisa ser decodificado da base64.
$message = $part[0];
$iv = base64_decode( $part[1] );

echo 'key:'.$key.'<br>';
echo 'mensagem:'.$message.'<br>';
echo 'iv:'.$iv.'<br>';

// O JSON decodificado terá os campos que vocês precisarem. No momento, estou enviando o login e um 
// array com os gêneros que o usuário em acesso diretamente.
$json_string = openssl_decrypt( $message, 'aes-128-cbc', $key, OPENSSL_ZERO_PADDING, $iv );
echo 'json_string: '.$json_string ;


echo '<hr>';
$json = json_decode( $json_string, true ); 
echo $json;

echo 'Login: ' . $json['login'] . '<br>';
foreach( $json['scientific_name'] as $genus )
  echo 'Gênero: ' . $genus . '<br>';

echo '<hr>';
 
?>

