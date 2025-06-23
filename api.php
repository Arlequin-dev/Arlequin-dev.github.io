<?php
session_start();
require_once 'controladorUsuario.php';
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$input = json_decode(file_get_contents('php://input'), true);
$metodo = $_SERVER['REQUEST_METHOD'];
$controlador = new ControladorUsuario();

switch ($metodo) {
    case 'POST':
        if (isset($input['accion'])) {
            switch ($input['accion']) {
                case 'login':
                    $resultado = $controlador->loginUsuario($input);
                    if (isset($resultado['success']) && $resultado['success'] === true) {
                        $_SESSION['usuario_email'] = $input['email'];
                        $_SESSION['usuario_nombre'] = $resultado['nombre'];                 }
                        echo json_encode($resultado);
                    break;
                case 'crear':
                    if (!isset($input['nombre']) || !isset($input['email']) || !isset($input['pswd']) || !isset($input['tel'])) {
                        echo json_encode(['error' => 'Faltan datos para crear el usuario']);
                        break;
                    }
                    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                        echo json_encode(['error' => 'El email no es válido']);
                        break;
                    }
                    if (strlen($input['pswd']) < 6) {
                        echo json_encode(['error' => 'La contraseña debe tener al menos 6 caracteres']);
                        break;
                    }
                    echo json_encode($controlador->crearUsuario($input));
                    break;
                case 'deuda':
                    echo json_encode($controlador->crearDeuda($input['email'], $input['titulo'], $input['monto']));
                    break;
                default:
                    echo json_encode(['error' => 'Acción no reconocida']);
                    break;
            }
        } else {
            echo json_encode(['error' => 'No se especificó ninguna acción']);
        }
        break;
    case 'PUT':
        if (isset($input['accion'])) {
            switch ($input['accion']) {
                case 'cambiar':
                    if (isset($_SESSION['usuario_email'])) {
                        $input['email'] = $_SESSION['usuario_email'];
                        echo json_encode($controlador->cambiarUsuario($input));
                    } else {
                        echo json_encode(['error' => 'No se ha iniciado sesión']);
                    }
                    break;
                case 'aceptarPendiente':
                    if (isset($_SESSION['usuario_email']) && isset($input['email'])) {
                        echo json_encode($controlador->aceptarPendiente($input['email']));
                    } else {
                        echo json_encode(['error' => 'No se ha iniciado sesión o falta el email del pendiente']);
                    }
                    break;
                default:
                    echo json_encode(['error' => 'Acción PUT no reconocida']);
                    break;
            }
        } else {
            echo json_encode(['error' => 'No se especificó ninguna acción']);
        }
        break; 
    case 'GET':
        if (isset($_GET['accion'])) {
            switch ($_GET['accion']) {
                case 'verificar':
                    if (isset($_SESSION['usuario_email'])) {
                        echo json_encode([
                            'success' => true,
                            'email' => $_SESSION['usuario_email'],
                            'nombre' => $_SESSION['usuario_nombre'],
                            'telefono' => $_SESSION['usuario_telefono'] ?? null
                        ]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'No hay usuario logueado']);
                    }
                    break;
                case 'deudas':
                    if (isset($_SESSION['usuario_email'])) {
                        echo json_encode($controlador->obtenerDeudas($_SESSION['usuario_email']));
                    } else {
                        echo json_encode(['error' => 'No se ha iniciado sesión']);
                    }
                    break;
                case 'pendientes': 
                    echo json_encode($controlador->obtenerPendientes());
                    break; 
                case 'aprobados':
                    if (isset($_SESSION['usuario_email'])) {
                        echo json_encode($controlador->obtenerAprobados());
                    } else {
                        echo json_encode(['error' => 'No se ha iniciado sesión']);
                    }
                    break;
                case 'rol':
                    if (isset($_SESSION['usuario_email'])) {
                        echo json_encode($controlador->obtenerRol($_SESSION['usuario_email']));
                    } else {
                        echo json_encode(['error' => 'No se ha iniciado sesión']);
                    }
                    break;
                default:
                    echo json_encode(['error' => 'Acción no reconocida']);
                    break;
            }
        } else {
            echo json_encode(['error' => 'No se especificó acción']);
        }
        break;
    case 'DELETE':
        if (isset($_GET['accion'])) {
            switch ($_GET['accion']) {
                case 'delDeuda':
                    echo json_encode($controlador->eliminarDeuda($id, $_SESSION['usuario_email']));
                    break;
            }

            break;
        }
    default:
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
