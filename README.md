How to use it(this is one side client) repo contains two side client for Termux and Userland(bi5h Android Apps need to get python or python3 directly installed 


<?php
$secret = 'yourown_secret_key_here';
if (($_GET['key'] ?? '') !== $secret) { http_response_code(403); die('forbidden'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $path = basename($_GET['file'] ?? 'upload.bin');
    $dir = __DIR__ . '/uploads/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    file_put_contents($dir . $path, file_get_contents('php://input'));
    echo "OK: $path";
} else {
    echo "ready";
}
---

# test połączenia:
curl https://killaseo.pl/upload.php?key=yourown_secret_key_here

# wysyłanie pliku:
curl -X POST \
  "https://killaseo.pl/upload.php?key=yourown_secret_key_here&file=test.txt" \
  --data-binary @/jakis/plik.txt

---
  echo "test z userland $(date)" > /tmp/test.txt
curl -X POST \
  "https://killaseo.pl/upload.php?key=yourown_secret_key_herefile=test.txt" \
  --data-binary @/tmp/test.txt
