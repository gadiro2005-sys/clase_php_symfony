# IES_ROMERO_PHP

# 🚗 Práctica Symfony + Doctrine – Gestión de Coches

## 📌 Descripción
Esta práctica tiene como objetivo:
- Instalar y configurar el framework **Symfony**
- Configurar **Doctrine ORM** para la conexión a una base de datos
- Crear la entidad **Coche** para almacenar modelos de coches
- Insertar datos en la base de datos y recuperarlos mediante un controlador

---

## 🛠️ Tecnologías utilizadas
- Symfony
- Doctrine ORM
- PHP 8+
- MySQL / MariaDB / PostgreSQL
- Composer
- Symfony CLI

---

## ✅ Instalación y configuración

### 1. Crear proyecto Symfony

Clonar repositorio

```
git clone https://github.com/gadiro2005-sys/clase_php_symfony.git
cd clase_php_symfony
```

Arrancamos el contendor docker para la práctica:

```
cd docker
docker compose -f docker-compose.yml -p docker up -d
```
o de otra forma:
```
docker-compose up -d
```
Accedemos al contenedor docker:
```
docker ps
docker exec -it symfony_app_php_fpm /bin/bash
composer install
```
Cuando pregunte por terminal:
Do you want to include Docker configuration from recipes?

Decir no

Arrancamos el servidor web de PHP sin necesidad de Apache o NGINX

```
symfony server:start --port=80 --listen-ip=0.0.0.0 &
```

Abrir el navegador con la siguiente dirección url:
- [ ] [Localhost](http://localhost) 
Veremos la web de symfony de desarrollo


Creamos la entidad coche

```
php bin/console make:entity
```
Con la siguiente estructura:

| Nombre   | Tipo    | Longitud | Nulo |
|----------|---------|----------|------|
| marca    | string  | 255      | No   |
| modelo   | string  | 255      | No   |
| imagen   | string  | 255      | No   |
| potencia | integer |          | No   |

Seguir las indicaciones que nos dice symfony por terminal.

Una vez creada la entidad, debemos actualizar los cambios en la base de datos.

```
php bin/console doctrine:schema:update --force
```

Crear la carpeta para subir fotos de coches

```
cd public
mkdir uploads

```

Abrir el navegador con la siguiente dirección url:
- [ ] [Localhost](http://localhost)

Ahora podremos dar de alta coches en la base datos.
