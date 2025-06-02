<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$config = parse_ini_file(__DIR__ . '/../config.ini', true);
$host = $config['database']['host'];
$dbname = $config['database']['dbname'];
$username = $config['database']['username'];
$password = $config['database']['password'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['id_capital'], $data['temperatura_maxima'], $data['temperatura_minima'])) {
        throw new Exception('Invalid input data');
    }

    $stmt = $pdo->prepare("
        INSERT INTO registos_temperatura (id_capital, temperatura_maxima, temperatura_minima)
        VALUES (:id_capital, :temp_max, :temp_min)
    ");
    $stmt->execute([
        ':id_capital' => $data['id_capital'],
        ':temp_max' => $data['temperatura_maxima'],
        ':temp_min' => $data['temperatura_minima']
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save temperature: ' . $e->getMessage()]);
}
?>