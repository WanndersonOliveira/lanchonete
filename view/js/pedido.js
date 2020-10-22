function procReq(json,callback){
			//json=JSON.stringify(json);
			$produtos = JSON.parse(json);

			//console.log($pedidos);
			callback($produtos);
		}


		function excluirPedido(){


			var xhttp = new XMLHttpRequest();
			var url = "http://localhost:8080/pedidos/"+sessionStorage.getItem("idPed");


  			xhttp.open("DELETE", url, false);
  			xhttp.send();

  			procReq(xhttp.responseText,function(ret){
  				document.getElementById("msg").innerHTML = ret["message"];
  			});
		}
		
		function getProdutos(){

			var total = 0;
			document.getElementById("data").innerHTML = sessionStorage.getItem("dataPed");
			document.getElementById("status").innerHTML = sessionStorage.getItem("statusPed");


			var xhttp = new XMLHttpRequest();
			var url = "http://localhost:8080/produtos/ped/"+sessionStorage.getItem("idPed");


  			xhttp.open("GET", url, false);
  			xhttp.send();

  			procReq(xhttp.responseText,function(ret){
  				document.getElementById("produtos").innerHTML = "";

  				var txt = "";

  				for(var i = 0; i < ret.length; i++){
  					txt+=ret[i].nome+" - "+ret[i].preco+'<br>';

  					total+=parseFloat(ret[i].preco);

	  			}

     			document.getElementById("produtos").innerHTML= txt;							
     		});

  			document.getElementById("total").innerHTML = total;

		}