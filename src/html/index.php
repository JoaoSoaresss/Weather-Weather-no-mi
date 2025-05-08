<?php
// Example PHP Variables for dynamic content
$city = "Lisbon, Portugal";
$temperature = 24;
$weather_description = "Sunny";
$temperature_max = 26;
$temperature_min = 18;
$humidity = 65;
$wind_speed = 12;
$sunrise = "6:45 AM";
$sunset = "8:30 PM";
$last_updated = "10:30 AM";
$forecast = [
    ['day' => 'Today', 'temp_max' => 24, 'temp_min' => 18, 'icon' => '01d'],
    ['day' => 'Tue', 'temp_max' => 23, 'temp_min' => 17, 'icon' => '02d'],
    ['day' => 'Wed', 'temp_max' => 21, 'temp_min' => 16, 'icon' => '03d'],
    ['day' => 'Thu', 'temp_max' => 19, 'temp_min' => 15, 'icon' => '09d'],
    ['day' => 'Fri', 'temp_max' => 20, 'temp_min' => 16, 'icon' => '10d'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Global Temperature Monitor</title>
  
  <!-- Bootstrap do CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap dos Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/index.css">
</head>
<body class="bg-light">

  <!-- Top Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4 py-3 shadow-sm">
    <div class="container-fluid">
      <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
        <i class="bi bi-list fs-4"></i>
      </button>
      
      <a class="navbar-brand d-flex align-items-center gap-2 fs-4 m-0" href="#">
        <img src="img/logo/logo.png" alt="Logo" style="height: 50px;">
        <span class="d-none d-sm-inline">Weather Weather no Mi</span>
      </a>
      
      <div class="d-flex align-items-center ms-auto">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="locationDropdown" data-bs-toggle="dropdown">
            <i class="bi bi-geo-alt-fill me-1"></i>
            <span class="d-none d-md-inline">My Location</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-compass me-2"></i>Detect Location</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-search me-2"></i>Search City</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-2 p-0">
        <div class="offcanvas offcanvas-start bg-white border-end min-vh-100" tabindex="-1" id="sidebar">
          <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body p-3">
            <div class="nav flex-column gap-2">
              <a href="#" class="nav-link sidebar-item active">
                <i class="bi bi-search me-3 fs-5"></i>
                <span>Search City</span>
              </a>
              
              <a href="comparar.html" class="nav-link sidebar-item">
                <i class="bi bi-graph-up me-3 fs-5"></i>
                <span>Compare Temperatures</span>
              </a>
              
              <a href="paises.html" class="nav-link sidebar-item">
                <i class="bi bi-globe-americas me-3 fs-5"></i>
                <span>Monitored Countries</span>
              </a>
              
              <a href="#" class="nav-link sidebar-item">
                <i class="bi bi-geo-alt me-3 fs-5"></i>
                <span>My Location</span>
              </a>
              
              <a href="admin.html" class="nav-link sidebar-item">
                <i class="bi bi-gear me-3 fs-5"></i>
                <span>Admin Panel</span>
              </a>
              
              <div class="nav-link sidebar-item" id="darkModeToggle">
                <i class="bi bi-moon me-3 fs-5"></i>
                <span>Dark Mode</span>
              </div>
              
              <div class="dropdown">
                <a class="nav-link sidebar-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                  <i class="bi bi-calendar3 me-3 fs-5"></i>
                  <span>Year: 2025</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">2024</a></li>
                  <li><a class="dropdown-item" href="#">2023</a></li>
                  <li><a class="dropdown-item" href="#">2022</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="container">
        <main class="mx-auto p-4" style="max-width: 900px;">
        <!-- Current Weather -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="fw-bold mb-0"><?php echo $city; ?></h2>
              <div class="d-flex align-items-center">
                <span class="badge bg-primary rounded-pill me-2">Updated: <?php echo $last_updated; ?></span>
                <button class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
              </div>
            </div>
            
            <div class="card weather-card shadow-sm border-0">
              <div class="card-body p-4">
                <div class="row align-items-center">
                  <div class="col-md-4 text-center">
                    <div class="display-1 fw-bold text-primary"><?php echo $temperature; ?>°C</div>
                    <div class="fs-5 mb-3"><?php echo $weather_description; ?></div>
                    <img src="https://openweathermap.org/img/wn/<?php echo $forecast[0]['icon']; ?>@4x.png" alt="Weather icon" class="weather-icon">
                  </div>
                  <div class="col-md-8">
                    <div class="row g-3">
                      <div class="col-6 col-md-4">
                        <div class="weather-detail">
                          <i class="bi bi-thermometer-high text-danger"></i>
                          <div>Max: <?php echo $temperature_max; ?>°C</div>
                        </div>
                      </div>
                      <div class="col-6 col-md-4">
                        <div class="weather-detail">
                          <i class="bi bi-thermometer-low text-info"></i>
                          <div>Min: <?php echo $temperature_min; ?>°C</div>
                        </div>
                      </div>
                      <div class="col-6 col-md-4">
                        <div class="weather-detail">
                          <i class="bi bi-droplet text-primary"></i>
                          <div>Humidity: <?php echo $humidity; ?>%</div>
                        </div>
                      </div>
                      <div class="col-6 col-md-4">
                        <div class="weather-detail">
                          <i class="bi bi-wind text-warning"></i>
                          <div>Wind: <?php echo $wind_speed; ?> km/h</div>
                        </div>
                      </div>
                      <div class="col-6 col-md-4">
                        <div class="weather-detail">
                          <i class="bi bi-sunrise text-warning"></i>
                          <div>Sunrise: <?php echo $sunrise; ?></div>
                        </div>
                      </div>
                      <div class="col-6 col-md-4">
                        <div class="weather-detail">
                          <i class="bi bi-sunset text-warning"></i>
                          <div>Sunset: <?php echo $sunset; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Forecast -->
        <div class="row mb-4">
          <div class="col-12">
            <h3 class="fw-bold mb-4">5-Day Forecast</h3>
            <div class="card shadow-sm border-0">
              <div class="card-body p-3">
                <div class="row text-center g-3">
                  <?php foreach ($forecast as $day): ?>
                  <div class="col-6 col-md">
                    <div class="forecast-day">
                      <div class="fw-bold"><?php echo $day['day']; ?></div>
                      <img src="https://openweathermap.org/img/wn/<?php echo $day['icon']; ?>@2x.png" alt="Weather Icon" width="50">
                      <div><?php echo $day['temp_max']; ?>° <span class="text-muted"><?php echo $day['temp_min']; ?>°</span></div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts -->
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body">
                <h3 class="fw-bold mb-4">Temperature Trends</h3>
                <div class="chart-container">
                  <canvas id="temperatureChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body">
                <h3 class="fw-bold mb-4">Humidity & Pressure</h3>
                <div class="chart-container">
                  <canvas id="humidityChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5 text-center text-muted small">
          <p class="mb-1">© 2024 Weather Weather no Mi. All Rights Reserved.</p>
          <p class="mb-0">Data provided by Map and other sources</p>
        </footer>
      </main>
    </div>
    </div>
  </div>
  

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Custom JS -->
  <script src="js/index.js"></script>

</body>
</html>
