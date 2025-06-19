# fp-virtual-gestion-docentes

Aplicación para la gestión del profesorado en FP virtual en Aragón

## Descripción

Aplicación web desarrollada en Laravel 10 y Vue 3 para la gestión del profesorado en FP virtual en Aragón. Permite gestionar asignaturas, profesores, grupos, aulas y horarios de manera sencilla e intuitiva.

## Características

Funcionamineto para poner en marcha la aplicacion:
Requisitos previos (tener instalado):

-   Composer → <https://getcomposer.org/>
-   MySQL (yo uso MySQL Workbench -> 10.4.32-MariaDB)
-   Node.js y npm → <https://nodejs.org/en> (npm se instala automáticamente con Node.js)
-   OPCIÓN 1: Entorno local como Laravel Valet, XAMPP, MAMP o Docker (Personalmente recomiendo XAMPP: <https://www.apachefriends.org/es/download.html> )
-   OPCIÓN 2: Servidor embebido. No es necesario instalar nada.

Una vez instalado todo:

-   Crear una base de datos llamada gestor_profesores (No hace falta crear tablas, el proyecto las genera automáticamente.)

Configurar el archivo .env:

-   Abrir el archivo .env
-   Entre las líneas 23 y 28, poner tus propios datos de conexión a la base de datos (nombre, usuario, contraseña, etc.)

En la terminal, ejecutar los siguientes comandos dentro del proyecto:

-   `composer install`
-   `npm install`
-   `npm run build`
-   `php artisan key:generate`
-   `php artisan migrate:fresh --seed`
-   `php artisan serve`

Esto hará lo siguiente:

-   Instala dependencias
-   Compila los assets del frontend
-   Genera la clave de la app
-   Crea y llena las tablas de la base de datos
-   Levanta el servidor

PD: Usuario: Admin | Contraseña: ZL3OkiDgON8Ya0M4Uj36

Versiones del proyecto:
Composer version 2.8.6
PHP version 8.2.12

Gestion Docentes  
├── @tailwindcss/forms@0.5.10
├── @tailwindcss/vite@4.1.1
├── alpinejs@3.14.9
├── autoprefixer@10.4.21
├── axios@1.8.4
├── concurrently@9.1.2
├── laravel-vite-plugin@1.2.0
├── postcss@8.5.3
├── tailwindcss@3.4.17
└── vite@6.3.2

Dependencias de composer.json
fakerphp/faker 1.24.1 Faker is a PHP library that generates fake data for you.
laravel-lang/attributes 2.13.4 List of 126 languages for form field names
laravel-lang/common 6.7.0 Easily connect the necessary language packs to the application
laravel/breeze 2.3.6 Minimal Laravel authentication scaffolding with Blade and Tailwind.
laravel/framework 12.6.0 The Laravel Framework.
laravel/pail 1.2.2 Easily delve into your Laravel application's log files directly from the command line.
laravel/pint 1.21.2 An opinionated code formatter for PHP.
laravel/sail 1.41.0 Docker files for running a basic Laravel application.
laravel/tinker 2.10.1 Powerful REPL for the Laravel framework.
mockery/mockery 1.6.12 Mockery is a simple yet flexible PHP mock object framework
nunomaduro/collision 8.7.0 Cli error handling for console/command-line PHP applications.
pestphp/pest 3.8.0 The elegant PHP Testing Framework.
pestphp/pest-plugin-laravel 3.1.0 The Pest Laravel Plugin
