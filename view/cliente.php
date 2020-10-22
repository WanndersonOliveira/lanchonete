<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>RITS Lanchonete Admin</title>
</head>
<body bgcolor="grey" onload="carregarDados()">
	<script type="text/javascript" src="js/cliente.js"></script>

	<a href="paineladmin.php">Voltar</a>
	<br>
	<center>
		<h3>RITS Lanchonete Admin</h3>
		<br><br><br>
		<h4>Cliente</h4>
		<br>
		<b>Nome:</b><p id="nome"></p><br>
		<b>Email:</b><p id="email"></p><br>
		<b>Endereço:</b><p id="endereco"></p><br>
		<b>Telefone:</b><p id="telefone"></p><br>
		<br>
		<b>Pedidos:</b>
		<br>
		<select id="pedidos"></select><button onclick="carregarProdutos()">Acessar</button>
		<button onclick="editarProdutos(0)" id="edit1">Editar</button>

		<br>
		<span id="status_msg">Status do pedido: </span>
		<select id="status">
			<option>Pendente</option>
			<option>Em preparo</option>
			<option>Em entrega</option>
			<option>Cancelado</option>	
		</select>
		<br>

		<button onclick="editarProdutos(1)" id="edit2">Editar</button>

		<br>
		<b id="msg"></b>
		<br>
		<p id="produtos"></p><br>
		<b>Total: R$</b><p id="total"></p>
	</center>
</body>
</html>