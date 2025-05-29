<?php
/**
 * Archivo de configuración principal del sistema
 * Contiene todas las configuraciones de la aplicación
 */

return [
    // Configuración de la aplicación
    'app' => [
        'name' => 'Sistema de Reservas Médicas',
        'version' => '1.0.0',
        'environment' => 'development', // development, production, testing
        'debug' => true,
        'timezone' => 'America/Mexico_City',
        'locale' => 'es_ES',
        'url' => 'http://localhost',
        'key' => 'base64:' . base64_encode('tu-clave-secreta-de-32-caracteres'),
    ],

    // Configuración de base de datos
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'sistema_reservas_medicas',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],

    // Configuración de sesiones
    'session' => [
        'driver' => 'file',
        'lifetime' => 120, // minutos
        'expire_on_close' => false,
        'encrypt' => false,
        'files' => 'storage/sessions',
        'connection' => null,
        'table' => 'sessions',
        'store' => null,
        'lottery' => [2, 100],
        'cookie' => 'medireservas_session',
        'path' => '/',
        'domain' => null,
        'secure' => false,
        'http_only' => true,
        'same_site' => 'lax',
    ],

    // Configuración de email
    'mail' => [
        'driver' => 'smtp',
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => '',
        'password' => '',
        'encryption' => 'tls',
        'from' => [
            'address' => 'noreply@medireservas.com',
            'name' => 'Sistema de Reservas Médicas',
        ],
    ],

    // Configuración de citas médicas
    'appointments' => [
        'min_advance_hours' => 2,
        'max_advance_days' => 30,
        'duration_minutes' => 30,
        'working_hours' => [
            'start' => '08:00',
            'end' => '17:00',
        ],
        'working_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
        'auto_confirm' => false,
        'reminder_hours' => 24,
    ],
];
