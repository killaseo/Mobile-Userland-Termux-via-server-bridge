<?php
// Sekret w nagłówku HTTP zamiast URL (nie leci w logach serwera)
$secret = 'add_yourown_secret_pass_key_here';
if (($_SERVER['HTTP_X_BRIDGE_KEY'] ?? '') !== $secret) {
    http_response_code(403); die('forbidden');
}

$dir = __DIR__ . '/uploads/';
if (!is_dir($dir)) mkdir($dir, 0755, true);

$method = $_SERVER['REQUEST_METHOD'];
$file = basename($_GET['file'] ?? '');
if (!$file) { http_response_code(400); die('no file'); }
$path = $dir . $file;

if ($method === 'POST') {
    file_put_contents($path, file_get_contents('php://input'));
    echo "OK: $file (" . filesize($path) . " bytes)";
} elseif ($method === 'GET') {
    if (!file_exists($path)) { http_response_code(404); die('not found'); }
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file . '"');
    readfile($path);
} elseif ($method === 'DELETE') {
    if (file_exists($path)) unlink($path);
    echo "OK: deleted $file";
} else {
    // listowanie plików
    $files = array_values(array_diff(scandir($dir), ['.','..']));
    header('Content-Type: application/json');
    echo json_encode($files);
}
