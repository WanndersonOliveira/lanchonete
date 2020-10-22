# RITS Lanchonete   

## Explicação da resolução do problema  

**Framework: ** Slim Framework  


Devido a uma série de problemas, o código começou a ser implementado terça-feira (20/12).  

Primeiramente, foi decidido criar o banco de dados (nome: rits), observando o enunciado do problema, contudo para fins de manutenção da integridade relacional do banco, percebeu-se inviavel a criação do campo COD_PROD na tabela PEDIDO, pois, um pedido pode ter vários produtos,e para caso fosse colocado esse campo, cada registro de pedido na tabela estaria restrito a apenas um produto, o que tornaria o sistema menos intuitivo (Afinal de contas se o cliente requer um lanche com 5 produtos, seria mais fácil ele fazer um pedido com os 5 produtos do que 5 pedidos com cada produto).  


O framework back-end escolhido para criar a API RESTful foi o *Slim Framework*, um micro-framework PHP específico para API REST.  

Logo após foram criadas as operações CRUD para cada entidade obedecendo a arquitetura RESTful e testadas usando o aplicativo *Postman*  

Nesse sistema desenvolvido, para fins de simplificação, o id do cliente é a sua própria senha, que deve ser cadastrada assim que ele loga no sistema e deve ser numérica apenas.  

Devido a esse fato algumas requisições que requeiram do id do cliente devem ser feitas via requisição HTTP POST para evitar mostrar a senha do cliente no cabeçalho HTTP da url.  

Após implementadas as operações, foi dado início à criação das *views* do sistema e o código que irá receber e enviar requisições em Javascript.  
  

Como o Slim Framework é específico para API RESTful, foi necessário desenvolver as views à parte, usando código PHP, que podem ser acessadas na pasta view na aplicação.  

## Como configurar o sistema em sua máquina  

Ao fazer download do sistema, mova-o para a pasta raiz do WAMPP (www), LAMPP ou XAMPP (htdocs), logo após, ligue o servidor Apache e o servidor do banco de dados. você deve criar um banco de dados chamado "rits".  
Logo após, deve carregar um script localizado na raiz do projeto chamado *script_creation_database.sql*. Depois disso, acesse a pasta da aplicação através do terminal e digite o comando:  

*php -S localhost:8080 -t public public/index.php*  

## Como usar o sistema  

Para acessar a aplicação como **cliente**, abra uma aba em seu navegador e acesse a pasta view na raiz da aplicação:  

*localhost/lanchonete/view*  

Para acessar a aplicação como **administrador**, abra uma aba em seu navegador e acesse a pasta view na raiz da aplicação:  

*localhost/lanchonete/view/admin.php*  

Para se autenticar como **administrador** use os seguintes dados:  

**Usuario:** admin  
**Senha:** admin  

## Recomendações  

* Enquanto cadastrar o usuário, pode ser que apareça a mensagem: "Essa senha já está cadastrada", mesmo assim teste o email e a senha no login, pois o usuário já pode ter sido cadastrado, mas por um bug no sistema, essa mensagem ainda persiste.
* Evitar atualizar a página cliente.php enquanto usar o Painel Administrativo. (caso atualize, você deve clicar no link "voltar", e escolher novamente o cliente e acessar a página).








