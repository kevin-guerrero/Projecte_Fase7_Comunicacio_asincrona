<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../model/Usuari.php';
include_once __DIR__ . '/../controller/UsuariController.php';

header('Content-Type: application/json');

// POST /register.php registro de usuario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Mètode no permès"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

$nom = $input["nom"] ?? "";
$email = $input["email"] ?? "";
$contrasenya = $input["contrasenya"] ?? "";
$ubicacio = $input["ubicacio"] ?? "";
$telefon = $input["telefon"] ?? "";

if (!$nom || !$email || !$contrasenya) {
    http_response_code(400);
    echo json_encode(["error" => "Falten camps obligatoris: nom, email, contrasenya"]);
    exit;
}

$controller = new UsuariController($db);

// Comprovar usuari existent
$existent = $controller->obtenirUsuariPerNom($nom);

if ($existent) {
    http_response_code(409);
    echo json_encode(["error" => "El nom d'usuari ja existeix"]);
    exit;
}

$usuari = new Usuari(
    null,
    $nom,
    $email,
    md5($contrasenya),
    'usuari',
    $ubicacio,
    $telefon,
    date('Y-m-d')
);

$controller->crearUsuari($usuari);

http_response_code(201);
echo json_encode(["missatge" => "Usuari registrat correctament"]);
?>