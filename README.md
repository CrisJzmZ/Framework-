# Framework-
Dado el proyecto propuesto en la actividad 6, implementarlo empleando el proyecto base (Framework) desarrollado en clase
# Sistema de Gestión de Citas Médicas

Este proyecto es una aplicación web desarrollada en **PHP** bajo una arquitectura personalizada basada en el patrón
**MVC (Modelo - Vista - Controlador)**. Su propósito es permitir a pacientes y médicos gestionar citas médicas en 
línea de manera eficiente y segura. El sistema facilita operaciones **CRUD** (Crear, Leer, Actualizar, Eliminar) 
sobre entidades como usuarios, citas, médicos y especialidades.

##  Objetivo del Proyecto

El objetivo de este sistema es:

- Aplicar principios de **programación orientada a objetos** en PHP.
- Crear un **mini framework MVC** desde cero para comprender su funcionamiento.
- Gestionar entidades médicas mediante operaciones CRUD.
- Permitir que los usuarios con distintos roles (pacientes, médicos) interactúen con el sistema de forma intuitiva.
- Garantizar una estructura limpia, modular y escalable.

---

## Requisitos del Sistema

 Recurso       Versión mínima recomendada 

 PHP           7.4 o superior              
 MySQL         5.7 o superior              
 Servidor Web  Apache / XAMPP / Laragon   
 Navegador     Chrome, Firefox, Edge       


## Instrucciones de Instalación

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/tuusuario/sistema-citas-medicas.git
   cd sistema-citas-medicas

   Importa la base de datos

Abre phpMyAdmin o tu cliente SQL.

Crea una base de datos:

sql
Copiar
Editar
CREATE DATABASE sistema_citas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
Importa el archivo sistema_reservas_medicas.sql incluido en el proyecto.

Configura la conexión a la base de datos
Edita el archivo config.php:

php
Copiar
Editar
define('DB_HOST', 'localhost');
define('DB_NAME', 'sistema_citas');
define('DB_USER', 'root');
define('DB_PASS', ''); // Cambia según tu entorno
Ejecuta el proyecto

Si usas XAMPP o similar, copia el proyecto en la carpeta htdocs.

Luego abre el navegador y accede a:

ruby
Copiar
Editar
http://localhost/sistema-citas-medicas/public/

Estructura del Proyecto
graphql
Copiar
Editar
sistema-citas-medicas/
│
├── app/
│   ├── Classes/                # Clases principales del núcleo MVC
│   │   ├── Autoloader.php      # Carga automática de clases
│   │   ├── Db.php              # Conexión PDO a la base de datos
│   │   ├── Router.php          # Definición y manejo de rutas
│   │   └── View.php            # Cargador de vistas
│   │
│   ├── Controllers/            # Controladores que manejan lógica de negocio
│   │   ├── CitaController.php
│   │   ├── UsuarioController.php
│   │   └── AuthController.php
│   │
│   ├── Models/                 # Modelos que interactúan con la base de datos
│   │   ├── CitaModel.php
│   │   ├── MedicoModel.php
│   │   ├── UsuarioModel.php
│   │   ├── EspecialidadModel.php
│   │   └── Model.php           # Modelo base genérico
│
├── Resources/
│   ├── Views/                  # Vistas HTML + PHP del sistema
│   │   ├── auth/               # Login y registro
│   │   ├── citas/              # Crear y listar citas
│   │   ├── patient/            # Dashboard de pacientes
│   │   ├── admin/              # Panel administrativo
│   │   └── error/              # Páginas de error 404 / 500
│   └── Layouts/                # Plantillas reutilizables
│
├── Public/                     # Punto de entrada principal (index.php)
│
├── config.php                  # Configuración global de la app
├── .htaccess                   # URLs amigables con Apache
├── sistema_reservas_medicas.sql # Script SQL para crear e insertar datos
└── README.md                   # Este archivo
