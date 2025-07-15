## 📚 Sobre el Proyecto

Este proyecto consiste en un sistema de gestión de biblioteca, desarrollado con el framework **Laravel**. La aplicación permite administrar libros, autores, editoriales, préstamos y usuarios, facilitando el control de inventario y flujo de préstamos dentro de una institución educativa o biblioteca.

> El sistema ha sido desarrollado con fines académicos.

## ⚙️ Tecnologías Usadas

- **PHP 8+**
- **Laravel 12**
- **MySQL / MariaDB**
- **FilamentPHP (Panel de administración)**
- **TALL Stack**

## ✍️ Colaboradores

- [Allison Ventura](https://github.com/allison-ventura)
- [Maria Belén Salgado Sarmiento](https://github.com/MariaBelenSaSa)
- [Oscar Ardón](https://github.com/OsqY)
- [Andrea Karolina Santos](https://github.com/AndreaKarolinaSantos)
- [Aylin Iselle Miranda Guevara](https://github.com/AylinGuevara).

## 📁 Estructura General

- `app/Models`: Modelos Eloquent.
- `app/Filament/Resources`: Recursos del panel administrativo.
- `database/migrations`: Migraciones de las tablas.
- `resources/views`: Vistas personalizadas.

## 📌 Funcionalidades principales

- CRUD de Libros, Autores, Editoriales y Categorías.
- Registro y gestión de préstamos de libros.
- Control de disponibilidad de libros.
- Panel de administración amigable con Filament.

## 🚀 Instalación rápida

```bash
git clone https://github.com/OsqY/teoria-db-2
cd teoria-db-2
composer install
cp .env.example .env
php artisan key:generate
# Configura tus credenciales de base de datos en .env
php artisan migrate
php artisan serve
```

Para demás comandos de optimización refererise a las documentaciones oficiales de [Laravel](https://laravel.com/docs/12.x) y de [Filament](https://filamentphp.com/docs).
