<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>RITS Lanchonete Admin</title>
</head>
<body bgcolor="grey">
	<script type="text/javascript" src="js/cadProd.js"></script>

	<center>
		<a href="paineladmin.php">Voltar</a>
		<br><br>
		<h3>RITS Lanchonete Admin</h3>
		<br><br><br>
		<b>Clientes</b>
		<br><br>
		<input type="text" id="produto" placeholder="Produto"><br><br>
		<label>Preço: R$ </label>
		<input type="number" min="0" max="100" id="reais" placeholder="Reais">
		<input type="number" min="0" max="99" id="centavos" placeholder="Centavos">
		<br><br><br><br>
		<button onclick="validation()">Cadastrar</button>

		<br><br><br>
		<p id="msg"></p>
	</center>
</body>
</html>