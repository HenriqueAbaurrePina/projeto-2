Temos 4 pastas no projeto, a pasta backend, a pasta bd, a pasta frontend, e a pasta k8s:

Pasta bd:

    Contem o arquivo init.sql, que contem a criação do banco de dados.

Pasta backend:

    contem os arquivos: cadastrar.php, db.php, index.php e Dockerfile:

    db.php -> contem a conexão do php com o banco de dados criado no arquivo init.sql

    index.php -> Adciona na tabela do banco o nome e o email enviados, caso o metodo enviado a ele seja o metodo POST, caso seja o metodo GET, ele envia um arquivo json com os dados da tabela, e caso não seja nem GET nem POST, ele retorna um erro.

    Dockerfile -> Base para a criação do container para o backend.

Pasta Frontend:

    Contem os arquivos: cadastrar.php, index.php, listar.php, e Dockerfile:

    index.php -> Contem o formulario para envio do nome e email que deseja cadastrar, e um link para mostrar uma lista de usuarios cadastrados na tabela.

    cadastrar.php -> faz o cadastro na tabela do nome e email enviado, utilizando HTTP (cURL).

    listar.php -> Faz a conexão com o backend, e decodifica o json enviado para mostrar os dados da tabela do banco de dados.

    Dockerfile -> Base para a criação do container para o frontend.

pasta k8s:

    Esta pasta contem os arquivos que serão executados para a aplicação rodar no kubernetes. Contem o deployment e o service do backend, frontend, e do banco mysql. Também contem o mysql-init-configmap.yml para a criação da tabela após iniciar o pod do mysql.

Dentro do Projeto 2 também temos o arquivo docker-compose.yml, onde ele é usado para criar os dockers em ordem, baseando-se nos Dockerfiles de suas respectivas pastas.

Instalação e deploy local:

    Primeiro tenha o Docker instalado na maquina, em seguida, utilize o comando "docker-compose up" no diretorio do projeto 2 no terminal.
    com isso os containers ja estarão rodando e será possivel acessar no localhost com a porta 8080.

Instalação e deploy pelo kubernetes:

    Primeiro tenha o Docker e o minikube instalado, em seguida inicie o cluster kubernetes com o comando "minikube up" tendo iniciado o programa utilize o comando "kubectl create -f k8s/" para criar os pods de cada serviço, utilizando os deployments e os services na pasta k8s.

    Utilizando o Azure temos a necessidade de criar um resource group, um kluster, e importar os arquivos do github, por meio de GIT. Com isso feito, podemos acessar a pasta do projeto 2, e criar os pods utilizando: "kubectl create -f k8s/".