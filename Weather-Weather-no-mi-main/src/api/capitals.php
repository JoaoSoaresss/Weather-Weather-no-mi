<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Caminho relativo: um diretório acima de /api/
    $config = parse_ini_file(__DIR__ . '/../config.ini', true);

    $host = $config['database']['host'];
    $dbname = $config['database']['dbname'];
    $username = $config['database']['user']; // CORRIGIDO aqui
    $password = $config['database']['password'];

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, nome_pais, nome_capital, latitude, longitude FROM capitais");
    $capitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($capitals);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
