var produtos = [];
		var prod_ped = [];
		var count = 0;
		var txt="";

		function setProdutos(){
			var produto = document.getElementById("produtos").value;

			txt += "<li>"+produto+"</li>";
			var id = parseInt(produto.charAt(0)+produto.charAt(1)+produto.charAt(2));

			for(var i = 0; i < produtos.length; i++){
				if(parseInt(produtos[i].ID) == id){
					prod_ped.push(produtos[i]);
				}
			}

			document.getElementById("pedido").innerHTML = txt;
		}

		function procReq(json,callback){
			//json=JSON.stringify(json);
			$pedidos = JSON.parse(json);

			//console.log($pedidos);
			callback($pedidos);
		}
		

		function getData(){
			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function() {
    			if (this.readyState == 4 && this.status == 200) {

  					procReq(this.responseText,function(ret){
  						document.getElementById("produtos").innerHTML = "";

  						var txt = "";

  						produtos = ret;

  						for(var i = 0; i < ret.length; i++){
  							txt+='<option>'+ret[i].ID+" - "+ret[i].NOME+" - "+ret[i].PRECO+'</option>';

	  					}

     					document.getElementById("produtos").innerHTML= txt;						

     					if(ret["message"]!=undefined){
  							document.getElementById("produtos").innerHTML = ret["message"];
     					}
  						
     				});
    			}
    		}

  			xhttp.open("GET", "http://localhost:8080/produtos", false);
  			xhttp.send();

		}

		function confirmarPedido(){


			var xhttp = new XMLHttpRequest();
			var dados = "cliente="+sessionStorage.getItem("id");
			var pedido = null;

			xhttp.open("POST", "http://localhost:8080/pedidos/add", false);

  			xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  			xhttp.send(dados);

  			procReq(xhttp.responseText,function(ret){
					

     			if(ret["message"]!=undefined){
  					document.getElementById("msg").innerHTML = ret["message"];
     			}

     			if(ret["pedido"]!=undefined){
     				pedido=ret["pedido"];
     			}

     		});


     		for(var i = 0; i < prod_ped.length;i++){
     			dados="nome="+prod_ped[i].NOME+"&preco="+prod_ped[i].PRECO+"&id="+prod_ped[i].ID+"&pedido="+pedido;

     			

				xhttp.open("POST", "http://localhost:8080/produtos/edit", false);
  				xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  				xhttp.send(dados);

  				procReq(xhttp.responseText,function(ret){
					
  					console.log(ret["message"]);
     			});     			
     		}

  			
		}