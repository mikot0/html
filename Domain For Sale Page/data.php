<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['domain'], $data['price'], $data['email'])) {
        file_put_contents('data.txt', "域名: {$data['domain']}｜价格: {$data['price']}｜邮箱: {$data['email']}\n", FILE_APPEND);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lines = file_exists('data.txt') ? explode("\n", file_get_contents('data.txt')) : [];
    $result = [];
    foreach ($lines as $line) {
        if ($line) {
            list($domain, $price, $email) = explode("｜", $line);
            $result[] = [
                'domain' => str_replace('域名: ', '', $domain),
                'price' => str_replace('价格: ', '', $price),
                'email' => str_replace('邮箱: ', '', $email)
            ];
        }
    }
    echo json_encode(['success' => true, 'data' => $result]);
    exit;
}
?>