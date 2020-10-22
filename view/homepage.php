<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lanchonete RITS</title>
</head>
<body onload="loadData()" bgcolor="grey">
	<script type="text/javascript" src="js/homepage.js"></script>

	<center>
    <h3>Lanchonete RITS</h3>
	  <br>
	  <a href="#" onclick="sair()">Sair</a>
	  <br><br>
	  <br>
	  <b>Pedidos</b>
	  <br>
	  <select id="pedidos"></select>
    <button id="botao" onclick="verPedido()">Acessar</button>
    <br>

    <p id="msg"></p>
	  <br>
	  <br><br>
	  <a href="cadPed.php">Cadastrar Pedidos</a>
  </center>
</body>
</html>