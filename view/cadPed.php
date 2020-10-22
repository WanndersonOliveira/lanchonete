<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lanchonete RITS</title>
</head>
<body bgcolor="grey" onload="getData()">
	<script src="js/cadPed.js"></script>

	<a href="homepage.php">Voltar</a>
	<center><h3>Lanchonete RITS</h3>
	<br><br>
	<br>
	<h5>Produto</h5>

	<ol id="pedido"></ol>

	<select id="produtos">
	</select><button onclick="setProdutos()">Adicionar</button>

	<br><br><br>

	<button onclick="confirmarPedido()">Pedir</button><br><br><br><br>

   	<br><br><br>
	<b id="msg"></b>
	<br>
	</center>
</body>
</html>