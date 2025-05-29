<?php
class View {
    private $data = [];
    
    public function assign($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function render($template, $layout = 'main_layout') {
        extract($this->data);
        
        // Obtener la ruta base
        $baseDir = dirname(dirname(__FILE__));
        $viewsPath = $baseDir . '/resources/views/';
        $layoutsPath = $baseDir . '/resources/layouts/';
        
        // Verificar que el archivo de vista existe
        $viewFile = $viewsPath . $template . '.php';
        
        // Debug en desarrollo
        if (config('app.environment') === 'development') {
            error_log("View: Looking for template: $viewFile");
            error_log("View: Template exists: " . (file_exists($viewFile) ? 'YES' : 'NO'));
        }
        
        if (!file_exists($viewFile)) {
            // Si no existe la vista, mostrar error detallado en desarrollo
            if (config('app.environment') === 'development') {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;'>";
                echo "<h3>Vista no encontrada</h3>";
                echo "<p><strong>Template:</strong> $template</p>";
                echo "<p><strong>Archivo buscado:</strong> $viewFile</p>";
                echo "<p><strong>Directorio base:</strong> $baseDir</p>";
                echo "<p><strong>Directorio de vistas:</strong> $viewsPath</p>";
                
                // Listar archivos en el directorio de vistas
                if (is_dir($viewsPath)) {
                    echo "<p><strong>Archivos en directorio de vistas:</strong></p>";
                    echo "<ul>";
                    $files = scandir($viewsPath);
                    foreach ($files as $file) {
                        if ($file !== '.' && $file !== '..') {
                            echo "<li>$file</li>";
                        }
                    }
                    echo "</ul>";
                } else {
                    echo "<p><strong>El directorio de vistas no existe:</strong> $viewsPath</p>";
                }
                echo "</div>";
                return;
            } else {
                // En producción, mostrar 404
                if (class_exists('ErrorController')) {
                    $errorController = new ErrorController();
                    $errorController->notFound();
                    return;
                }
            }
        }
        
        // Capturar el contenido de la vista
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        
        // Verificar que el layout existe
        $layoutFile = $layoutsPath . $layout . '.php';
        if (!file_exists($layoutFile)) {
            if (config('app.environment') === 'development') {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px;'>";
                echo "<h3>Layout no encontrado</h3>";
                echo "<p><strong>Layout:</strong> $layout</p>";
                echo "<p><strong>Archivo buscado:</strong> $layoutFile</p>";
                echo "</div>";
            }
            // Si no hay layout, mostrar solo el contenido
            echo $content;
            return;
        }
        
        // Incluir el layout
        include $layoutFile;
    }
    
    public function renderPartial($template) {
        extract($this->data);
        $baseDir = dirname(dirname(__FILE__));
        $viewsPath = $baseDir . '/resources/views/';
        $viewFile = $viewsPath . $template . '.php';
        
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "Vista parcial no encontrada: " . $template;
        }
    }
}
