# Payco

Backend con soap con laravel ademas de rest y graphql en nodejs

### Descripción 📋

soap tiene el proyecto laravel
rest tiene el proyecto nodejs (rest + graphql)


### Instalación 🔧

La conexión a la base de dato se configura en el archivo .env de  dentro del directorio soap.

Entrar en el directorio soap y ejecutar 
```
composer install
php artisan key:generate
php artisan migrate
```
Para ajustar el api a cual url debe apuntar debe configurarse el archivo .env dentro de api, de igual forma puede cambiarse el puerto

Entrar en el directorio rest y ejecutar 
```
npm install
```

## Ejecutando las pruebas ⚙️

Entrar en el directorio rest y ejecutar 
```
npm start
```

## Collection Postman

https://www.getpostman.com/collections/4a5632d2121a07ed1cb1

## Autores ✒️

* **Carlos Rivas** - [carlosrivas2021](https://github.com/carlosrivas2021)