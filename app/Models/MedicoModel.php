<?php
class MedicoModel extends Model {
    protected $table = 'medicos';
    
    public function getAll() {
        $stmt = $this->db->prepare("
            SELECT m.*, e.nombre as especialidad_nombre 
            FROM medicos m 
            LEFT JOIN especialidades e ON m.especialidad_id = e.id 
            WHERE m.estado = 'activo'
            ORDER BY m.nombre
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByEspecialidad($especialidad_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM medicos 
            WHERE especialidad_id = ? AND estado = 'activo'
            ORDER BY nombre
        ");
        $stmt->execute([$especialidad_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalMedicos() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM medicos WHERE estado = 'activo'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function getWithEspecialidad($id) {
        $stmt = $this->db->prepare("
            SELECT m.*, e.nombre as especialidad_nombre 
            FROM medicos m 
            LEFT JOIN especialidades e ON m.especialidad_id = e.id 
            WHERE m.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
