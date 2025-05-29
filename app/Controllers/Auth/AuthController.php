<?php
class AuthController {
    private $view;
    private $usuarioModel;
    
    public function __construct() {
        $this->view = new View();
        
        // Solo inicializar el modelo si realmente se necesita
        // Esto evita errores de conexión innecesarios
        $this->usuarioModel = null;
    }
    
    private function getUserModel() {
        if ($this->usuarioModel === null) {
            $this->usuarioModel = new UsuarioModel();
        }
        return $this->usuarioModel;
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = clean_input($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validaciones básicas
            if (empty($email) || empty($password)) {
                $this->view->assign('error', 'Por favor complete todos los campos');
            } elseif (!is_valid_email($email)) {
                $this->view->assign('error', 'Por favor ingrese un email válido');
            } else {
                try {
                    $user = $this->getUserModel()->authenticate($email, $password);
                    
                    if ($user) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['nombre'] . ' ' . $user['apellido'];
                        $_SESSION['user_role'] = $user['rol'];
                        
                        flash_message('success', '¡Bienvenido al sistema!');
                        redirect('/');
                    } else {
                        $this->view->assign('error', 'Credenciales incorrectas');
                    }
                } catch (Exception $e) {
                    if (config('app.environment') === 'development') {
                        $this->view->assign('error', 'Error de conexión: ' . $e->getMessage());
                    } else {
                        $this->view->assign('error', 'Error del sistema. Inténtelo más tarde.');
                    }
                }
            }
        }
        
        $this->view->render('auth/login');
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => clean_input($_POST['nombre'] ?? ''),
                'apellido' => clean_input($_POST['apellido'] ?? ''),
                'email' => clean_input($_POST['email'] ?? ''),
                'telefono' => clean_input($_POST['telefono'] ?? ''),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'direccion' => clean_input($_POST['direccion'] ?? ''),
                'password' => $_POST['password'] ?? ''
            ];
            
            // Validaciones
            $errors = [];
            
            if (empty($data['nombre'])) {
                $errors[] = 'El nombre es requerido';
            }
            
            if (empty($data['apellido'])) {
                $errors[] = 'El apellido es requerido';
            }
            
            if (empty($data['email'])) {
                $errors[] = 'El email es requerido';
            } elseif (!is_valid_email($data['email'])) {
                $errors[] = 'El email no es válido';
            }
            
            if (empty($data['password'])) {
                $errors[] = 'La contraseña es requerida';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres';
            }
            
            if (empty($errors)) {
                try {
                    // Verificar si el email ya existe
                    if ($this->getUserModel()->emailExists($data['email'])) {
                        $errors[] = 'El email ya está registrado';
                    }
                    
                    if (empty($errors)) {
                        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                        
                        if ($this->getUserModel()->create($data)) {
                            flash_message('success', 'Usuario registrado exitosamente. Puede iniciar sesión.');
                            redirect('auth/login');
                        } else {
                            $this->view->assign('error', 'Error al registrar usuario');
                        }
                    } else {
                        $this->view->assign('error', implode('<br>', $errors));
                    }
                } catch (Exception $e) {
                    if (config('app.environment') === 'development') {
                        $this->view->assign('error', 'Error de conexión: ' . $e->getMessage());
                    } else {
                        $this->view->assign('error', 'Error del sistema. Inténtelo más tarde.');
                    }
                }
            } else {
                $this->view->assign('error', implode('<br>', $errors));
            }
        }
        
        $this->view->render('auth/register');
    }
    
    public function logout() {
        session_start();
        session_destroy();
        flash_message('info', 'Sesión cerrada exitosamente');
        redirect('/');
    }
}
