<?php
class HomeController {
    private $view;
    
    public function __construct() {
        if (config('app.environment') === 'development') {
            echo "<!-- HomeController: Constructor called -->\n";
        }
        $this->view = new View();
    }
    
    public function index() {
        // Debug en desarrollo
        if (config('app.environment') === 'development') {
            echo "<!-- HomeController: index() method called -->\n";
        }
        
        // Verificar si hay sesión activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Si el usuario está autenticado, redirigir al dashboard apropiado
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['user_role'] === 'administrador') {
                if (config('app.environment') === 'development') {
                    echo "<!-- HomeController: Redirecting to admin dashboard -->\n";
                }
                return $this->dashboard();
            } else {
                if (config('app.environment') === 'development') {
                    echo "<!-- HomeController: Redirecting to patient dashboard -->\n";
                }
                return $this->patientDashboard();
            }
        }
        
        // Si no está autenticado, mostrar página de inicio
        if (config('app.environment') === 'development') {
            echo "<!-- HomeController: Rendering home view -->\n";
        }
        
        try {
            $this->view->render('home');
            if (config('app.environment') === 'development') {
                echo "<!-- HomeController: Home view rendered successfully -->\n";
            }
        } catch (Exception $e) {
            if (config('app.environment') === 'development') {
                echo "<!-- HomeController: Error rendering home view: " . $e->getMessage() . " -->\n";
            }
            throw $e;
        }
    }
    
    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar que el usuario sea administrador
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
            redirect('auth/login');
            return;
        }
        
        try {
            $citaModel = new CitaModel();
            $medicoModel = new MedicoModel();
            $usuarioModel = new UsuarioModel();
            
            $totalCitas = $citaModel->getTotalCitas();
            $citasHoy = $citaModel->getCitasHoy();
            $totalMedicos = $medicoModel->getTotalMedicos();
            $totalPacientes = $usuarioModel->getTotalPacientes();
            
            $this->view->assign('totalCitas', $totalCitas);
            $this->view->assign('citasHoy', $citasHoy);
            $this->view->assign('totalMedicos', $totalMedicos);
            $this->view->assign('totalPacientes', $totalPacientes);
            
            $this->view->render('admin/dashboard');
        } catch (Exception $e) {
            if (config('app.environment') === 'development') {
                echo "Error en dashboard: " . $e->getMessage();
            }
            $this->view->assign('error', 'Error al cargar el dashboard');
            $this->view->render('admin/dashboard');
        }
    }
    
    public function patientDashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar que el usuario esté autenticado
        if (!isset($_SESSION['user_id'])) {
            redirect('auth/login');
            return;
        }
        
        try {
            $citaModel = new CitaModel();
            $citas = $citaModel->getCitasByPaciente($_SESSION['user_id']);
            
            $this->view->assign('citas', $citas);
            $this->view->render('patient/dashboard');
        } catch (Exception $e) {
            if (config('app.environment') === 'development') {
                echo "Error en patient dashboard: " . $e->getMessage();
            }
            $this->view->assign('citas', []);
            $this->view->render('patient/dashboard');
        }
    }
}
