# Clicars Technical Test

<p align="center">
    <a href="https://www.docker.com/"><img src="https://img.shields.io/badge/Docker-19-blue.svg?style=flat-square&logo=docker" alt="Docker"/></a>
    <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Symfony-5-red?style=flat-square&logo=symfony" alt="Symfony"/></a>
    <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-7-777BB4.svg?style=flat-square&logo=php" alt="PHP"/></a>
    <a href="https://www.jetbrains.com/es-es/phpstorm/?ref=steemhunt"><img src="https://img.shields.io/badge/PhpStorm-2021-000000.svg?style=flat-square&logo=phpstorm" alt="PhpStorm"/></a>
    <a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/mysql-8-4479A1.svg?style=flat-square&logo=mysql" alt="MySql"/></a>
    <a href="https://www.sqlite.org/index.html"><img src="https://img.shields.io/badge/sqlite-3-003B57.svg?style=flat-square&logo=sqlite" alt="SQLite"/></a>
    <a href="#"><img src="https://img.shields.io/badge/github_actions-2088FF.svg?style=flat-square&logo=github-actions" alt="Github Actions"/></a>
</p>

Instructions:
La prueba de selección de la primera fase consiste en resolver un problema donde deberás desarrollar una buena solución orientada a objetos, utilizando las estructuras de datos necesarias y con algoritmos eficientes.

Aunque en Clicars utilizamos diferentes lenguajes y tecnologías, el utilizado para la prueba será PHP, puesto que es el que usamos en más proyectos. Utilizamos PHP 8, 100% tipado. Solo necesitas tener montado un entorno donde ejecutar php-cli, y sería recomendable utilizar un IDE para facilitar el desarrollo.

El enunciado de la prueba está en inglés y tiene un tiempo máximo de 2 horas de duración (si terminas en menos tiempo, mejor). Recibirás un comprimido con las interfaces de donde partir y algunos tests para probar tu solución.

[File](./--.zip)

# 🐳 Docker + PHP 7.4 + MySQL + Nginx + Symfony 5 Boilerplate

## Description

This is a complete stack for running Symfony 5 into Docker containers using docker-compose tool.

It is composed by 3 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 7.4 PHPversion.
- `db` which is the MySQL database container with a **MySQL 8.0** image.

## Installation

1. 😀 Clone this rep.

2. Run `docker-compose up -d`

3. The 3 containers are deployed: 

```
Creating symfony-docker_db_1    ... done
Creating symfony-docker_php_1   ... done
Creating symfony-docker_nginx_1 ... done
```

4. Use this value for the DATABASE_URL environment variable of Symfony:

```
DATABASE_URL=mysql://app_user:helloworld@db:3307/app_db?serverVersion=5.7
```

You could change the name, user and password of the database in the `env` file at the root of the project.

5. Install packages from composer

```shell script
$ docker-compose exec php sh
$ composer install
```

## Local Web site

[Local Web](http://localhost:8001/)

## PHP container access

```shell script
$ docker-compose exec php sh
```

## Execute command

1. Enter to php container
2. Execute command:

```shell script
$ php bin/console clicars:test
```