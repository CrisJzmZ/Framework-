<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper para recursos estáticos
if (!function_exists('asset')) {
    function asset($path = '') {
        $base = rtrim((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
        return $base . '/public/assets/' . ltrim($path, '/');
    }
}

// Helper para rutas
if (!function_exists('route')) {
    function route($path = '') {
        $base = rtrim((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/');
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('is_authenticated')) {
    function is_authenticated() {
        return isset($_SESSION['user']);
    }
}
if (!function_exists('current_user')) {
    function current_user() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : ['name' => 'Invitado'];
    }
}
if (!function_exists('is_patient')) {
    function is_patient() {
        return isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'patient';
    }
}
if (!function_exists('show_flash_message')) {
    function show_flash_message() {
        if (!empty($_SESSION['flash_message'])) {
            $msg = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return '<div class="alert alert-info">' . htmlspecialchars($msg) . '</div>';
        }
        return '';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reservas Médicas</title>
    <link href="<?= asset('css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoYz1HIQ6k0nQ6eDZH8E78Cmcq2zF3e7G1p6L9e+8N4E+H" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= route() ?>">
                <i class="fas fa-heartbeat"></i> MediReservas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (is_authenticated()): ?>
                        <?php $user = current_user(); ?>
                        <li class="nav-item">
                            <span class="nav-link">Bienvenido, <?= htmlspecialchars($user['name']) ?></span>
                        </li>
                        <?php if (is_patient()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= route('citas') ?>">Mis Citas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= route('citas/create') ?>">Nueva Cita</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= route('auth/logout') ?>">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= route('auth/login') ?>">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= route('auth/register') ?>">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?= show_flash_message() ?>
        <?= isset($content) ? $content : '' ?>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; <?= date('Y') ?> Sistema de Reservas Médicas. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
