# Como rodar o projeto localmente

### Vídeo da aplicação rodando
https://www.youtube.com/watch?v=D7Xa1btGbpo


## 📋 Pré-requisitos

Antes de começar, verifique se você possui os seguintes requisitos instalados em sua máquina:

- [Docker](https://www.docker.com/) (versão 20.10.0 ou superior)
- [PHP](https://www.php.net/) (versão 8.0 ou superior)
- [Node.js](https://nodejs.org/) (versão 16.x ou superior)
- [Composer](https://getcomposer.org/) (para dependências PHP)

## 🚀 Configuração inicial

### 1. Clone o repositório
```bash
git clone https://github.com/AndreTrevizam/php.git
cd php
```

### 2. Inicie o container
```
docker-compose up -d
```
Isso iniciará o servidor MySQL em um container Docker. Você pode configurar as opções do banco de dados no arquivo docker-compose.yml.
Caso altere as configurações no docker-compose.yml, atualize também o arquivo .env com as mesmas credenciais.

### 3. Configuração do projeto

Instale as dependências do PHP
```
composer install
```

Execute as migrações
```
php artisan migrate
```

Instale as dependências do NodeJS
```
npm install
```

### 4. Executando a aplicação
Inicie o servidor de desenvolvimento Vite (frontend)
```
npm run dev
```

Inice o servidor do Laravel (backend)
```
php artisan serve
```

Abra seu navegador e acesse
```
http://127.0.0.1:8000/
```