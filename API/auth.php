<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../model/Usuari.php';
include_once __DIR__ . '/../controller/UsuariController.php';

header('Content-Type: application/json');

// POST /auth.php login | GET /auth.php validar token
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // POST login
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        $nom = $input["nom"] ?? "";
        $contrasenya = $input["contrasenya"] ?? "";

        if (!$nom || !$contrasenya) {
            http_response_code(400);
            echo json_encode(["error" => "Falten dades"]);
            break;
        }

        $controller = new UsuariController($db);
        $usuari = $controller->obtenirUsuariPerNom($nom);

        if (!$usuari || $usuari->getContrasenya() !== md5($contrasenya)) {
            http_response_code(401);
            echo json_encode(["error" => "Usuari o contrasenya incorrectes"]);
            break;
        }

        $header64 = base64_encode(json_encode([
            "alg" => "HS256",
            "typ" => "JWT"
        ]));

        $payload64 = base64_encode(json_encode([
            "id" => $usuari->getId(),
            "nom" => $usuari->getNom(),
            "rol" => $usuari->getRol(),
            "exp" => time() + 3600
        ]));

        $clauSecreta = "clauSuperSecreta123";

        $signatura = base64_encode(
            hash_hmac("sha256", "$header64.$payload64", $clauSecreta, true)
        );

        $token = "$header64.$payload64.$signatura";

        setcookie("token", $token, time() + 3600, "/");

        echo json_encode([
            "missatge" => "Login correcte",
            "token" => $token,
            "usuari" => [
                "id" => $usuari->getId(),
                "nom" => $usuari->getNom(),
                "rol" => $usuari->getRol()
            ]
        ]);
        break;

    // GET validar token
    case 'GET':
        include_once __DIR__ . '/../includes/auth.php';

        $payload = validarToken();

        if ($payload) {
            echo json_encode([
                "autenticat" => true,
                "usuari" => [
                    "id" => $payload['id'],
                    "nom" => $payload['nom'],
                    "rol" => $payload['rol']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["autenticat" => false]);
        }
        break;

    // default
    default:
        http_response_code(405);
        echo json_encode(["error" => "Mètode no permès"]);
        break;
}
?>