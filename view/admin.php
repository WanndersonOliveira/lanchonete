<?php
	if(!isset($_SERVER['PHP_AUTH_USER'])){
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401  Unauthorized');
		echo 'Informe o usuário e a senha de administrador.';
		exit;
	} else {
		if($_SERVER['PHP_AUTH_USER']=="admin" && $_SERVER['PHP_AUTH_PW']=="admin"){
			header('Location: paineladmin.php');
		} else {
			echo 'Usuário ou senha não conferem.';
		}
	}
?>