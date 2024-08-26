## Travel App

Es una aplicación que tiene como funcionalidad mostrar el clima y conversion de moneda en pesos colombianos al país de destino con traducción al idioma alemán.

## Descripción

Nace de la necesidad de que un usuario necesita comprobar el clima y presupuesto que tendría al llegar al llegar a la ciudad y desea compartir dicha información con su novia la cual no entiende ni un poco del idioma español

## Características

- Listas dinámicas
- Historial
- Selector de idioma
- Aplicación web SPA

## Tecnologías Utilizadas
- Laravel
- Angular

## Instalación

1. Clona el repositorio: `git clone https://github.com/Dragnell27/pruebatecnica.git`
2. Navega al directorio del proyecto: `cd pruebatecnica`
3. Navega a la carpeta donde se encuentra alojado el backend: `cd backend/`
4. Instalamos las dependencies de laravel: `composer install`
5. Creamos el archivo .env clonando el .env.example: `cp .env.example .env`
6. Abrimos el archivo .env que se encuentra en la ruta `./backend/.env` y configuramos las variables de entorno de conexión a la base de datos que están a partir de la variable DB_CONNECTION (configura según tus necesidades).
7. Luego de vuelta en la consola de comandos ejecutamos `php artisan key:generate` 
seguido de `php artisan migrate`.
8. Volvemos a nuestra carpeta principal del proyecto `cd ../` y ejecutamos el comando `npm install && npm run install:frontend` para instalar las dependencias del proyecto principal y las dependencias del frontend.
9. Ejecutamos el comando `npm start` para iniciar el backend y frontend el proyecto.
10. Una vez la consola muestre que la aplicación levanto correctamente en nuestro navegador ingresamos al link: `http://localhost:4200/` para usar la aplicación web.




