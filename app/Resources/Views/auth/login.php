<div class="container">
    <div class="card login-card mt-5">
        <div class="card-header text-center">
            <h3><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h3>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?= route('auth/login') ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>
            
            <div class="text-center mt-3">
                <p>¿No tienes cuenta? <a href="<?= route('auth/register') ?>">Regístrate aquí</a></p>
                <a href="<?= route() ?>" class="btn btn-link">Volver al Inicio</a>
            </div>
        </div>
    </div>
</div>
