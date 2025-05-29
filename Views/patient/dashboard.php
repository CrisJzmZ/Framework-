<div class="container mt-4">
    <h2><i class="fas fa-user"></i> Mi Panel de Paciente</h2>
    
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt"></i> Mis Próximas Citas</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($citas)): ?>
                        <p class="text-muted">No tienes citas programadas.</p>
                        <a href="/citas/create" class="btn btn-medical">Programar Nueva Cita</a>
                    <?php else: ?>
                        <?php foreach ($citas as $cita): ?>
                            <div class="card appointment-card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6><?= htmlspecialchars($cita['medico_nombre']) ?></h6>
                                            <p class="mb-1"><strong>Especialidad:</strong> <?= htmlspecialchars($cita['especialidad_nombre']) ?></p>
                                            <p class="mb-1"><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($cita['fecha'])) ?></p>
                                            <p class="mb-1"><strong>Hora:</strong> <?= date('H:i', strtotime($cita['hora'])) ?></p>
                                            <?php if ($cita['motivo']): ?>
                                                <p class="mb-1"><strong>Motivo:</strong> <?= htmlspecialchars($cita['motivo']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="status-badge status-<?= $cita['estado'] ?>">
                                                <?= ucfirst($cita['estado']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-plus"></i> Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <a href="/citas/create" class="btn btn-medical w-100 mb-2">
                        <i class="fas fa-calendar-plus"></i> Nueva Cita
                    </a>
                    <a href="/citas" class="btn btn-outline-primary w-100">
                        <i class="fas fa-list"></i> Ver Todas las Citas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
