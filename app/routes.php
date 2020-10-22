<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    /*$app->add(function ($req,$res,$next){
    	$response = $next($req,$res);

    	return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });*/


    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });



    $app->get('/clientes','getClientes'); //OK
    $app->post('/clientes/edit','editCliente'); //OK
    $app->post('/clientes','getClientesBy'); //OK
    $app->post('/clientes/add','addCliente'); //OK
    $app->delete('/clientes/{id}','delCliente'); //OK

    $app->get('/pedidos','getPedidos'); //OK
    $app->post('/pedidos/edit','editPedido'); //OK
    $app->post('/pedidos','getPedidosBy'); //OK
    $app->post('/pedidos/add','addPedido'); //OK
    $app->delete('/pedidos/{id}','delPedido'); //OK

    $app->get('/produtos','getProdutos'); //OK
    $app->post('/produtos/edit','editProduto'); //OK
    $app->get('/produtos/{id}','getProdutosBy'); //OK 
    $app->get('/produtos/ped/{id}','getProdutosByPedido');
    $app->post('/produtos/add','addProduto'); //OK
    $app->delete('/produtos/{id}','delProduto'); //OK

    $app->run();


    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};






function getConn(){
    return new PDO('mysql:host=localhost;dbname=rits','root','', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

function getLastId($table){
    $stmt = getConn()->query("SELECT MAX(ID) AS ID FROM ".$table.";");
    $lastId = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $lastId;
}

function checkSenha($id){
	$sql = "SELECT ID,EMAIL FROM CLIENTE WHERE ID=:id";


	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();
    $cliente = $stmt->fetchAll(PDO::FETCH_OBJ);
    $check=false;


    if(sizeof($cliente)==0){
    	$check=true;
    }

    return $check;	
}

function checkTel($tel){
	$sql = "SELECT TELEFONE FROM CLIENTE WHERE TELEFONE=:tel";


	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("tel",$tel);
	$stmt->execute();
    $cliente = $stmt->fetchAll(PDO::FETCH_OBJ);
    $check=false;

    if(sizeof($cliente)==0){
    	$check=true;
    }

    return $check;	
}

function checkEmail($email){
	$sql = "SELECT EMAIL FROM CLIENTE WHERE EMAIL=:email";


	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("email",$email);
	$stmt->execute();
    $cliente = $stmt->fetchAll(PDO::FETCH_OBJ);
    $check=false;



    if(sizeof($cliente)==0){
    	$check=true;
    }

    return $check;	
}









function getClientes(Request $req, Response $resp){
    $stmt = getConn()->query("SELECT * FROM CLIENTE;");
    $clientes = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(sizeof($clientes)==0){

        $resp->withHeader('Content-Type','application/json');
        $resp->getBody()->write('{"message":"Não tem clientes cadastrados."}');
        $resp->withStatus(400);

        return $resp;
    }

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($clientes));
    $resp->withStatus(200);

 	return $resp;
       
}

function getClientesBy(Request $req, Response $resp,$args){
	$cliente = json_encode($req->getParsedBody());
	$cliente = json_decode($cliente);
	$sql = "SELECT NOME,EMAIL,TELEFONE,ENDERECO FROM CLIENTE WHERE ID=:id";

	if($cliente->id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$cliente->id);
	$stmt->execute();
    $cliente = $stmt->fetchAll(PDO::FETCH_OBJ);

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($cliente));
    $resp->withStatus(200);

 	return $resp;

 	//teste OK
}


function addCliente(Request $req, Response $resp){
    $client = json_encode($req->getParsedBody()); 
    $cliente = json_decode($client);
    $sql = "INSERT INTO CLIENTE VALUES (:id,:nome,:email,:telefone,:endereco);";
    $conn = getConn();


    if($cliente->id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo SENHA vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo SENHA deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    
	if($cliente->nome==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->nome)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if($cliente->email==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo EMAIL vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->email)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo EMAIL não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(sizeof(explode("@",$cliente->email))!=2){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo EMAIL deve seguir o formato: username@servidor.com"}');
		$resp->withStatus(400);
		return $resp;
    }

    if($cliente->telefone==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo TELEFONE vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->telefone)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo TELEFONE deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if($cliente->endereco==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ENDERECO vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->endereco)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ENDERECO não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(checkSenha($cliente->id)==false){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message": "Essa senha já está cadastrada"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(checkTel($cliente->telefone)==false){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message": "Esse telefone já está cadastrado"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(checkEmail($cliente->email)==false){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Esse endereço de email já está cadastrado"}');
		$resp->withStatus(400);
		return $resp;
    }    





    $stmt = $conn->prepare($sql);
    $stmt->bindParam("id",$cliente->id);
    $stmt->bindParam("nome",$cliente->nome);
    $stmt->bindParam("email",$cliente->email);
    $stmt->bindParam("telefone",$cliente->telefone);
    $stmt->bindParam("endereco",$cliente->endereco);
    $stmt->execute();


    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Cliente cadastrado com sucesso"}');
    $resp->withStatus(201);

 	return $resp;
 	//Teste OK
}


function editCliente(Request $req, Response $resp,$args){
	$client = json_encode($req->getParsedBody()); 
    $cliente = json_decode($client);
    $sql = "UPDATE CLIENTE SET NOME=:nome,EMAIL=:email,TELEFONE=:telefone,ENDERECO=:endereco WHERE ID=:id;";


    if($cliente->id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    
	if($cliente->nome==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->nome)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if($cliente->email==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo EMAIL vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->email)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo EMAIL não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(sizeof(explode("@",$cliente->email))!=2){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo EMAIL deve seguir o formato: username@servidor.com"}');
		$resp->withStatus(400);
		return $resp;
    }

    if($cliente->telefone==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo TELEFONE vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->telefone)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo TELEFONE deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if($cliente->endereco==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ENDERECO vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($cliente->endereco)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ENDERECO não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }


    $conn = getConn();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam("id",$cliente->id);
    $stmt->bindParam("nome",$cliente->nome);
    $stmt->bindParam("email",$cliente->email);
    $stmt->bindParam("telefone",$cliente->telefone);
    $stmt->bindParam("endereco",$cliente->endereco);
    $stmt->execute();


    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Cliente editado com sucesso"}');
    $resp->withStatus(200);

	return $resp;

	//teste OK
}


function delCliente(Request $req, Response $resp,$args){
	$id = $args['id'];
	$sql = "DELETE FROM CLIENTE WHERE id=:id";


	if($id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();
	$resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Cliente apagado com sucesso"}');
    $resp->withStatus(200);

 	return $resp;

 	//teste OK
}


function getPedidos(Request $req, Response $resp){
    $stmt = getConn()->query("SELECT * FROM PEDIDO;");
    $pedidos = $stmt->fetchAll(PDO::FETCH_OBJ);
	$resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($pedidos));
    $resp->withStatus(200);


 	return $resp;
}


function getPedidosBy(Request $req, Response $resp){
	$pedido = json_encode($req->getParsedBody());
	$pedido = json_decode($pedido);
	$sql = "SELECT DATA_CRIACAO,ID,STATUS FROM PEDIDO WHERE COD_CLI=:id";

	if($pedido->id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($pedido->id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$pedido->id);
	$stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($produtos));
    $resp->withStatus(200);

 	return $resp;
}


function addPedido(Request $req, Response $resp){
    $ped = json_encode($req->getParsedBody()); 
    $pedido = json_decode($ped);

    $sql = "INSERT INTO Pedido VALUES (:id,:cod_cli,:data,:status);";

    if($pedido->cliente==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo CLIENTE vazio"}');
    	

		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($pedido->cliente)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo CLIENTE deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    $conn = getConn();

    if(getLastId("PEDIDO")!=null){

    	$pedido->id = json_encode(getLastId("PEDIDO"));
    	$pedido->id = json_decode($pedido->id);
    	$pedido->id = $pedido->id[0];
    	$pedido->id = $pedido->id->ID;

    	$pedido->id++;
    } else {
    	$pedido->id=1;
    }
    
    $data = getdate();
    $data = $data["mday"]."/".$data["mon"]."/".$data["year"];
    $pedido->status="Pendente";

    $pedido->status="PENDENTE";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam("id",$pedido->id);
    $stmt->bindParam("cod_cli",$pedido->cliente);
    $stmt->bindParam("data",$data);
    $stmt->bindParam("status",$pedido->status);
    $stmt->execute();


	$resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Pedido cadastrado com sucesso","pedido":"'.$pedido->id.'"}');
    $resp->withStatus(201);

 	return $resp;

}


function delPedido(Request $req, Response $resp,$args){
	$id = $args['id'];
	$sql = "DELETE FROM PEDIDO WHERE id=:id";

	if($id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();


	$resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Pedido apagado com sucesso"}');
    $resp->withStatus(200);

 	return $resp;
}


function editPedido(Request $req, Response $resp, $args){
    $ped = json_encode($req->getParsedBody()); 
    $pedido = json_decode($ped);

    $sql = "UPDATE PEDIDO SET STATUS=:status,DATA_CRIACAO=:data WHERE ID=:id AND COD_CLI=:cliente";

    if(is_numeric($pedido->id)==false){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    if($pedido->status == ""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo STATUS vazio"}');
		$resp->withStatus(400);
		return $resp;
    }


    if(is_numeric($pedido->status)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo STATUS não pode ser numérico."}');
		$resp->withStatus(400);
		return $resp;
    }

    if($pedido->cliente == ""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo CLIENTE vazio"}');
		$resp->withStatus(400);
		return $resp;
    }


    if(is_numeric($pedido->cliente)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo CLIENTE deve ser numérico."}');
		$resp->withStatus(400);
		return $resp;
    }

    $data=getdate();
    $data = $data["mday"]."/".$data["mon"]."/".$data["year"];

    $conn = getConn();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam("status",$pedido->status);
    $stmt->bindParam("data",$data);
    $stmt->bindParam("id",$pedido->id);
    $stmt->bindParam("cliente",$pedido->cliente);
    $stmt->execute();



    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Pedido editado com sucesso"}');
	$resp->withStatus(204);
	return $resp;
}


function getProdutos(Request $req, Response $resp){
    $stmt = getConn()->query("SELECT * FROM PRODUTO;");
    $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(sizeof($produtos)==0){

        $resp->withHeader('Content-Type','application/json');
        $resp->getBody()->write('{"message":"Não tem produtos cadastrados."}');
        $resp->withStatus(400);

        return $resp;
    }

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($produtos));
    $resp->withStatus(200);

 	return $resp;
}


function editProduto(Request $req, Response $resp,$args){
    $prod = json_encode($req->getParsedBody()); 
    $produto = json_decode($prod);

    $sql = "UPDATE PRODUTO SET NOME=:nome,PRECO=:preco,COD_PED=:pedido WHERE ID=:id";

    if($produto->nome==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if($produto->preco==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo PRECO vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($produto->nome)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME não pode ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($produto->preco)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo PRECO deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

    if($produto->id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($produto->id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if($produto->pedido==""){
        $produto->pedido=null;
    }



    $conn = getConn();

    $stmt = $conn->prepare($sql);
    $stmt->bindParam("nome",$produto->nome);
    $stmt->bindParam("preco",$produto->preco);
    $stmt->bindParam("id",$produto->id);
    $stmt->bindParam("pedido",$produto->pedido);
    $stmt->execute();



    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Produto editado com sucesso"}');
	$resp->withStatus(204);
	return $resp;
}



function getProdutosBy(Request $req, Response $resp,$args){
    $id = $args['id'];
    $sql = "SELECT id,nome,preco FROM PRODUTO WHERE ID=:id;";

    if($id==""){
        $resp->withHeader('Content-Type','application/json');
        $resp->getBody()->write('{"message":"Atributo ID vazio"}');
        $resp->withStatus(400);
        return $resp;
    }

    if(is_numeric($id)!=1){
        $resp->withHeader('Content-Type','application/json');
        $resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
        $resp->withStatus(400);
        return $resp;
    }

    $conn = getConn();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam("id",$id);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($produtos));
    $resp->withStatus(200);

    return $resp;
}



function getProdutosByPedido(Request $req, Response $resp,$args){
	$id = $args['id'];
	$sql = "SELECT id,nome,preco FROM PRODUTO WHERE COD_PED=:id;";

	if($id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;
    }

	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write(json_encode($produtos));
    $resp->withStatus(200);

 	return $resp;
}


function addProduto(Request $req, Response $resp){
    $prod = json_encode($req->getParsedBody()); 
    $produto = json_decode($prod);

    $sql = "INSERT INTO Produto VALUES (:id,:nome,:preco,:pedido);";
    $conn = getConn();


    if($produto->nome==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($produto->nome)==1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo NOME não deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if($produto->preco==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo PRECO vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric((float) $produto->preco)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo PRECO deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

    if(sizeof(explode('.',$produto->preco))!=2){
        $resp->withHeader('Content-Type','application/json');
        $resp->getBody()->write('{"message":"Atributo PRECO deve ser vir no formato VALOR.CENTAVOS"}');
        $resp->withStatus(400);
        return $resp;
    }


    /*if($produto->pedido==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo PEDIDO vazio"}');
		$resp->withStatus(400);
		return $resp;
    }*/

    /*if(is_numeric($produto->pedido)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo PEDIDO deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }*/


    if(getLastId("PRODUTO")!=null){

    	$produto->id = json_encode(getLastId("PRODUTO"));
    	$produto->id = json_decode($produto->id);
    	$produto->id = $produto->id[0];
    	$produto->id = $produto->id->ID;

    	$produto->id++;
    } else {
    	$produto->id=1;
    }


    if($produto->pedido==""){
        $produto->pedido=null;
    }


    $stmt = $conn->prepare($sql);
    $stmt->bindParam("id",$produto->id);
    $stmt->bindParam("nome",$produto->nome);
    $stmt->bindParam("preco",$produto->preco);
    $stmt->bindParam("pedido",$produto->pedido);
    $stmt->execute();


    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Produto cadastrado com sucesso"}');
    $resp->withStatus(201);

 	return $resp;

}


function delProduto(Request $req, Response $resp,$args){
	$id = $args['id'];
	$sql = "DELETE FROM PRODUTO WHERE id=:id";

	if($id==""){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID vazio"}');
		$resp->withStatus(400);
		return $resp;
    }

    if(is_numeric($id)!=1){
    	$resp->withHeader('Content-Type','application/json');
    	$resp->getBody()->write('{"message":"Atributo ID deve ser numérico"}');
		$resp->withStatus(400);
		return $resp;

    }

	$conn = getConn();
	$stmt = $conn->prepare($sql);
	$stmt->bindParam("id",$id);
	$stmt->execute();

    $resp->withHeader('Content-Type','application/json');
    $resp->getBody()->write('{"message":"Produto apagado com sucesso"}');

    $resp->withStatus(200);

 	return $resp;
}