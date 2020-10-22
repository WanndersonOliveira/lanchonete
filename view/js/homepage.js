var pedidos = [];

		function procReq(json,callback){
			var data = JSON.parse(json);
			callback(data);
		}

    function verPedido(){
      var pedido = document.getElementById("pedidos").value;
      console.log(pedido);
      var ped,p = null;

      ped = pedidos[0];

      for(var i = 0; i < ped.length; i++){
        if(parseInt(ped[i].ID) == parseInt(pedido.charAt(0)+pedido.charAt(1))){
          p = ped[i];
        }
      }

      sessionStorage.setItem("idPed",p.ID);
      sessionStorage.setItem("dataPed",p.DATA_CRIACAO);
      sessionStorage.setItem("statusPed",p.STATUS);

      window.location.replace("pedido.php");
    }

		function loadData(){
			var id=sessionStorage.getItem("id");
			//sessionStorage.removeItem("id");


			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    			if (this.readyState == 4 && this.status == 200) {
     			 	procReq(this.responseText,function(ret){
 

     			 		var total = 0;
     			 		var vis = "";

     			 		if(ret.length == 0){
     			 			document.getElementById('msg').innerHTML="Você não tem nenhum pedido";
                document.getElementById('pedidos').style.display ="none";
                document.getElementById('botao').style.display ="none";
     			 		} else {
     			 			for(var i = 0; i < ret.length; i++){
                  pedidos.push(ret);
     			 				vis=vis+'<option>'+ret[i].ID+' - '+ret[i].DATA_CRIACAO+' - '+ret[i].STATUS+'</option>';
     			 			}

                document.getElementById('pedidos').style.display ="block";
     			 			
                document.getElementById('botao').style.display ="block";
                document.getElementById('pedidos').innerHTML=vis;
     			 		
              }

     			 			
     			 	});
    			}
  			};


			var dados="id="+id;
  			xhttp.open("POST", "http://localhost:8080/pedidos", true);
  			xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  			xhttp.send(dados);

  		}

  		function sair(){
  			sessionStorage.removeItem("id");
  			sessionStorage.removeItem("nome");
  			sessionStorage.removeItem("email");
  			sessionStorage.removeItem("telefone");
  			sessionStorage.removeItem("endereco");
  			window.location.replace("index.php");
  		}
