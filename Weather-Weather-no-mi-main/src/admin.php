<?php
// admin.php
session_start();

// Simula autenticação de administrador
$isAdmin = true;
if (!$isAdmin) {
    die("Acesso negado.");
}

// CONFIGURAÇÕES ATUAIS
const WEATHER_BASE_URL = "https://api.openweathermap.org/data/2.5";
const GEOCODING_BASE_URL = "http://api.openweathermap.org/geo/1.0";
const WEATHERAPI_KEY = "c249b985c680458fb95152511252205";
const WEATHERAPI_BASE_URL = "https://api.weatherapi.com/v1";
const OPENMETEO_BASE_URL = "https://archive-api.open-meteo.com/v1/archive";

// Lê o config.ini para obter os dados da base de dados
$config = parse_ini_file(__DIR__ . '/config.ini', true);
$db = $config['database'];

try {
    $pdo = new PDO(
        "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4",
        $db['user'],
        $db['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbStatus = "<span class='text-success'>Conectado</span>";
} catch (PDOException $e) {
    $dbStatus = "<span class='text-danger'>Erro: " . $e->getMessage() . "</span>";
}

$phpVersion = phpversion();
$sistemaVersao = '1.0.0';
?>


?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Painel Administrativo - Weather Weather no Mi</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link href="css/admin.css" rel="stylesheet" />
  
  
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4 py-3 shadow-sm fixed-top">
    <div class="container-fluid">
      <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
        <i class="bi bi-list fs-4"></i>
      </button>

      <a class="navbar-brand d-flex align-items-center gap-2 fs-4 m-0" href="index.php">
        <img id="logo" src="img/logo/image2vector.svg" alt="Logo" height="50" />
        <span class="d-none d-sm-inline">Weather Weather no Mi</span>
      </a>

      <div class="d-flex align-items-center ms-auto">
        <a href="index.php" class="btn btn-outline-light">
          <i class="bi bi-arrow-left me-1"></i>
          <span class="d-none d-md-inline">Voltar</span>
        </a>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="offcanvas offcanvas-start bg-white border-end min-vh-100" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title fw-bold" id="sidebarLabel">Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body p-3 d-flex flex-column">
      <nav class="nav flex-column gap-2">
        <a href="comparar.html" class="nav-link sidebar-item">
          <i class="bi bi-graph-up me-3 fs-5"></i>
          Compare Temperatures
        </a>
        <a href="admin.php" class="nav-link sidebar-item ativo">
          <i class="bi bi-gear me-3 fs-5"></i>
          Admin Panel
        </a>
        <div class="nav-link sidebar-item" id="darkModeToggle" style="cursor:pointer;">
          <i class="bi bi-moon me-3 fs-5"></i>
          Dark Mode
        </div>
      </nav>
      <hr />
      <div class="list-group flex-grow-1 overflow-auto" id="recent-locations"></div>
    </div>
  </div>
<br>
  <!-- Conteúdo Principal -->
  <main id="content" class="pt-5">
    <div class="container-fluid py-4">
      <!-- Tabs -->
      <ul class="nav nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="true">Fontes de Dados</button>
        </li>


        <li class="nav-item" role="presentation">
          <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Utilizadores</button>
        </li>
      </ul>

      <!-- Conteúdo das tabs -->
      <div class="tab-content mt-4">
        <!-- Fontes de Dados -->
        <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title"><i class="bi bi-link-45deg me-2"></i>APIs e Endpoints</h5>
                    <div id="lista-fontes" class="mt-3"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title"><i class="bi bi-bar-chart me-2"></i>Status do Sistema</h5>
                <div class="card-body">      
                  <ul>
                    <li>Conexão com Base de Dados: <?= $dbStatus ?></li>            
                    <li>Versão do PHP: <?= $phpVersion ?></li>
                    <li>Versão do Sistema: <?= $sistemaVersao ?></li>
                  </ul>
                </div>
              </div>

                </div>
              </div>
            </div>
          </div>
                
        </div>

        <!-- Utilizadores -->
        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
          <div class="card shadow-sm">
            <div class="card-header">Contas de utilizador</div>
            <div class="card-body">
              <div class="d-flex align-items-center">
                <i class="bi bi-person-circle fs-2 me-3 text-primary"></i>
                <div>
                  <h6 class="mb-1">João</h6>
                  <small class="text-muted">Último login: Hoje</small>
                </div>
              </div>
              <br>
               <div class="d-flex align-items-center">
                <i class="bi bi-person-circle fs-2 me-3 text-primary"></i>
                <div>
                  <h6 class="mb-1">Jonnas</h6>
                  <small class="text-muted">Último login: Hoje</small>
                </div>
              </div>
              <br>
               <div class="d-flex align-items-center">
                <i class="bi bi-person-circle fs-2 me-3 text-primary"></i>
                <div>
                  <h6 class="mb-1">Pedro</h6>
                  <small class="text-muted">Último login: Hoje</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </main>

  <!-- Rodapé -->
  <footer class="bg-dark text-white text-center py-3 mt-auto rodape">
    <div class="container">
      <p class="mb-0">Weather Weather no Mi © 2025</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/admin.js"></script>
</body>
</html>
