<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../includes/auth.php';
include_once __DIR__ . '/../model/Usuari.php';
include_once __DIR__ . '/../controller/UsuariController.php';

header('Content-Type: application/json');

// GET / PUT / PATCH / DELETE users API

$payload = validarToken();

if (!$payload) {
    http_response_code(401);
    echo json_encode(["error" => "No autenticat"]);
    exit;
}

$controller = new UsuariController($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // GET
    case 'GET':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if ($id) {

            if ($payload['id'] !== $id && $payload['rol'] !== 'admin') {
                http_response_code(403);
                echo json_encode(["error" => "No tens permisos"]);
                break;
            }

            $usuari = $controller->obtenirUsuariPerId($id);

            if ($usuari) {
                echo json_encode(usuariToJson($usuari, true));
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuari no trobat"]);
            }

        } else {

            if ($payload['rol'] !== 'admin') {
                http_response_code(403);
                echo json_encode(["error" => "Accés restringit a administradors"]);
                break;
            }

            $usuaris = $controller->obtenirUsuaris();

            echo json_encode(array_map(fn($u) => usuariToJson($u, false), $usuaris));
        }
        break;

    // PUT
    case 'PUT':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el paràmetre id"]);
            break;
        }

        if ($payload['id'] !== $id && $payload['rol'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "No tens permisos per modificar aquest usuari"]);
            break;
        }

        $usuari = $controller->obtenirUsuariPerId($id);

        if (!$usuari) {
            http_response_code(404);
            echo json_encode(["error" => "Usuari no trobat"]);
            break;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        $usuari->setNom($input['nom'] ?? $usuari->getNom());
        $usuari->setEmail($input['email'] ?? $usuari->getEmail());
        $usuari->setUbicacio($input['ubicacio'] ?? $usuari->getUbicacio());
        $usuari->setTelefon($input['telefon'] ?? $usuari->getTelefon());

        $controller->actualitzarUsuari($usuari);

        echo json_encode(["missatge" => "Perfil actualitzat correctament"]);
        break;

    // PATCH password
    case 'PATCH':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el paràmetre id"]);
            break;
        }

        if ($payload['id'] !== $id) {
            http_response_code(403);
            echo json_encode(["error" => "Només pots canviar la teva pròpia contrasenya"]);
            break;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $novaContrasenya = $input['contrasenya'] ?? "";

        if (!$novaContrasenya) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el camp contrasenya"]);
            break;
        }

        $controller->actualitzarContrasenya($id, md5($novaContrasenya));

        echo json_encode(["missatge" => "Contrasenya actualitzada correctament"]);
        break;

    // DELETE
    case 'DELETE':
        if ($payload['rol'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "Accés restringit a administradors"]);
            break;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el paràmetre id"]);
            break;
        }

        $usuari = $controller->obtenirUsuariPerId($id);

        if (!$usuari) {
            http_response_code(404);
            echo json_encode(["error" => "Usuari no trobat"]);
            break;
        }

        $controller->eliminarUsuari($id);

        echo json_encode(["missatge" => "Usuari eliminat correctament"]);
        break;

    // DEFAULT
    default:
        http_response_code(405);
        echo json_encode(["error" => "Mètode no permès"]);
        break;
}

// Helper
function usuariToJson($usuari, $mostrarContacte) {
    $data = [
        "id" => $usuari->getId(),
        "nom" => $usuari->getNom(),
        "rol" => $usuari->getRol(),
        "ubicacio" => $usuari->getUbicacio(),
        "data_registre" => $usuari->getDataRegistre()
    ];

    if ($mostrarContacte) {
        $data["email"] = $usuari->getEmail();
        $data["telefon"] = $usuari->getTelefon();
    }

    return $data;
}
?>