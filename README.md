# Rubik Code

---

## BrewBoard Café

Sistema ERP desarrollado para una cafetería. La aplicación busca optimizar el proceso de toma y manejo de ordenes. La
aplicación cuenta con una API para comunicarse con el CSP (aplicación móvil).

---

## Requerimientos

- PHP 8.4
- Node 22.15.0

---

## Instalación

- Clonar el repositorio

```bash
git clone https://github.com/RubikCoders/rc_brewboard_erp.git
cd rc_brewboard_erp
```

- Descargar las dependencias

- Las credenciales son para instalar el tema
username:
    angelmedoza2004@gmail.com
password:
    722eafb8-704f-405d-a5bd-a893527e40e2

```bash
composer install
npm install
```

- Copiar el archivo .env.example

```
cp .env.example .env
```

- Generar la llave de la aplicación

```bash
php artisan key:generate
```

- Ejecutar migraciones y seeds

```bash
php artisan migrate --seed
```
- Crear un usuario super admin


```bash
php artisan shield:super-admin
```

- Iniciar los servidores


```bash
php artisan serve
npm run dev
```

Si el php artisan serve no funciona, puedes usar esto ``php -S 127.0.0.1:3644 -t public
``




