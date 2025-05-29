<?php
class EspecialidadModel extends Model {
    protected $table = 'especialidades';
    
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM especialidades WHERE estado = 'activo' ORDER BY nombre");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getActivas() {
        return $this->getAll();
    }
    
    public function getTotalEspecialidades() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM especialidades WHERE estado = 'activo'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
