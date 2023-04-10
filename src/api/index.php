<?php
session_start();
include "./send_json.php";
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once('./request_handler.php');

$app = new RequestHandler;

$app->post('/', function ($request, $response) {
    $input = fopen('php://input', 'rb');
    $data = stream_get_contents($input);
    fclose($input);
    $data = json_decode($data);
    $_SESSION['username'] = $data->username;
    send_json($_SESSION);
});

$app->get('/', function ($request, $response) {
    send_json($_SESSION);
});

$app->handle();
