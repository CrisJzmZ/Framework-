<?php
class CitaModel extends Model {
    protected $table = 'citas';
    
    public function getAll() {
        $stmt = $this->db->prepare("
            SELECT c.*, 
                   CONCAT(u.nombre, ' ', u.apellido) as paciente_nombre,
                   u.email as paciente_email,
                   CONCAT(m.nombre, ' ', m.apellido) as medico_nombre,
                   e.nombre as especialidad_nombre
            FROM citas c
            JOIN usuarios u ON c.paciente_id = u.id
            JOIN medicos m ON c.medico_id = m.id
            JOIN especialidades e ON m.especialidad_id = e.id
            ORDER BY c.fecha DESC, c.hora DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCitasByPaciente($paciente_id) {
        $stmt = $this->db->prepare("
            SELECT c.*, 
                   CONCAT(m.nombre, ' ', m.apellido) as medico_nombre,
                   e.nombre as especialidad_nombre
            FROM citas c
            JOIN medicos m ON c.medico_id = m.id
            JOIN especialidades e ON m.especialidad_id = e.id
            WHERE c.paciente_id = ?
            ORDER BY c.fecha DESC, c.hora DESC
        ");
        $stmt->execute([$paciente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalCitas() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM citas");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function getCitasHoy() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM citas WHERE fecha = CURDATE()");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function citaExists($medico_id, $fecha, $hora, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM citas WHERE medico_id = ? AND fecha = ? AND hora = ? AND estado != 'cancelada'";
        $params = [$medico_id, $fecha, $hora];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }
    
    public function updateEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE citas SET estado = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}
