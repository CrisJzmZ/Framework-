<?php
/**
 * Archivo de configuración y funciones auxiliares
 * Este archivo contiene funciones helper para toda la aplicación
 */

// Definir constantes si no están definidas
if (!defined('APP_ROOT')) {
    define('APP_ROOT', __DIR__);
}

if (!defined('APP_PATH')) {
    define('APP_PATH', APP_ROOT);
}

// Funciones helper globales
function config($key = null) {
    static $config = null;
    
    if ($config === null) {
        $configFile = APP_ROOT . '/config.php';
        if (file_exists($configFile)) {
            $config = require_once $configFile;
        } else {
            $config = [];
        }
    }
    
    if ($key === null) {
        return $config;
    }

    $keys = explode('.', $key);
    $value = $config;

    foreach ($keys as $k) {
        if (!isset($value[$k])) {
            return null;
        }
        $value = $value[$k];
    }

    return $value;
}

// Función helper para el entorno
function env($key, $default = null) {
    $value = $_ENV[$key] ?? getenv($key);
    return $value !== false ? $value : $default;
}

// Función para obtener la URL base
function base_url($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Obtener el directorio base del proyecto
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = str_replace('/index.php', '', $scriptName);
    
    // Limpiar el path base
    if ($basePath === '/public' || $basePath === '\\public') {
        $basePath = '';
    }
    
    $baseUrl = $protocol . '://' . $host . $basePath;
    
    if (!empty($path)) {
        $baseUrl .= '/' . ltrim($path, '/');
    }
    
    return $baseUrl;
}

// Función para redireccionar
function redirect($url) {
    if (strpos($url, 'http') !== 0) {
        $url = base_url($url);
    }
    header('Location: ' . $url);
    exit;
}

// Función para obtener la URL actual
function current_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    
    return $protocol . '://' . $host . $uri;
}

// Función para validar email
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Función para generar token CSRF
function csrf_token() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

// Función para verificar token CSRF
function verify_csrf_token($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Función para limpiar input
function clean_input($data) {
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Función para formatear fecha
function format_date($date, $format = 'd/m/Y') {
    if (empty($date)) {
        return '';
    }
    
    if (is_string($date)) {
        $date = new DateTime($date);
    }
    
    return $date->format($format);
}

// Función para formatear hora
function format_time($time, $format = 'H:i') {
    if (empty($time)) {
        return '';
    }
    
    if (is_string($time)) {
        $time = new DateTime($time);
    }
    
    return $time->format($format);
}

// Función para generar slug
function generate_slug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

// Función para obtener el usuario actual
function current_user() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'] ?? '',
        'role' => $_SESSION['user_role'] ?? 'paciente'
    ];
}

// Función para verificar si el usuario está autenticado
function is_authenticated() {
    return current_user() !== null;
}

// Función para verificar si el usuario es admin
function is_admin() {
    $user = current_user();
    return $user && $user['role'] === 'administrador';
}

// Función para verificar si el usuario es paciente
function is_patient() {
    $user = current_user();
    return $user && $user['role'] === 'paciente';
}

// Función para mostrar errores de validación
function show_validation_errors($errors) {
    if (empty($errors)) {
        return '';
    }
    
    $html = '<div class="alert alert-danger"><ul class="mb-0">';
    foreach ($errors as $error) {
        $html .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $html .= '</ul></div>';
    
    return $html;
}

// Función para mostrar mensajes flash
function flash_message($type = null, $message = null) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($type && $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
        return;
    }
    
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }
    
    return null;
}

// Función para mostrar el HTML del mensaje flash
function show_flash_message() {
    $flash = flash_message();
    if (!$flash) {
        return '';
    }
    
    $alertClass = 'alert-info';
    switch ($flash['type']) {
        case 'success':
            $alertClass = 'alert-success';
            break;
        case 'error':
            $alertClass = 'alert-danger';
            break;
        case 'warning':
            $alertClass = 'alert-warning';
            break;
    }
    
    return '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">' .
           htmlspecialchars($flash['message']) .
           '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' .
           '</div>';
}

// Función para generar URLs de rutas
function route($path = '') {
    return base_url($path);
}

// Función para generar URLs de assets
function asset($path) {
    return base_url('assets/' . ltrim($path, '/'));
}
