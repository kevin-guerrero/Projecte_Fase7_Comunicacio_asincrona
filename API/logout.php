<?php
header('Content-Type: application/json');

// Elimina la cookie del token

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Mètode no permès"]);
    exit;
}

setcookie("token", "", time() - 3600, "/");
echo json_encode(["missatge" => "Sessió tancada correctament"]);
?>