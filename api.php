    <?php
    require_once 'controladorUsuario.php';
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    $metodo = $_SERVER['REQUEST_METHOD'];
    $controlador = new ControladorUsuario();

    switch ($metodo) {
        case 'POST':
            if (isset($input['accion'])) {
                switch ($input['accion']) {
                    case 'login':
                        echo json_encode($controlador->loginUsuario($input));
                        break;
                    case 'crear':
                        echo json_encode($controlador->crearUsuario($input));
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
            echo json_encode($controlador->cambiarUsuario($input)); 
        default:
            echo json_encode(['error' => 'Método no permitido']);
            break;
    }
