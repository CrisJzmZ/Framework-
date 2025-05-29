<div class="container mt-4">
    <h2><i class="fas fa-tachometer-alt"></i> Panel de Administración</h2>
    
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= isset($totalCitas) ? $totalCitas : 0 ?></div>
                <div class="stat-label">Total Citas</div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= isset($citasHoy) ? $citasHoy : 0 ?></div>
                <div class="stat-label">Citas Hoy</div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= isset($totalMedicos) ? $totalMedicos : 0 ?></div>
                <div class="stat-label">Médicos Activos</div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= isset($totalPacientes) ? $totalPacientes : 0 ?></div>
                <div class="stat-label">Pacientes Registrados</div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar"></i> Gestión de Citas</h5>
                </div>
                <div class="card-body">
                    <p>Administra todas las citas médicas del sistema.</p>
                    <a href="/citas" class="btn btn-medical">Ver Citas</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-user-md"></i> Gestión de Médicos</h5>
                </div>
                <div class="card-body">
                    <p>Administra la información de los médicos.</p>
                    <a href="/medicos" class="btn btn-medical">Ver Médicos</a>
                </div>
            </div>
        </div>
    </div>
</div>
