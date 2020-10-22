function procReq(json,callback){
			//json=JSON.stringify(json);
			$pedidos = JSON.parse(json);

			//console.log($pedidos);
			callback($pedidos);
		}
		

		function validation(){
			var nome = document.getElementById("nome").value;
			var email = document.getElementById("email").value;
			var senha = document.getElementById("senha").value;
			var endereco = document.getElementById("endereco").value;
			var tel = document.getElementById("tel").value;

			senha=parseInt(senha);
			var dados="id="+senha+"&email="+email+"&endereco="+endereco+"&telefone="+tel+"&nome="+nome;
			var xhttp = new XMLHttpRequest();

  			xhttp.open("POST", "http://localhost:8080/clientes/add", false);
  			xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  			xhttp.send(dados);

  			procReq(xhttp.responseText,function(ret){
     			document.getElementById("msg").innerHTML= ret["message"];
     			document.getElementById("msg").style.color="red";
     		});
		}
