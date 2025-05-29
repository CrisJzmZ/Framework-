<?php
/**
 * Punto de entrada principal de la aplicación
 */

// Definir constantes de rutas solo si no están definidas
if (!defined('APP_START_TIME')) define('APP_START_TIME', microtime(true));
if (!defined('APP_ROOT')) define('APP_ROOT', dirname(dirname(__FILE__))); // Subir dos niveles desde public
if (!defined('APP_PATH')) define('APP_PATH', APP_ROOT);
if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', APP_ROOT . '/public');
if (!defined('STORAGE_PATH')) define('STORAGE_PATH', APP_ROOT . '/storage');
if (!defined('RESOURCES_PATH')) define('RESOURCES_PATH', APP_ROOT . '/resources');
if (!defined('CLASSES_PATH')) define('CLASSES_PATH', APP_ROOT . '/classes');
if (!defined('CONTROLLERS_PATH')) define('CONTROLLERS_PATH', APP_ROOT . '/controllers');
if (!defined('MODELS_PATH')) define('MODELS_PATH', APP_ROOT . '/models');

// Cargar configuración primero
$configFile = APP_PATH . '/config.php';
if (!file_exists($configFile)) {
    die("Archivo de configuración no encontrado: " . $configFile);
}

$config = require_once $configFile;

// Verificar que la configuración se cargó correctamente
if (!is_array($config)) {
    die("Error al cargar la configuración");
}

// Configurar zona horaria con valor por defecto
$timezone = 'America/Mexico_City';
if (isset($config['app']['timezone']) && !empty($config['app']['timezone'])) {
    $timezone = $config['app']['timezone'];
}
date_default_timezone_set($timezone);

// Configurar manejo de errores según el entorno
$environment = 'development';
if (isset($config['app']['environment'])) {
    $environment = $config['app']['environment'];
}

if ($environment === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/php_errors.log');
}

// Crear directorios necesarios si no existen
$directories = [
    STORAGE_PATH,
    STORAGE_PATH . '/logs',
    STORAGE_PATH . '/cache',
    STORAGE_PATH . '/sessions',
    STORAGE_PATH . '/uploads',
    STORAGE_PATH . '/backups',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Cargar funciones auxiliares
require_once APP_ROOT . '/app.php';

// Cargar clases manualmente en orden correcto
$classFiles = [
    APP_ROOT . '/classes/Router.php',
    APP_ROOT . '/classes/View.php',
    APP_ROOT . '/classes/Db.php',
    APP_ROOT . '/models/Model.php',
    APP_ROOT . '/models/UsuarioModel.php',
    APP_ROOT . '/models/MedicoModel.php',
    APP_ROOT . '/models/EspecialidadModel.php',
    APP_ROOT . '/models/CitaModel.php',
    APP_ROOT . '/controllers/HomeController.php',
    APP_ROOT . '/controllers/auth/AuthController.php',
    APP_ROOT . '/controllers/CitaController.php',
    APP_ROOT . '/controllers/ErrorController.php',
];

foreach ($classFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Archivo requerido no encontrado: " . $file);
    }
}

// Inicializar router
$router = new Router();

// Registrar rutas - ORDEN IMPORTANTE: más específicas primero
$router->addRoute('GET', 'auth/login', 'AuthController', 'login');
$router->addRoute('POST', 'auth/login', 'AuthController', 'login');
$router->addRoute('GET', 'auth/register', 'AuthController', 'register');
$router->addRoute('POST', 'auth/register', 'AuthController', 'register');
$router->addRoute('GET', 'auth/logout', 'AuthController', 'logout');

// Rutas de citas
$router->addRoute('GET', 'citas/create', 'CitaController', 'create');
$router->addRoute('POST', 'citas/create', 'CitaController', 'create');
$router->addRoute('GET', 'citas', 'CitaController', 'index');

// API Routes
$router->addRoute('GET', 'api/medicos-especialidad', 'CitaController', 'getMedicosByEspecialidad');

// Rutas de inicio - AL FINAL
$router->addRoute('GET', '', 'HomeController', 'index');

// Ejecutar aplicación
try {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    
    // Limpiar la URI
    $uri = parse_url($uri, PHP_URL_PATH);
    
    // Remover el directorio base del proyecto
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $basePath = dirname($scriptName); // /Sistema-Citas/app/public
    
    if ($basePath !== '/' && !empty($basePath)) {
        $uri = str_replace($basePath, '', $uri);
    }
    
    // Limpiar URI final
    $uri = trim($uri, '/');
    
    $router->dispatch($method, $uri);
    
} catch (Exception $e) {
    if ($environment === 'development') {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;'>";
        echo "<h3>Uncaught Exception</h3>";
        echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
        echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
        echo "</div>";
    } else {
        if (class_exists('ErrorController')) {
            $errorController = new ErrorController();
            $errorController->serverError();
        } else {
            echo "Error interno del servidor";
        }
    }
}
?>
