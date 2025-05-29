<?php
class Autoloader {
    public static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }
    
    public static function autoload($className) {
        // Obtener la ruta base del proyecto
        $baseDir = dirname(dirname(__FILE__)); // Subir dos niveles desde classes
        
        // Definir las rutas donde buscar las clases
        $paths = [
            $baseDir . '/classes/',
            $baseDir . '/controllers/',
            $baseDir . '/controllers/auth/',
            $baseDir . '/models/',
        ];
        
        // Buscar el archivo de la clase
        foreach ($paths as $path) {
            $file = $path . $className . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
        
        // Búsqueda case-insensitive para compatibilidad con Windows
        $lowerClassName = strtolower($className);
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $files = glob($path . '*.php');
                if ($files) {
                    foreach ($files as $file) {
                        $filename = pathinfo($file, PATHINFO_FILENAME);
                        if (strtolower($filename) === $lowerClassName) {
                            require_once $file;
                            return true;
                        }
                    }
                }
            }
        }
        
        return false;
    }
}
