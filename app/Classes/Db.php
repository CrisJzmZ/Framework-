<?php
class Db {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        // Obtener la ruta del archivo de configuración usando las constantes definidas
        $configPath = defined('APP_ROOT') ? APP_ROOT . '/config.php' : dirname(dirname(__FILE__)) . '/config.php';
        
        if (!file_exists($configPath)) {
            die("Archivo de configuración no encontrado en: " . $configPath);
        }
        
        $config = require $configPath;
        
        if (!isset($config['database'])) {
            die("Configuración de base de datos no encontrada en el archivo de configuración");
        }
        
        $dbConfig = $config['database'];
        
        // Verificar que todos los parámetros necesarios estén presentes
        $requiredParams = ['host', 'database', 'username', 'password'];
        foreach ($requiredParams as $param) {
            if (!isset($dbConfig[$param])) {
                die("Parámetro de base de datos '$param' no encontrado en la configuración");
            }
        }
        
        try {
            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4";
            $this->connection = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            if (defined('APP_ROOT') && function_exists('config') && config('app.environment') === 'development') {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            } else {
                die("Error de conexión a la base de datos. Por favor, verifique la configuración.");
            }
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
