<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>RITS Lanchonete Admin</title>
</head>
<body onload="validation()" bgcolor="grey">
	<script type="text/javascript" src="js/paineladmin.js"></script>

	<center>
		<h3>RITS Lanchonete Admin</h3>
		<br><br><br>
		<b>Clientes</b>
		<br><br>
		<select id="clientes"></select>
    <button onclick="verCliente()">Acessar</button>
		<br><br><br>
		<b>Produtos</b>
		<br><br>
    <b>Cod - Produto - Preço</b>
    <br>
		<p id="produtos"></p>
    <br>
    <button onclick="excluirProdutos()">Excluir Produtos</button>
		<br><br>
    <input type="text" placeholder="Código do Produto" id="codigo">
    <input type="number" placeholder="Reais" min="0" max="100" id="reais">
    <input type="number" placeholder="Centavos" min="0" max="99" id="centavos">
    <br>
    <button onclick="editarProduto(1)" id="edit">Editar Produto</button>
    <br>
		<a href="cadProd.php">Cadastrar Produtos</a>
    <br>
    <b id="msg"></b>
	</center>
</body>
</html>