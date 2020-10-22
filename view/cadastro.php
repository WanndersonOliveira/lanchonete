<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lanchonete RITS</title>
</head>
<body bgcolor="grey">
	<script src="js/cadastro.js"></script>

	<center><h3>Lanchonete RITS</h3>
	<br><br>
	<br>
	<h5>Cadastro</h5>
	<br><br>
	<input type="text" id="nome" placeholder="Nome"><br><br>
	<input type="email" placeholder="Email" id="email"><br><br>
	<input type="text" placeholder="Telefone" id="tel"><br><br>
	<input type="text" id="endereco" placeholder="Endereço"><br><br>
	<input type="password" placeholder="Senha" id="senha"><br><br><br>

	<button onclick="validation()">Cadastrar</button><br><br><br><br>
	<a href="index.php">Voltar</a>

   	<br><br><br>
	<b id="msg"></b>
	<br>
	</center>
</body>
</html>