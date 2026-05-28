<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../includes/auth.php';
include_once __DIR__ . '/../model/Categoria.php';
include_once __DIR__ . '/../controller/CategoriaController.php';

header('Content-Type: application/json');

$controller = new CategoriaController($db);
$method = $_SERVER['REQUEST_METHOD'];

// Switch Case GET / POST / PUT / DELETE categories
switch ($method) {

    // GET
    case 'GET':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if ($id) {
            $categoria = $controller->obtenirCategoriaPerId($id);

            if ($categoria) {
                echo json_encode(categoriaToJson($categoria));
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Categoria no trobada"]);
            }
        } else {
            $categories = $controller->obtenirCategories();
            echo json_encode(array_map('categoriaToJson', $categories));
        }
        break;

    // POST
    case 'POST':
        $payload = validarToken();

        if (!$payload || $payload['rol'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "Accés restringit a administradors"]);
            break;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['nom'])) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el camp nom"]);
            break;
        }

        $categoria = new Categoria(
            null,
            $input['nom'],
            $input['descripcio'] ?? ""
        );

        $controller->crearCategoria($categoria);

        http_response_code(201);
        echo json_encode(["missatge" => "Categoria creada correctament"]);
        break;

    // PUT
    case 'PUT':
        $payload = validarToken();

        if (!$payload || $payload['rol'] !== 'admin') {
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

        $categoria = $controller->obtenirCategoriaPerId($id);

        if (!$categoria) {
            http_response_code(404);
            echo json_encode(["error" => "Categoria no trobada"]);
            break;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        $categoria->setNom($input['nom'] ?? $categoria->getNom());
        $categoria->setDescripcio($input['descripcio'] ?? $categoria->getDescripcio());

        $controller->actualitzarCategoria($categoria);

        echo json_encode(["missatge" => "Categoria actualitzada correctament"]);
        break;

    // DELETE
    case 'DELETE':
        $payload = validarToken();

        if (!$payload || $payload['rol'] !== 'admin') {
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

        $categoria = $controller->obtenirCategoriaPerId($id);

        if (!$categoria) {
            http_response_code(404);
            echo json_encode(["error" => "Categoria no trobada"]);
            break;
        }

        $controller->eliminarCategoria($id);

        echo json_encode(["missatge" => "Categoria eliminada correctament"]);
        break;

    // DEFAULT
    default:
        http_response_code(405);
        echo json_encode(["error" => "Mètode no permès"]);
        break;
}

// Helper
function categoriaToJson($categoria) {
    return [
        "id" => $categoria->getId(),
        "nom" => $categoria->getNom(),
        "descripcio" => $categoria->getDescripcio()
    ];
}
?>