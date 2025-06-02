<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Lê o ficheiro de configuração
    $config = parse_ini_file(__DIR__ . '/../config.ini', true);
    
    if (!$config || !isset($config['database'])) {
        throw new Exception("Erro ao carregar ou interpretar config.ini.");
    }

    $db = $config['database'];

    // Verifica se todos os campos existem
    foreach (['host', 'user', 'password', 'dbname'] as $key) {
        if (!isset($db[$key])) {
            throw new Exception("Campo '$key' em falta no ficheiro config.ini.");
        }
    }

    $host = $db['host'];
    $dbname = $db['dbname'];
    $username = $db['user'];        // <- corrigido de 'username' para 'user'
    $password = $db['password'];

    // Ligação à base de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query e resultado
    $stmt = $pdo->query("SELECT id, nome_pais, nome_capital, latitude, longitude FROM capitais");
    $capitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($capitals);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
