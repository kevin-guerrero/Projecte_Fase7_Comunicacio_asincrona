<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../includes/auth.php';
include_once __DIR__ . '/../model/Article.php';
include_once __DIR__ . '/../controller/ArticleController.php';

header('Content-Type: application/json');

$controller = new ArticleController($db);
$method = $_SERVER['REQUEST_METHOD'];

// Switch Case de GET / POST / PUT / PATCH / DELETE article
switch ($method) {

    // GET
    case 'GET':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if ($id) {
            $article = $controller->obtenirArticlePerId($id);

            if ($article) {
                echo json_encode(articleToJson($article));
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Article no trobat"]);
            }
        } else {
            $articles = $controller->obtenirArticles();
            $categoria = $_GET['categoria'] ?? null;
            $cerca = $_GET['cerca'] ?? null;
            $ordre = $_GET['ordre'] ?? null;

            if ($categoria) {
                $articles = array_filter($articles, fn($a) => $a->getCategoria() === $categoria);
            }

            if ($cerca) {
                $cercaNorm = strtolower($cerca);
                $articles = array_filter($articles, fn($a) =>
                    str_contains(strtolower($a->getTitular()), $cercaNorm) ||
                    str_contains(strtolower($a->getSubtitular()), $cercaNorm) ||
                    str_contains(strtolower($a->getCuerpo()), $cercaNorm)
                );
            }

            if ($ordre === 'asc') {
                usort($articles, fn($a, $b) => $a->getVistas() - $b->getVistas());
            } elseif ($ordre === 'desc') {
                usort($articles, fn($a, $b) => $b->getVistas() - $a->getVistas());
            }

            echo json_encode(array_values(array_map('articleToJson', $articles)));
        }
        break;

    // POST
    case 'POST':
        $payload = validarToken();

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["error" => "No autenticat"]);
            break;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['titular'], $input['subtitular'], $input['cuerpo'], $input['categoria'])) {
            http_response_code(400);
            echo json_encode(["error" => "Falten camps obligatoris"]);
            break;
        }

        $article = new Article(
            null,
            $input['titular'],
            $input['subtitular'],
            $input['cuerpo'],
            $payload['nom'],
            $input['categoria'],
            date('Y-m-d'),
            $input['destacado'] ?? 0,
            0
        );

        $controller->crearArticle($article);

        http_response_code(201);
        echo json_encode(["missatge" => "Article creat correctament"]);
        break;

    // PUT
    case 'PUT':
        $payload = validarToken();

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["error" => "No autenticat"]);
            break;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el paràmetre id"]);
            break;
        }

        $articleExistent = $controller->obtenirArticlePerId($id);

        if (!$articleExistent) {
            http_response_code(404);
            echo json_encode(["error" => "Article no trobat"]);
            break;
        }

        // Només propietari o admin
        if ($payload['nom'] !== $articleExistent->getAutor() && $payload['rol'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "No tens permisos per modificar aquest article"]);
            break;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        $articleExistent->setTitular($input['titular'] ?? $articleExistent->getTitular());
        $articleExistent->setSubtitular($input['subtitular'] ?? $articleExistent->getSubtitular());
        $articleExistent->setCuerpo($input['cuerpo'] ?? $articleExistent->getCuerpo());
        $articleExistent->setCategoria($input['categoria'] ?? $articleExistent->getCategoria());
        $articleExistent->setDestacado($input['destacado'] ?? $articleExistent->getDestacado());

        $controller->actualitzarArticle($articleExistent);

        echo json_encode(["missatge" => "Article actualitzat correctament"]);
        break;

    // PATCH
    case 'PATCH':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el paràmetre id"]);
            break;
        }

        $article = $controller->obtenirArticlePerId($id);

        if (!$article) {
            http_response_code(404);
            echo json_encode(["error" => "Article no trobat"]);
            break;
        }

        $article->setVistas($article->getVistas() + 1);
        $controller->actualitzarVistaArticle($article);

        echo json_encode([
            "missatge" => "Vistes actualitzades",
            "vistes" => $article->getVistas()
        ]);
        break;

    // DELETE
    case 'DELETE':
        $payload = validarToken();

        if (!$payload) {
            http_response_code(401);
            echo json_encode(["error" => "No autenticat"]);
            break;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Falta el paràmetre id"]);
            break;
        }

        $article = $controller->obtenirArticlePerId($id);

        if (!$article) {
            http_response_code(404);
            echo json_encode(["error" => "Article no trobat"]);
            break;
        }

        if ($payload['nom'] !== $article->getAutor() && $payload['rol'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "No tens permisos per eliminar aquest article"]);
            break;
        }

        $controller->eliminarArticle($article);

        echo json_encode(["missatge" => "Article eliminat correctament"]);
        break;

    // DEFAULT
    default:
        http_response_code(405);
        echo json_encode(["error" => "Mètode no permès"]);
        break;
}

// Helper
function articleToJson($article) {
    return [
        "id" => $article->getId(),
        "titular" => $article->getTitular(),
        "subtitular" => $article->getSubtitular(),
        "cuerpo" => $article->getCuerpo(),
        "autor" => $article->getAutor(),
        "categoria" => $article->getCategoria(),
        "fecha" => $article->getFecha(),
        "destacado" => $article->getDestacado(),
        "vistas" => $article->getVistas()
    ];
}
?>