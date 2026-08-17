<?php
header("Cache-Control: no-cache");
header("Content-Type: application/json");

$message = [
    'name' => 'Eban',
    'title' => 'Hello, PHP!',
    'heading' => 'Hello, PHP!',
    'message' => 'This page was generated with the PHP programming language',
    'time' => date("D M j H:i:s Y"),
    'IP' => $_SERVER['REMOTE_ADDR'],
];

echo json_encode($message);
