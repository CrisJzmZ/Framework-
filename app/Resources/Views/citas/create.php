<div class="container mt-4">
    <h2><i class="fas fa-calendar-plus"></i> Programar Nueva Cita</h2>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" id="citaForm">
                        <div class="mb-3">
                            <label for="especialidad_id" class="form-label">Especialidad</label>
                            <select class="form-control" id="especialidad_id" name="especialidad_id" required>
                                <option value="">Seleccione una especialidad</option>
                                <?php if (isset($especialidades)): ?>
                                    <?php foreach ($especialidades as $especialidad): ?>
                                        <option value="<?= $especialidad['id'] ?>">
                                            <?= htmlspecialchars($especialidad['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="medico_id" class="form-label">Médico</label>
                            <select class="form-control" id="medico_id" name="medico_id" required>
                                <option value="">Primero seleccione una especialidad</option>
                            </select>
                        </div>

                        <script>
                            document.getElementById('especialidad_id').addEventListener('change', function () {
                                const especialidadId = this.value;
                                const medicoSelect = document.getElementById('medico_id');
                                
                                // Clear previous options
                                medicoSelect.innerHTML = '<option value="">Cargando médicos...</option>';
                                
                                if (especialidadId) {
                                    fetch(`/api/medicos?especialidad_id=${especialidadId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            medicoSelect.innerHTML = '<option value="">Seleccione un médico</option>';
                                            data.forEach(medico => {
                                                if (medico.estado === 'activo') { // Only include active doctors
                                                    const option = document.createElement('option');
                                                    option.value = medico.id;
                                                    option.textContent = `${medico.nombre} ${medico.apellido}`;
                                                    medicoSelect.appendChild(option);
                                                }
                                            });
                                        })
                                        .catch(error => {
                                            console.error('Error fetching médicos:', error);
                                            medicoSelect.innerHTML = '<option value="">Error al cargar médicos</option>';
                                        });
                                } else {
                                    medicoSelect.innerHTML = '<option value="">Primero seleccione una especialidad</option>';
                                }
                            });
                        </script>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="hora" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="hora" name="hora" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo de la consulta</label>
                            <textarea class="form-control" id="motivo" name="motivo" rows="3" placeholder="Describa brevemente el motivo de su consulta"></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/citas" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-medical">Programar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
