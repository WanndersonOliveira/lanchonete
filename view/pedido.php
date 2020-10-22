<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body bgcolor="grey" onload="getProdutos()">
	<script type="text/javascript" src="js/pedido.js"></script>

	<a href="homepage.php">Voltar</a>
	<center>
		<h3>Lanchonete RITS</h3>
	  	<br>
	  	<br><br>
	  	<br>
		<h3>Pedido:</h3>
		<br>
		<b>Data: </b><p id="data"></p>
		<br>
		<b>Status: </b><p id="status"></p>

		<br><br>
		<b>Itens</b>
		<p id="produtos"></p>
		<br>
		<br>
		<b>Total a pagar: </b>R$<p id="total"></p>
		<br><br><br><br>
		<button onclick="excluirPedido()">Excluir</button>
		<br>
		<b id="msg"></b>
	</center>
</body>
</html>