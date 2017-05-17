# Gerenciador de produtos Acme Zend 3

Api para gestão de produtos da empresa Acme

#### Tecnologias utilizadas
- Zend Framework 3
- Cake ORM com Módulo de integração para zend framework 3 desenvolvido por mim https://github.com/armenio/zf3-cake-orm
- Autenticação feita com Zend Authentication e Módulo de integração desenvolvido por mim https://github.com/armenio/zf3-authentication
- Token JWT
- Composer como gerenciador de dependências php
- Banco de dados MySql
- Testes automatizados

## Instalação do projeto

```bash
$ git clone https://github.com/armenio/acme-zend-3.git aplicacao
$ cd aplicacao
$ composer install
```

- Não conhece o composer? [Veja aqui](http://getcomposer.org/doc/00-intro.md#introduction) como usá-lo
    - * é possível usar o composer sem instalação com o comando:
     ```bash
     $ /caminho/do/php /caminho/do/composer.phar install
     ```

### O arquivo para criação do banco de dados encontra-se em:
/caminho/da/aplicacao/data/db.sql

### Configuração do acesso ao bando de dados:
/caminho/da/aplicacao/module/Application/config/module.config.php - linha 86

## Rodando a aplicação
     ```bash
     $ cd /caminho/da/aplicacao
     $ php -S 127.0.0.1:8000 -t public/ public/index.php
     ```