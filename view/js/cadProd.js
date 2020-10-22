function procReq(json,callback){
			//json=JSON.stringify(json);
			$pedidos = JSON.parse(json);

			//console.log($pedidos);
			callback($pedidos);
		}
		

		function validation(){
			var produto = document.getElementById('produto').value;
			var reais = document.getElementById('reais').value;
			var centavos = document.getElementById('centavos').value;

			if(parseInt(reais) < 0 || parseInt(centavos) < 0){
  				document.getElementById("msg").innerHTML = "Os valores de REAIS e CENTAVOS devem ser positivos.";
  				document.getElementById("msg").style.color="red";
			} else {
				document.getElementById("msg").innerHTML = "";

				var dados = "nome="+produto+"&preco="+reais+"."+centavos+"&pedido=";

				var xhttp = new XMLHttpRequest();

				xhttp.open("POST", "http://localhost:8080/produtos/add", false);
  				xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  				xhttp.send(dados);

  				procReq(xhttp.responseText, function(ret){
  					document.getElementById("msg").innerHTML = ret["message"];
  					document.getElementById("msg").style.color="black";
  				});
			}

		}
