var cliente = "";

		function procReq(json,callback){
			//json=JSON.stringify(json);
			$pedidos = JSON.parse(json);

			//console.log($pedidos);
			callback($pedidos);
		}

		function editarProdutos(id){
			if(id==0){
				document.getElementById("status_msg").style.display="block";
				document.getElementById("status").style.display="block";

				document.getElementById("edit1").style.display="none";
				document.getElementById("edit2").style.display="block";
			} else if(id==1){
				document.getElementById("edit2").style.display="none";
				document.getElementById("edit1").style.display="block";
				document.getElementById("status_msg").style.display="none";
				document.getElementById("status").style.display="none";

				var status = document.getElementById("status").value;
				var pedido = document.getElementById("pedidos").value;

				pedido = pedido.split(" - ");


				pedido[2] = status;

				console.log(pedido);

				var dados = "status="+pedido[2]+"&cliente="+cliente+"&id="+pedido[0];

				var url = "http://localhost:8080/pedidos/edit";
				console.log(dados);

				var xhttp = new XMLHttpRequest();

  				xhttp.open("POST", url, false);
  				xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  				xhttp.send(dados);

  				procReq(xhttp.responseText,function(ret){
  					document.getElementById("msg").innerHTML = ret["message"];
  				});
			}

		}

		function carregarProdutos(){
			var total = 0;

			var xhttp = new XMLHttpRequest();
			var pedido = document.getElementById("pedidos").value;


			document.getElementById("total").style.display="block";

			console.log(pedido);
			var ped = "";

			for(var i = 0; i < 3; i++){
				ped += pedido.charAt(i);
			}

			ped = parseInt(ped);

			var url = "http://localhost:8080/produtos/ped/"+ped;

  			xhttp.open("GET", url, false);
  			xhttp.send();


  			procReq(xhttp.responseText,function(ret){
  				document.getElementById("produtos").innerHTML = "";

  				var txt = "";

  				console.log(ret);

  				for(var i = 0; i < ret.length; i++){
  					txt+=ret[i].nome+" - "+ret[i].preco+'<br>';

  					total+=parseFloat(ret[i].preco);

	  			}

     			document.getElementById("produtos").innerHTML= txt;
  			});


  			document.getElementById("total").innerHTML = total;

		}


		
		function carregarDados(){


			document.getElementById("status_msg").style.display="none";
			document.getElementById("status").style.display="none";
			document.getElementById("edit2").style.display="none";
			document.getElementById("total").style.display="none";


      		document.getElementById("telefone").innerHTML = sessionStorage.getItem("telCli");
      		document.getElementById("email").innerHTML = sessionStorage.getItem("emailCli");
      		document.getElementById("nome").innerHTML = sessionStorage.getItem("nomeCli");
      		document.getElementById("endereco").innerHTML = sessionStorage.getItem("endCli");


      		var xhttp = new XMLHttpRequest();
			var url = "http://localhost:8080/pedidos";
			var dados = "id="+sessionStorage.getItem("idCli");

			cliente = sessionStorage.getItem("idCli");

			sessionStorage.removeItem("idCli");

  			xhttp.open("POST", url, false);
  			xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  			xhttp.send(dados);

  			procReq(xhttp.responseText,function(ret){
  				document.getElementById("pedidos").innerHTML = "";

  				var txt = "";

  				console.log(ret);

  				for(var i = 0; i < ret.length; i++){
  					txt+="<option>"+ret[i].ID+" - "+ret[i].DATA_CRIACAO+" - "+ret[i].STATUS+'</option>';
	  			}

     			document.getElementById("pedidos").innerHTML= txt;							
     		});
		}
