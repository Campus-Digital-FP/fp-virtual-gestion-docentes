# fp-virtual-gestion-docentes

Aplicación para la gestión del profesorado en FP virtual en Aragón

## Funcionamineto para poner en marcha la aplicacion

Requisitos previos (tener instalado):

- Composer → <https://getcomposer.org/>
- MySQL (yo uso MySQL Workbench -> 10.4.32-MariaDB)
- Node.js y npm → https://nodejs.org/en (npm se instala automáticamente con Node.js)
- Entorno local como Laravel Valet, XAMPP, MAMP o Docker (Personalmente recomiendo XAMPP: <https://www.apachefriends.org/es/download.html> )

Una vez instalado todo:

- Crear una base de datos llamada gestor_profesores (No hace falta crear tablas, el proyecto las genera automáticamente.)
  
Configurar el archivo .env:

- Abrir el archivo .env
- Entre las líneas 23 y 28, poner tus propios datos de conexión a la base de datos (nombre, usuario, contraseña, etc.)

En la terminal, ejecutar los siguientes comandos dentro del proyecto:

- `composer install`
- `npm install`
- `npm run dev`
- `php artisan key:generate`
- `php artisan migrate:fresh --seed`
- `php artisan serve`

Esto hará lo siguiente:

- Instala dependencias
- Compila los assets del frontend
- Genera la clave de la app
- Crea y llena las tablas de la base de datos
- Levanta el servidor
  
PD: Usuario: Admin | Contraseña: 12345678

Cualquier cosa, mandarme un correo o lo que sea ^^
