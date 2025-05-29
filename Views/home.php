<div class="hero-section py-5 bg-light text-center">
    <div class="container">
        <h1 class="display-4">Sistema de Reservas Médicas</h1>
        <p class="lead">Gestiona tus citas médicas de forma fácil y eficiente</p>
        <a href="<?= route('auth/register') ?>" class="btn btn-primary btn-lg">Comenzar Ahora</a>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100">
                <div class="card-body text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-calendar-check fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title">Reserva Fácil</h5>
                    <p class="card-text">Programa tus citas médicas en línea de manera rápida y sencilla.</p>
                    <a href="<?= route('auth/register') ?>" class="btn btn-primary">Registrarse</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100">
                <div class="card-body text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-user-md fs-1 text-success"></i>
                    </div>
                    <h5 class="card-title">Médicos Especializados</h5>
                    <p class="card-text">Accede a una amplia red de médicos especializados en diferentes áreas.</p>
                    <a href="<?= route('auth/login') ?>" class="btn btn-outline-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100">
                <div class="card-body text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-clock fs-1 text-warning"></i>
                    </div>
                    <h5 class="card-title">Disponibilidad 24/7</h5>
                    <p class="card-text">Gestiona tus citas en cualquier momento del día desde cualquier lugar.</p>
                    <a href="<?= route('auth/register') ?>" class="btn btn-success">Empezar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h2>¿Ya tienes cuenta?</h2>
            <p class="lead">Accede a tu panel de paciente para gestionar tus citas médicas</p>
            <a href="<?= route('auth/login') ?>" class="btn btn-primary btn-lg me-3">Iniciar Sesión</a>
            <a href="<?= route('auth/register') ?>" class="btn btn-outline-primary btn-lg">Crear Cuenta</a>
        </div>
    </div>
</div>
