# Topic Notify API

## Descrição

Este projeto é uma API para gerenciamento de tópicos (temas de interesse) e listas de e-mails associadas. Usuários podem se inscrever em listas e receber notificações via e-mail.

## Requisitos do Sistema

- Laravel 11
- Docker
- PHP 8.2+
- MySQL
- Composer
- PHP Unit

## Portas dos serviços
- Porta interna da aplicação: 80
- Porta externa da aplicação: 8000
- Porta interna do DB: 3306
- Porta externa do DB: 3308

## Dados de acesso
- DB: usuário: root senha: root_password
- DB: banco: topic_notify_db
- Usuario Admin da api: admin@example.com / password

## Passos para Instalação

### Clonar o Repositório

``` git clone https://github.com/raphaelmurta/the-members-test.git ```

### Configurar o Ambiente

 - Copie o arquivo .env.example para .env e ajuste as variáveis de ambiente, especialmente a configuração do banco de dados.
```  
cp .env.example .env 
```

- Gere a chave da aplicação: php artisan key:generate

- Subir o Ambiente com Docker: 
```
docker-compose up -d --build
```
Isso irá iniciar os containers do MySQL e da aplicação.

- Executar Migrações e Seeders
Rode as migrações e seeds para preparar o banco de dados com as tabelas e criar o usuário admin.
```
docker exec -it topic-notify-api-app-1 php artisan migrate --seed
```
Agora o sistema está pronto para uso.


### Uso da API
``` 
Procure o documento Members-Test.postman_collection.json na raiz do projeto e importe no postman
```

## Testes Automatizados
Para rodar os testes:

```docker exec -it topic-notify-api-app-1 php artisan test```