<?php
header("Cache-Control: no-cache");
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

$data = [];
if ($method === 'GET') {
    $data = $_GET;
} else {
    $raw = file_get_contents('php://input');
    if (stripos($contentType, 'application/json') !== false) {
        $data = json_decode($raw, true);
        if ($data === null) {
            $data = [];
        }
    } elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
        parse_str($raw, $data);
    } elseif ($raw !== '') {
        $data = ['raw' => $raw];
    }
}

$response = [
    'language' => 'PHP',
    'hostname' => gethostname(),
    'time' => date("D M j H:i:s Y"),
    'method' => $method,
    'contentType' => $contentType,
    'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'IP' => $_SERVER['REMOTE_ADDR'],
    'receivedData' => $data,
];

echo json_encode($response, JSON_PRETTY_PRINT);
