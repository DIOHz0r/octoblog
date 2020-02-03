# OctoBlog

Un blog sencillo construido con Symfony 4.3.

[Repositorio publico](https://github.com/DIOHz0r/octoblog)

## Requisitos

* Necesario PHP 7.1 o superior
* [Composer](https://getcomposer.org) .
* MySQL 5.7 o compatible.

## Instalación

Clonar el repositorio y ejecutar el siguiente comando en el directorio del proyecto.

```composer install --no-dev``` 

Copiar el archivo '.env' en el directorio del proyecto y nombrar como '.env.local'

```$ cp .env .env.local```

Ajustar los datos de conexion a la base de datos (db_user, db_password, ip, db_name) en el archivo .env.local

```mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7``` 

> Si usa mariadb cambiar el valor de ```serverVersion``` a ```mariadb-X.Y.Z``` donde X en la version mayor, Y la menor, y Z la revision según su instalación local

Ejecutar los siguientes comando para crear la base de datos y registros de prueba.

```bin/console doctrine:schema:create``` 
```bin/console doctrine:fixtures:load -n``` 


## Acceso por web

### Apache

* Habilitar el mod_rewrite en el servidor. 
* Agregar un virtualhost que tenga de DocumentRoot la carpeta ```public``` de este proyecto. 
* Ingresar por la URL definia del el virtualhost.

### Symfony

* Instalar el comando symfony
    * Linux: ```wget https://get.symfony.com/cli/installer -O - | bash```.
    * MAC: ```curl -sS https://get.symfony.com/cli/installer | bash```.
    * Windows: descargar y ejecutar el [instalador](https://get.symfony.com/cli/setup.exe)
* Luego de instalado ingresar al directorio del proyecto e ejecutar ```symfony serve --no-tls```.
* Ingresar por la URL http://localhost:8000/ (o en la ruta indicada por el comando).

### Servidor web interno de PHP

Dentro del directorio ```public``` del proyecto ejecutar ```php -S localhost:8000``` e ingresar por el navegador web.

## Uso e ingreso 

Cualquier persona puede hacer el proceso de registro, para ingresar con los datos de prueba use los siguentes datos:

Email: admin@octoblog.local Clave: admin123
Email: usuario@octoblog.local Clave: usuario123
Email: usuario<N>@octoblog.local Clave: usuario<N> (<N> representa un numero del 1 al 5)