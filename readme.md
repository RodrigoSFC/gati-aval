# Gati-aval

Avaliação para Gati, feito em [Laravel 5.4](https://laravel.com/docs/5.4)

## Requisitos

- [PHP 5.6.4](https://secure.php.net/) ou maior;
- [PgSql](https://www.postgresql.org/);
- [Node](https://nodejs.org/);
- [Bower](https://bower.io/).

## Instalação

- Baixar o projeto usando o commando :
	- `git clone https://github.com/RodrigoSFC/gati-aval.git`;
- Entrar na pasta criada:
	- `cd gati-aval`;
- Roda o comando para instalar as dependencias do composer:
	- `composer install` or `composer update`;
- Configurar o seu arquivo `.env`;
- Rodar o comando para criar as tabelas e suas respectivas colunas:
	- `php artisan migrate`;
- Ir até onde ficarão as dependências do `bower`:
	- `cd public\assets`;
- Instalar as dependências do `bower`: 
	- `bower install`;
- Ir até a pasta raiz do projeto:
	- `cd path\to\project\gati-aval` no Linux
	- `cd c:\xampp\htdocs\gati-aval` no Windows
- Rodar o comando do `Laravel` para criar um servidor PHP: 
	- `php artisan serve` ou
	- `Start o Xampp`
	
- OBS: Eu utilizo o comando `php artisan serve`, pois possuo o php7 instalado na máquina. E meu xampp está configurado com o php5.4