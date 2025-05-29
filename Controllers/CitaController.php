<?php
class CitaController {
    private $view;
    private $citaModel;
    private $medicoModel;
    private $especialidadModel;
    
    public function __construct() {
        $this->view = new View();
        $this->citaModel = new CitaModel();
        $this->medicoModel = new MedicoModel();
        $this->especialidadModel = new EspecialidadModel();
    }
    
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        
        if ($_SESSION['user_role'] === 'administrador') {
            $citas = $this->citaModel->getAll();
        } else {
            $citas = $this->citaModel->getCitasByPaciente($_SESSION['user_id']);
        }
        
        $this->view->assign('citas', $citas);
        $this->view->render('citas/index');
    }
    
    public function create() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $_SESSION['user_id'],
                'medico_id' => $_POST['medico_id'],
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['hora'],
                'motivo' => $_POST['motivo'] ?? ''
            ];
            
            // Validar que no exista conflicto de horario
            if ($this->citaModel->citaExists($data['medico_id'], $data['fecha'], $data['hora'])) {
                $this->view->assign('error', 'Ya existe una cita programada para ese médico en esa fecha y hora');
            } else {
                if ($this->citaModel->create($data)) {
                    header('Location: /citas');
                    exit;
                } else {
                    $this->view->assign('error', 'Error al crear la cita');
                }
            }
        }
        
        $especialidades = $this->especialidadModel->getAll();
        $medicos = $this->medicoModel->getAll();
        
        $this->view->assign('especialidades', $especialidades);
        $this->view->assign('medicos', $medicos);
        $this->view->render('citas/create');
    }
    
    public function getMedicosByEspecialidad() {
        $especialidad_id = $_GET['especialidad_id'] ?? 0;
        $medicos = $this->medicoModel->getByEspecialidad($especialidad_id);
        
        header('Content-Type: application/json');
        echo json_encode($medicos);
    }
}
