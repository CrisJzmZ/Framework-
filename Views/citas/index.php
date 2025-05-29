<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-calendar-alt"></i> Gestión de Citas</h2>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'paciente'): ?>
            <a href="/citas/create" class="btn btn-medical">
                <i class="fas fa-plus"></i> Nueva Cita
            </a>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (empty($citas)): ?>
                <p class="text-muted text-center">No hay citas registradas.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador'): ?>
                                    <th>Paciente</th>
                                <?php endif; ?>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Estado</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($cita['fecha'])) ?></td>
                                    <td><?= date('H:i', strtotime($cita['hora'])) ?></td>
                                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador'): ?>
                                        <td><?= htmlspecialchars($cita['paciente_nombre']) ?></td>
                                    <?php endif; ?>
                                    <td><?= htmlspecialchars($cita['medico_nombre']) ?></td>
                                    <td><?= htmlspecialchars($cita['especialidad_nombre']) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= $cita['estado'] ?>">
                                            <?= ucfirst($cita['estado']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($cita['motivo'] ?? '-') ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#citaModal" 
                                            data-id="<?= $cita['id'] ?>" 
                                            data-fecha="<?= $cita['fecha'] ?>" 
                                            data-hora="<?= $cita['hora'] ?>" 
                                            data-paciente="<?= $cita['paciente_nombre'] ?>" 
                                            data-medico="<?= $cita['medico_nombre'] ?>" 
                                            data-especialidad="<?= $cita['especialidad_nombre'] ?>" 
                                            data-estado="<?= $cita['estado'] ?>" 
                                            data-motivo="<?= $cita['motivo'] ?>">
                                            Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="citaModal" tabindex="-1" aria-labelledby="citaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="citaModalLabel">Detalles de la Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                <p><strong>Hora:</strong> <span id="modalHora"></span></p>
                <p><strong>Paciente:</strong> <span id="modalPaciente"></span></p>
                <p><strong>Médico:</strong> <span id="modalMedico"></span></p>
                <p><strong>Especialidad:</strong> <span id="modalEspecialidad"></span></p>
                <p><strong>Estado:</strong> <span id="modalEstado"></span></p>
                <p><strong>Motivo:</strong> <span id="modalMotivo"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const citaModal = document.getElementById('citaModal');
    citaModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const fecha = button.getAttribute('data-fecha');
        const hora = button.getAttribute('data-hora');
        const paciente = button.getAttribute('data-paciente');
        const medico = button.getAttribute('data-medico');
        const especialidad = button.getAttribute('data-especialidad');
        const estado = button.getAttribute('data-estado');
        const motivo = button.getAttribute('data-motivo');

        document.getElementById('modalFecha').textContent = fecha;
        document.getElementById('modalHora').textContent = hora;
        document.getElementById('modalPaciente').textContent = paciente;
        document.getElementById('modalMedico').textContent = medico;
        document.getElementById('modalEspecialidad').textContent = especialidad;
        document.getElementById('modalEstado').textContent = estado;
        document.getElementById('modalMotivo').textContent = motivo;
    });
</script>
