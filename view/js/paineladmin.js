var clientes = [];
    var produtos = [];


		function procReq(json,callback){
			//json=JSON.stringify(json);
			$pedidos = JSON.parse(json);

			//console.log($pedidos);
			callback($pedidos);
		}

    function editarProduto(id){
      if(id == 0){
        document.getElementById("codigo").style.display="block";
        document.getElementById("reais").style.display="block";
        document.getElementById("centavos").style.display="block";
        document.getElementById("edit").style.display="block";

      } else if(id == 1){
        var codigo = document.getElementById("codigo").value;
        var reais = document.getElementById("reais").value;
        var centavos = document.getElementById("centavos").value;

        var produto = "";

        console.log(produto);

        for(var i = 0; i < produtos.length; i++){
          if(codigo.toString() ==produtos[i].ID){
            produto = produtos[i].NOME;
            console.log(produtos[i]);
          }
        }


        if(parseInt(reais) < 0 || parseInt(centavos) < 0){
          document.getElementById("msg").innerHTML = "Os valores de REAIS e CENTAVOS devem ser positivos.";

          document.getElementById("msg").style.color="red";
        } else {
          document.getElementById("msg").innerHTML = "";

          var dados = "nome="+produto+"&preco="+reais+"."+centavos+"&id="+codigo+"&pedido=";

          console.log(dados);

          var xhttp = new XMLHttpRequest();

          xhttp.open("POST", "http://localhost:8080/produtos/edit", false);
          xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
          xhttp.send(dados);

          procReq(xhttp.responseText, function(ret){
            document.getElementById("msg").innerHTML = ret["message"];
            document.getElementById("msg").style.display = "block";
            document.getElementById("msg").style.color="black";
          });
        }


        document.getElementById("codigo").style.display="none";
        document.getElementById("reais").style.display="none";
        document.getElementById("centavos").style.display="none";
        document.getElementById("edit").style.display="none";

      }
    }

    function excluirProdutos(){
        

        for(var i = 0; i < produtos.length; i++){
          var txt = '#p'+produtos[i].ID+":checked";

          console.log(document.querySelector(txt)!==null);


          if(document.querySelector(txt)!==null){
            var xhttp = new XMLHttpRequest();


            var url = "http://localhost:8080/produtos/"+produtos[i].ID;

            xhttp.open("DELETE", url, false);

            xhttp.send();

            procReq(xhttp.responseText,function(ret){
              
              document.getElementById("msg").style.display="block";
              document.getElementById("msg").innerHTML=ret["message"];
              
            });

          }

        }
    }

    function verCliente(){
      var cliente = document.getElementById("clientes").value;

      var cli = null;


      for(var i = 0; i < clientes.length;i++){
        if(cliente.toString() == clientes[i].EMAIL){
          cli = clientes[i];
        }
      }

      console.log(cli);


      sessionStorage.setItem("telCli",cli.TELEFONE);
      sessionStorage.setItem("emailCli",cli.EMAIL);
      sessionStorage.setItem("nomeCli",cli.NOME);
      sessionStorage.setItem("endCli",cli.ENDERECO);
      sessionStorage.setItem("idCli",cli.ID);

      window.location.replace("cliente.php");

    }
		

		function validation(){

        document.getElementById("msg").style.display="none";
        document.getElementById("codigo").style.display="none";
        document.getElementById("reais").style.display="none";
        document.getElementById("centavos").style.display="none";
        document.getElementById("edit").style.display="none";

			  var xhttp = new XMLHttpRequest();


  			xhttp.open("GET", "http://localhost:8080/clientes", false);

  			xhttp.send();

  			procReq(xhttp.responseText,function(ret){

  				document.getElementById("clientes").innerHTML = "";

          clientes = ret;

  				var txt = "";

  				for(var i = 0; i < ret.length; i++){
  					txt+='<option>'+ret[i].EMAIL+'</option>';
  				}

     			document.getElementById("clientes").innerHTML= txt;						

     			if(ret["message"]!=undefined){
  					document.getElementById("clientes").innerHTML = ret["message"];
     			}

     		});


     		var xhttp = new XMLHttpRequest();


  			xhttp.open("GET", "http://localhost:8080/produtos", false);
  			xhttp.send();

  			procReq(xhttp.responseText,function(ret){

  				document.getElementById("produtos").innerHTML = "";

  				var txt = "";

          produtos = ret;

  				for(var i = 0; i < ret.length; i++){
  					txt+='<input type="checkbox" id="p'+ret[i].ID+'">'+ret[i].ID+" - "+ret[i].NOME+" - "+ret[i].PRECO+'<button onclick="editarProduto(0)">Editar</button><br>';
  				}

     			document.getElementById("produtos").innerHTML= txt;						

     			if(ret["message"]!=undefined){
  					document.getElementById("produtos").innerHTML = ret["message"];
     			}

     		});

        console.log(produtos);

		}
