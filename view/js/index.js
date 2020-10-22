function procReq(json,callback){
			//json=JSON.stringify(json);
			$pedidos = JSON.parse(json);

			//console.log($pedidos);
			callback($pedidos);
		}
		

		function validation(){
			var email = document.getElementById("email").value;
			var senha = document.getElementById("senha").value;
			senha=parseInt(senha);
			var email = email.split("@");
			var check = 0;

			if(email.length != 2){
				document.getElementById("msg").innerHTML = "Email inválido";
				document.getElementById("msg").style.color="red";
			} else {
				document.getElementById("msg").innerHTML = "";
				//window.location.replace("");
				check++;
			}

			if(isNaN(senha)){
				var msg="A senha deve conter apenas números";
				document.getElementById("msg2").innerHTML = msg;

				document.getElementById("msg2").style.color="red";
			} else {
				document.getElementById("msg2").innerHTML = "";
				check++;
			}

			if(check==2){
				var dados="id="+senha;
				var xhttp = new XMLHttpRequest();
  				xhttp.onreadystatechange = function() {
    				if (this.readyState == 4 && this.status == 200) {
     			 		procReq(this.responseText,function(ret){
     			 			if(ret.length == 0) {
     			 				document.getElementById("msg").innerHTML = "A senha informado não está cadastrado";

								document.getElementById("msg").style.color="red";
     			 			} else {

     			 				if(email.toString().localeCompare(ret[0].EMAIL)==-1){

     			 					sessionStorage.setItem("id",senha);
     			 					sessionStorage.setItem("email",ret[0].EMAIL);
     			 					sessionStorage.setItem("nome",ret[0].NOME);
     			 					sessionStorage.setItem("endereco",ret[0].ENDERECO);
     			 					sessionStorage.setItem("telefone",ret[0].TELEFONE);

     			 					window.location.replace("homepage.php");	
     			 				} else {
     			 					document.getElementById("msg").innerHTML = "O email informado não está cadastrado";

									document.getElementById("msg").style.color="red";
     			 				}
     			 			}
     			 		});
    				}
  				};

  				xhttp.open("POST", "http://localhost:8080/clientes", true);
  				xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  				xhttp.send(dados);
			}


}