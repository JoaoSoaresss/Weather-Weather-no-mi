<?php
// Load config
$config = parse_ini_file(__DIR__ . '/config.ini', true);
$api_key = $config['api']['openweathermap_key'] ?? '';
if (empty($api_key)) {
    die('Error: OpenWeatherMap API key not found in config.ini. Please create config.ini with [api] openweathermap_key = "16fa71708935f766694b36e5e61e13dc"');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Global Temperature Monitor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="css/index.css"/>
  <script src="js/index.js"></script>
</head>

<body class="bg-light">
  <div class="weather-bg"></div>
  <div class="loading">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-5 py-3 shadow-sm">
    <div class="container-fluid">
      <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
        <i class="bi bi-list fs-4"></i>
      </button>
      <a class="navbar-brand d-flex align-items-center gap-2 fs-4 m-0" href="index.php">
           <img id="logo" src="img/logo/image2vector.svg" alt="Logo" height="50">
        <span class="d-none d-sm-inline">Weather Weather No Mi</span>
      </a>
      <div class="d-flex align-items-center ms-auto">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="locationDropdown" data-bs-toggle="dropdown">
            <i class="bi bi-geo-alt-fill me-1"></i>
            <span class="d-none d-md-inline">My Location</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" id="detectLocation"><i class="bi bi-compass me-2"></i>Detect Location</a></li>
            <li>
              <div class="dropdown-item p-0">
                <div class="search-container p-3">
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-search me-2"></i>
                    <span class="fw-bold">Search City or Country</span>
                  </div>
                  <div class="input-group">
                    <input type="text" id="cityInput" placeholder="e.g. Lisboa or Spain" class="form-control" />
                    <button class="btn btn-primary" id="searchCityBtn">
                      <i class="bi bi-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="col-lg-2 p-0">
    <div class="offcanvas offcanvas-start bg-white border-end min-vh-100" tabindex="-1" id="sidebar">
      <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body p-3">
        <div class="nav flex-column gap-2">
          <a href="comparar.html" class="nav-link sidebar-item">
            <i class="bi bi-graph-up me-3 fs-5"></i>
            <span>Compare Temperatures</span>
          </a>
          <a href="admin.php" class="nav-link sidebar-item">
            <i class="bi bi-gear me-3 fs-5"></i>
            <span>Admin Panel</span>
          </a>
          <div class="nav-link sidebar-item" id="darkModeToggle" style="cursor: pointer;">
            <i class="bi bi-moon me-3 fs-5"></i>
            <span>Dark Mode</span>
          </div>
         
          <br>


          <div class="list-group" id="recent-locations"></div>
          <br>
          <div class="mt-4">
            <h6 class="fw-bold">Settings</h6>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="unitToggle">
              <label class="form-check-label" for="unitToggle">Display in Fahrenheit</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-wrapper">
    <div class="container mt-4">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h4 class="fw-bold mb-3">Select a Country</h4>
          <div id="world-map" style="height: 400px;"></div>
        </div>
      </div>

<!-- LINHA 1: Temperatura Atual + Extremes -->
<div class="row mb-4">
  <!-- Temperatura Atual -->
  <div class="col-lg-6 mb-3">
    <div class="card shadow-sm h-100">
      <div class="card-body text-center">
        <h2 class="fw-bold mb-0" id="city-name">Loading...</h2>
        <p class="text-muted mb-3" id="date-time">--</p>

        <div class="d-flex justify-content-center align-items-center gap-3">
          <img id="weather-icon" class="weather-icon" alt="Weather Icon" />
          <p class="display-1 mb-0" id="temperature">--°C</p>
        </div>

        <p class="fs-4 mb-3" id="weather-condition">--</p>
        <p class="mb-0" id="feels-like">Feels like: --°C</p>
      </div>
    </div>
  </div>

  <!-- Daily + Historical Extremes -->
  <div class="col-lg-6 mb-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <!-- Daily Extremes -->
        <h4 class="fw-bold mb-3">
          <i class="bi bi-thermometer-high me-2 text-danger"></i>
          Daily Extremes
        </h4>
        <p class="d-flex align-items-center mb-2">
          <i class="bi bi-arrow-up-circle-fill fs-5 me-2 text-danger"></i>
          Max: <span id="daily-max" class="ms-2">--</span>
        </p>
        <p class="d-flex align-items-center mb-4">
          <i class="bi bi-arrow-down-circle-fill fs-5 me-2 text-primary"></i>
          Min: <span id="daily-min" class="ms-2">--</span>
        </p>

        <!-- Historical Extremes -->
        <h4 class="fw-bold mb-3">
          <i class="bi bi-clock-history me-2 text-warning"></i>
          Historical Extremes (2000–2025)
        </h4>

        <p id="historical-loading" class="text-muted d-flex align-items-center">
          <i class="bi bi-cloud-arrow-down me-2 text-secondary"></i>
          Buscando dados históricos...
        </p>

        <div id="yearly-max-section" class="d-none">
          <p id="yearly-max-label" class="mb-1 fw-medium d-flex align-items-center">
            <i class="bi bi-thermometer-sun me-2 text-danger"></i> Historical Max
          </p>
          <p class="d-flex align-items-center">
            <i class="bi bi-arrow-up fs-5 me-2 text-danger"></i>
            Max: <span id="yearly-max" class="ms-2">--</span>
          </p>
        </div>

        <div id="yearly-min-section" class="d-none">
          <p id="yearly-min-label" class="mb-1 fw-medium d-flex align-items-center">
            <i class="bi bi-thermometer-snow me-2 text-primary"></i> Historical Min
          </p>
          <p class="d-flex align-items-center">
            <i class="bi bi-arrow-down fs-5 me-2 text-primary"></i>
            Min: <span id="yearly-min" class="ms-2">--</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- LINHA 2: Weather Details em cards menores -->
<div class="row g-3 mb-4">
  <!-- Um card para cada detalhe do tempo -->
  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex align-items-center">
        <i class="bi bi-moisture fs-4 me-3 text-primary"></i>
        <div>
          <p class="mb-0 text-muted">Humidity</p>
          <p class="fw-bold mb-0" id="humidity">--%</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex align-items-center">
        <i class="bi bi-wind fs-4 me-3 text-primary"></i>
        <div>
          <p class="mb-0 text-muted">Wind Speed</p>
          <p class="fw-bold mb-0" id="wind-speed">-- km/h</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex align-items-center">
        <i class="bi bi-thermometer-half fs-4 me-3 text-primary"></i>
        <div>
          <p class="mb-0 text-muted">Pressure</p>
          <p class="fw-bold mb-0" id="pressure">-- hPa</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex align-items-center">
        <i class="bi bi-eye fs-4 me-3 text-primary"></i>
        <div>
          <p class="mb-0 text-muted">Visibility</p>
          <p class="fw-bold mb-0" id="visibility">-- km</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex align-items-center">
        <i class="bi bi-sunrise fs-4 me-3 text-primary"></i>
        <div>
          <p class="mb-0 text-muted">Sunrise</p>
          <p class="fw-bold mb-0" id="sunrise">--:--</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex align-items-center">
        <i class="bi bi-sunset fs-4 me-3 text-primary"></i>
        <div>
          <p class="mb-0 text-muted">Sunset</p>
          <p class="fw-bold mb-0" id="sunset">--:--</p>
        </div>
      </div>
    </div>
  </div>
</div>


      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h4 class="fw-bold mb-3">5-Day Forecast</h4>
          <div class="forecast-container mb-4" id="forecast-cards"></div>
          <div>
            <canvas id="forecast-chart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="bg-dark text-white text-center py-3">
    <div class="container">
      <p class="mb-0">Weather Weather No Mi © 2025 | Powered by OpenWeatherMap</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/string-similarity@4.0.4/umd/string-similarity.min.js"></script>
  <script>
    const API_KEY = "<?php echo htmlspecialchars($api_key); ?>";
    const WEATHER_BASE_URL = "https://api.openweathermap.org/data/2.5";
    const GEOCODING_BASE_URL = "http://api.openweathermap.org/geo/1.0";
    const WEATHERAPI_KEY = "c249b985c680458fb95152511252205";
    const WEATHERAPI_BASE_URL = "https://api.weatherapi.com/v1";
    const OPENMETEO_BASE_URL = "https://archive-api.open-meteo.com/v1/archive";

    let currentUnit = "metric";
    let forecastChart = null;
    let recentLocations = [];
    let selectedCountry = null;
    let geoJsonLayer = null;
    let map = null;
    let capitalsData = [];

    const countryCodeMap = {
      'IT': 'IT', 'FR': 'FR', 'US': 'US', 'GB': 'GB',
      'KP': 'Dem. People\'s Republic of Korea',
      'KR': 'Republic of Korea',
      'CD': 'Democratic Republic of the Congo',
      'CG': 'Congo',
      'BS': 'Bahamas',
      'GM': 'Gambia',
      'ES': 'Spain'
    };

    const loadingIndicator = document.querySelector('.loading');
    const cityNameElement = document.getElementById("city-name");
    const dateTimeElement = document.getElementById("date-time");
    const temperatureElement = document.getElementById("temperature");
    const weatherConditionElement = document.getElementById("weather-condition");
    const weatherIconElement = document.getElementById("weather-icon");
    const feelsLikeElement = document.getElementById("feels-like");
    const humidityElement = document.getElementById("humidity");
    const windSpeedElement = document.getElementById("wind-speed");
    const pressureElement = document.getElementById("pressure");
    const visibilityElement = document.getElementById("visibility");
    const sunriseElement = document.getElementById("sunrise");
    const sunsetElement = document.getElementById("sunset");
    const dailyMaxElement = document.getElementById("daily-max");
    const dailyMinElement = document.getElementById("daily-min");
    const historicalLoading = document.getElementById("historical-loading");
    const yearlyMaxSection = document.getElementById("yearly-max-section");
    const yearlyMinSection = document.getElementById("yearly-min-section");
    const yearlyMaxLabel = document.getElementById("yearly-max-label");
    const yearlyMinLabel = document.getElementById("yearly-min-label");
    const yearlyMaxElement = document.getElementById("yearly-max");
    const yearlyMinElement = document.getElementById("yearly-min");
    const forecastCardsElement = document.getElementById("forecast-cards");
    const weatherBgElement = document.querySelector('.weather-bg');
    const unitToggle = document.getElementById("unitToggle");
    const recentLocationsElement = document.getElementById("recent-locations");

    // Set initial date and time to 04:20 PM WEST, Thursday, May 29, 2025
    const initialDate = new Date('2025-05-29T16:20:00+01:00'); // WEST is UTC+1
    dateTimeElement.textContent = `${initialDate.toLocaleDateString(undefined, {
      weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    })} at ${initialDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', timeZone: 'UTC' })}`;

    async function fetchCapitalsData() {
      try {
        const response = await fetch('./api/capitals.php');
        if (!response.ok) {
          throw new Error(`HTTP error ${response.status}: ${response.statusText}`);
        }
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
          const text = await response.text();
          console.log('Non-JSON response from capitals.php:', text);
          throw new Error('Invalid response: Not JSON');
        }
        capitalsData = await response.json();
        console.log('Capitals data loaded:', capitalsData.length);
        if (!Array.isArray(capitalsData)) {
          throw new Error('Invalid data format: Expected an array');
        }
      } catch (error) {
        console.error('Capitals fetch error:', error.message);
        alert(`Failed to load capitals data: ${error.message}. Using fallback method.`);
      }
    }

    function showLoading() {
      loadingIndicator.style.display = 'flex';
    }

    function hideLoading() {
      loadingIndicator.style.display = 'none';
    }

    function formatTime(timestamp, timezoneOffset) {
      const date = new Date((timestamp + timezoneOffset) * 1000);
      return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', timeZone: 'UTC' });
    }

    function formatDate(timestamp, timezoneOffset) {
      const date = new Date((timestamp + timezoneOffset) * 1000);
      return date.toLocaleDateString(undefined, {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC'
      });
    }

    function formatDay(timestamp, timezoneOffset) {
      const date = new Date((timestamp + timezoneOffset) * 1000);
      return date.toLocaleDateString(undefined, { weekday: 'short', timeZone: 'UTC' });
    }

    function metersToKm(meters) {
      return (meters / 1000).toFixed(1);
    }

    function setWeatherBackground(condition) {
      const conditionMap = {
        clear: '01d',
        clouds: '03d',
        rain: '10d',
        drizzle: '10d',
        thunderstorm: '11d',
        snow: '13d',
        mist: '50d',
        fog: '50d',
        haze: '50d'
      };
      const code = conditionMap[condition.toLowerCase()] || '02d';
      weatherBgElement.style.backgroundImage = `url(https://openweathermap.org/img/wn/${code}@2x.png)`;
    }

    function updateRecentLocations(data, displayName, countryCode) {
      const existingIndex = recentLocations.findIndex(loc => loc.id === data.id);
      if (existingIndex !== -1) {
        recentLocations.splice(existingIndex, 1);
      }
      recentLocations.unshift({ id: data.id, name: displayName, countryCode });
      if (recentLocations.length > 5) {
        recentLocations.pop();
      }
      localStorage.setItem('recentLocations', JSON.stringify(recentLocations));
      renderRecentLocations();
    }

    function renderRecentLocations() {
      recentLocationsElement.innerHTML = '';
      recentLocations.forEach(location => {
        const locationEl = document.createElement('a');
        locationEl.href = '#';
        locationEl.classList.add('list-group-item', 'list-group-item-action');
        locationEl.textContent = location.name;
        locationEl.addEventListener('click', () => {
          selectedCountry = location.countryCode;
          updateMapHighlight();
          const cityName = location.name.split(',')[0].trim();
          fetchWeatherByCity(cityName, true);
          const sidebar = document.getElementById('sidebar');
          const bsOffcanvas = bootstrap.Offcanvas.getInstance(sidebar);
          if (bsOffcanvas) bsOffcanvas.hide();
        });
        recentLocationsElement.appendChild(locationEl);
      });
    }

    function normalizeCountryName(geoJsonName) {
      const nameMap = {
        "Korea, South": "Republic of Korea",
        "Korea, North": "Dem. People's Republic of Korea",
        "Congo, Democratic Republic of the": "Democratic Republic of the Congo",
        "Congo, Republic of the": "Congo",
        "Bahamas, The": "Bahamas",
        "Gambia, The": "Gambia",
        "United States of America": "United States",
        "Timor-Leste": "Timor-Leste",
        "Brunei Darussalam": "Brunei",
        "Holy See (Vatican City State)": "Holy See",
        "Russia": "Russian Federation",
        "Spain": "Spain"
      };
      return nameMap[geoJsonName] || geoJsonName;
    }

    function findBestMatchCountry(geoJsonName) {
      const normalizedGeoJsonName = normalizeCountryName(geoJsonName);
      const names = capitalsData.map(c => c.nome_pais);
      const { bestMatch } = stringSimilarity.findBestMatch(normalizedGeoJsonName, names);
      if (bestMatch.rating > 0.7) {
        return capitalsData.find(c => c.nome_pais === bestMatch.target);
      }
      return null;
    }

    async function getCityFromCoords(lat, lon) {
      try {
        const response = await fetch(`${GEOCODING_BASE_URL}/reverse?lat=${lat}&lon=${lon}&limit=1&appid=${API_KEY}`);
        if (!response.ok) {
          throw new Error('Unable to fetch city from coordinates');
        }
        const data = await response.json();
        if (data && data.length > 0) {
          const { name, country } = data[0];
          return { name, country: countryCodeMap[country] || country };
        }
        return null;
      } catch (error) {
        console.error('Reverse geocoding error:', error);
        return null;
      }
    }

    async function fetchWeatherByCoords(lat, lon, displayName, countryCode = null, fetchHistorical = false) {
      try {
        showLoading();
        let effectiveDisplayName = displayName;
        let effectiveCountryCode = countryCode;
        if (displayName === "Current Location") {
          const locationData = await getCityFromCoords(lat, lon);
          if (locationData) {
            effectiveDisplayName = `${locationData.name}, ${locationData.country}`;
            effectiveCountryCode = locationData.country;
          } else {
            effectiveDisplayName = "Current Location";
          }
        }

        const response = await fetch(`${WEATHER_BASE_URL}/weather?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=${currentUnit}`);
        if (!response.ok) {
          throw new Error('Unable to fetch weather data');
        }
        const data = await response.json();

        effectiveCountryCode = effectiveCountryCode || data.sys.country;
        if (!effectiveCountryCode && displayName === "Current Location") {
          const geoResponse = await fetch(`${GEOCODING_BASE_URL}/reverse?lat=${lat}&lon=${lon}&limit=1&appid=${API_KEY}`);
          if (geoResponse.ok) {
            const geoData = await geoResponse.json();
            if (geoData.length > 0) {
              effectiveCountryCode = geoData[0].country;
            }
          }
        }
        effectiveCountryCode = countryCodeMap[effectiveCountryCode] || effectiveCountryCode;
        selectedCountry = effectiveCountryCode;
        updateMapHighlight();
        updateUI(data, effectiveDisplayName);
        await fetchForecastAndExtremes(lat, lon, effectiveDisplayName.split(',')[0].trim(), fetchHistorical);
        updateRecentLocations(data, effectiveDisplayName, selectedCountry);

        const capital = capitalsData.find(c => 
          c.nome_capital === effectiveDisplayName.split(',')[0].trim() || 
          (Math.abs(parseFloat(c.latitude) - lat) < 0.1 && Math.abs(parseFloat(c.longitude) - lon) < 0.1)
        );
        if (capital) {
          const saveResponse = await fetch('api/save_temperature.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              id_capital: capital.id,
              temperatura_maxima: data.main.temp_max,
              temperatura_minima: data.main.temp_min
            })
          });
          if (!saveResponse.ok) {
            console.error('Failed to save temperature:', await saveResponse.text());
          }
          if (fetchHistorical) {
            localStorage.removeItem(`historical_${effectiveDisplayName.split(',')[0].trim()}_${lat}_${lon}_${currentUnit}`);
            await fetchHistoricalExtremes(effectiveDisplayName.split(',')[0].trim(), lat, lon);
          }
        }
      } catch (error) {
        console.error('Weather fetch error:', error);
        alert(`Error: ${error.message}`);
      } finally {
        hideLoading();
      }
    }

    async function fetchWeatherByCity(city, fetchHistorical = false) {
      try {
        showLoading();
        const normalizedInput = city.trim().toLowerCase();
        let countryCode = null;

        const matchedCapital = capitalsData.find(c => 
          c.nome_capital.toLowerCase() === normalizedInput || 
          c.nome_pais.toLowerCase() === normalizedInput || 
          normalizeCountryName(c.nome_pais).toLowerCase().includes(normalizedInput) || 
          c.nome_capital.toLowerCase().includes(normalizedInput)
        );

        if (matchedCapital) {
          const { nome_capital, latitude, longitude, nome_pais } = matchedCapital;
          await fetchWeatherByCoords(latitude, longitude, `${nome_capital}, ${nome_pais}`, nome_pais, fetchHistorical);
          return;
        }

        if (normalizedInput === "espanha" || normalizedInput === "spain") {
          const matchedCapital = capitalsData.find(c => c.nome_pais.toLowerCase() === "spain");
          if (matchedCapital) {
            const { nome_capital, latitude, longitude, nome_pais } = matchedCapital;
            await fetchWeatherByCoords(latitude, longitude, `${nome_capital}, ${nome_pais}`, "ES", fetchHistorical);
            return;
          }
          countryCode = "ES";
        }

        const query = countryCode ? `${encodeURIComponent(city)},${countryCode}` : encodeURIComponent(city);
        const geoResponse = await fetch(`${GEOCODING_BASE_URL}/direct?q=${query}&limit=1&appid=${API_KEY}`);
        if (!geoResponse.ok) {
          throw new Error('Unable to fetch city coordinates');
        }
        const geoData = await geoResponse.json();
        if (!geoData || geoData.length === 0) {
          throw new Error(`City or country "${city}" not found. Please try another name or check the spelling.`);
        }
        const { lat, lon, name, country } = geoData[0];
        const displayName = `${name}, ${country}`;
        const response = await fetch(`${WEATHER_BASE_URL}/weather?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=${currentUnit}`);
        if (!response.ok) {
          throw new Error('Unable to fetch weather data');
        }
        const data = await response.json();
        selectedCountry = countryCodeMap[country] || country;
        updateMapHighlight();
        updateUI(data, displayName);
        await fetchForecastAndExtremes(lat, lon, name, fetchHistorical);
        updateRecentLocations(data, displayName, selectedCountry);

        const capital = capitalsData.find(c => 
          c.nome_capital === name || 
          (Math.abs(parseFloat(c.latitude) - lat) < 0.1 && Math.abs(parseFloat(c.longitude) - lon) < 0.1)
        );
        if (capital) {
          const saveResponse = await fetch('api/save_temperature.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              id_capital: capital.id,
              temperatura_maxima: data.main.temp_max,
              temperatura_minima: data.main.temp_min
            })
          });
          if (!saveResponse.ok) {
            console.error('Failed to save temperature:', await saveResponse.text());
          }
          if (fetchHistorical) {
            localStorage.removeItem(`historical_${name}_${lat}_${lon}_${currentUnit}`);
            await fetchHistoricalExtremes(name, lat, lon);
          }
        }
      } catch (error) {
        console.error('City weather fetch error:', error);
        alert(`Error: ${error.message}`);
      } finally {
        hideLoading();
      }
    }

    async function fetchDailyExtremes(city, lat, lon) {
      const unitSymbol = currentUnit === 'metric' ? '°C' : '°F';
      if (!WEATHERAPI_KEY) {
        console.error('WeatherAPI key is missing.');
        dailyMaxElement.textContent = `--${unitSymbol}`;
        dailyMinElement.textContent = `--${unitSymbol}`;
        return;
      }

      try {
        const response = await fetch(`${WEATHERAPI_BASE_URL}/forecast.json?key=${WEATHERAPI_KEY}&q=${city}&days=1`);
        if (!response.ok) {
          throw new Error(`WeatherAPI failed: ${response.status} ${response.statusText}`);
        }
        const data = await response.json();
        if (!data.forecast?.forecastday?.[0]?.day) {
          throw new Error('No daily forecast data available');
        }

        const day = data.forecast.forecastday[0].day;
        const maxTemp = currentUnit === 'metric' ? day.maxtemp_c : day.maxtemp_f;
        const minTemp = currentUnit === 'metric' ? day.mintemp_c : day.mintemp_f;

        dailyMaxElement.textContent = `${Math.round(maxTemp)}${unitSymbol}`;
        dailyMinElement.textContent = `${Math.round(minTemp)}${unitSymbol}`;
      } catch (error) {
        console.error(`Error fetching daily extremes for ${city}:`, error);
        dailyMaxElement.textContent = `--${unitSymbol}`;
        dailyMinElement.textContent = `--${unitSymbol}`;
      }
    }

    async function fetchHistoricalExtremes(city, lat, lon) {
      const unitSymbol = currentUnit === 'metric' ? '°C' : '°F';
      const tempVariable = 'temperature_2m_max,temperature_2m_min';

      historicalLoading.style.display = 'block';
      yearlyMaxSection.classList.add('d-none');
      yearlyMinSection.classList.add('d-none');

      // Retry logic with exponential backoff
      async function fetchWithRetry(url, retries = 3, delay = 5000) {
        for (let i = 0; i < retries; i++) {
          try {
            const response = await fetch(url);
            if (response.status === 429) {
              console.warn(`Rate limit hit (attempt ${i + 1}/${retries}), waiting ${delay / 1000} seconds...`);
              await new Promise(resolve => setTimeout(resolve, delay));
              delay *= 2; // Exponential backoff
              continue;
            }
            if (!response.ok) {
              throw new Error(`HTTP error ${response.status}: ${response.statusText}`);
            }
            return await response.json();
          } catch (err) {
            if (i === retries - 1) throw err;
            console.warn(`Fetch error (attempt ${i + 1}/${retries}): ${err.message}. Retrying...`);
            await new Promise(resolve => setTimeout(resolve, delay));
            delay *= 2;
          }
        }
      }

      try {
        let allTimeMax = -Infinity;
        let allTimeMin = Infinity;
        let maxYear = null;
        let minYear = null;

        // Batch requests into larger year ranges to reduce API calls
        const yearRanges = [
          { start: 2000, end: 2014 },
          { start: 2015, end: 2024 }
        ];

        for (const range of yearRanges) {
          const url = `${OPENMETEO_BASE_URL}?latitude=${lat}&longitude=${lon}&start_date=${range.start}-01-01&end_date=${range.end}-12-31&daily=${tempVariable}&timezone=auto`;
          console.log(`Fetching Open-Meteo data for ${city} from ${range.start} to ${range.end}...`);
          let data;
          try {
            data = await fetchWithRetry(url);
          } catch (err) {
            console.warn(`Failed to fetch data for ${city} from ${range.start}-${range.end}: ${err.message}`);
            continue;
          }

          if (!data.daily || !data.daily.temperature_2m_max || data.daily.temperature_2m_max.length < 100) {
            console.warn(`Insufficient data for ${city} in ${range.start}-${range.end}: ${data.daily?.temperature_2m_max?.length || 0} days`);
            continue;
          }

          const maxTemp = Math.max(...data.daily.temperature_2m_max.filter(val => val !== null && !isNaN(val)));
          const minTemp = Math.min(...data.daily.temperature_2m_min.filter(val => val !== null && !isNaN(val)));
          if (maxTemp === -Infinity || minTemp === Infinity) {
            console.warn(`No valid temperature data for ${city} in ${range.start}-${range.end}`);
            continue;
          }

          const maxIndex = data.daily.temperature_2m_max.indexOf(maxTemp);
          const minIndex = data.daily.temperature_2m_min.indexOf(minTemp);
          const maxDate = new Date(data.daily.time[maxIndex]);
          const minDate = new Date(data.daily.time[minIndex]);

          if (maxTemp > allTimeMax) {
            allTimeMax = maxTemp;
            maxYear = maxDate.getFullYear();
          }
          if (minTemp < allTimeMin) {
            allTimeMin = minTemp;
            minYear = minDate.getFullYear();
          }
        }

        // Fetch 2025 data separately
        const url2025 = `${OPENMETEO_BASE_URL}?latitude=${lat}&longitude=${lon}&start_date=2025-01-01&end_date=2025-05-24&daily=${tempVariable}&timezone=auto`;
        console.log(`Fetching Open-Meteo data for ${city} for 2025 (up to 2025-05-24)...`);
        let data2025;
        try {
          data2025 = await fetchWithRetry(url2025);
          if (data2025.daily && data2025.daily.temperature_2m_max && data2025.daily.temperature_2m_max.length > 0) {
            const maxTemp = Math.max(...data2025.daily.temperature_2m_max.filter(val => val !== null && !isNaN(val)));
            const minTemp = Math.min(...data2025.daily.temperature_2m_min.filter(val => val !== null && !isNaN(val)));
            if (maxTemp !== -Infinity) {
              const maxIndex = data2025.daily.temperature_2m_max.indexOf(maxTemp);
              const maxDate = new Date(data2025.daily.time[maxIndex]);
              if (maxTemp > allTimeMax) {
                allTimeMax = maxTemp;
                maxYear = maxDate.getFullYear();
              }
            }
            if (minTemp !== Infinity) {
              const minIndex = data2025.daily.temperature_2m_min.indexOf(minTemp);
              const minDate = new Date(data2025.daily.time[minIndex]);
              if (minTemp < allTimeMin) {
                allTimeMin = minTemp;
                minYear = minDate.getFullYear();
              }
            }
          }
        } catch (error) {
          console.warn(`Error fetching 2025 data for ${city}:`, error);
        }

        if (allTimeMax === -Infinity || allTimeMin === Infinity) {
          throw new Error('No valid historical data found for this location');
        }

        const displayMax = currentUnit === 'metric' ? allTimeMax : (allTimeMax * 9/5) + 32;
        const displayMin = currentUnit === 'metric' ? allTimeMin : (allTimeMin * 9/5) + 32;

        localStorage.setItem(`historical_${city}_${lat}_${lon}_${currentUnit}`, JSON.stringify({
          allTimeMax: displayMax,
          allTimeMin: displayMin,
          maxYear,
          minYear
        }));

        historicalLoading.style.display = 'none';
        yearlyMaxSection.classList.remove('d-none');
        yearlyMinSection.classList.remove('d-none');
        yearlyMaxLabel.textContent = `Historical Max (${maxYear || 'Unknown'})`;
        yearlyMinLabel.textContent = `Historical Min (${minYear || 'Unknown'})`;
        yearlyMaxElement.textContent = `${Math.round(displayMax)}${unitSymbol}`;
        yearlyMinElement.textContent = `${Math.round(displayMin)}${unitSymbol}`;
      } catch (error) {
        console.error(`Error fetching historical data for ${city}:`, error);
        historicalLoading.style.display = 'none';
        yearlyMaxSection.classList.remove('d-none');
        yearlyMinSection.classList.remove('d-none');
        yearlyMaxLabel.textContent = 'Historical Max';
        yearlyMinLabel.textContent = 'Historical Min';
        yearlyMaxElement.textContent = `N/A${unitSymbol}`;
        yearlyMinElement.textContent = `N/A${unitSymbol}`;
      }
    }

    async function fetchForecastAndExtremes(lat, lon, city, fetchHistorical) {
      const unitSymbol = currentUnit === 'metric' ? '°C' : '°F';
      try {
        const response = await fetch(`${WEATHER_BASE_URL}/forecast?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=${currentUnit}`);
        if (!response.ok) {
          throw new Error('Unable to fetch forecast data');
        }
        const data = await response.json();
        updateForecastUI(data);

        await fetchDailyExtremes(city, lat, lon);
        if (fetchHistorical) {
          localStorage.removeItem(`historical_${city}_${lat}_${lon}_${currentUnit}`);
          await fetchHistoricalExtremes(city, lat, lon);
        }
      } catch (error) {
        console.error('Forecast fetch error:', error);
        dailyMaxElement.textContent = `--${unitSymbol}`;
        dailyMinElement.textContent = `--${unitSymbol}`;
        forecastCardsElement.innerHTML = '<p class="text-muted">Unable to load forecast data.</p>';
      }
    }

    function updateUI(data, displayName) {
      const unitSymbol = currentUnit === 'metric' ? '°C' : '°F';
      const speedUnit = currentUnit === 'metric' ? 'km/h' : 'mph';
      const timezoneOffset = data.timezone;
      cityNameElement.textContent = displayName;
      dateTimeElement.textContent = `${formatDate(data.dt, timezoneOffset)} at ${formatTime(data.dt, timezoneOffset)}`;
      temperatureElement.textContent = `${Math.round(data.main.temp)}${unitSymbol}`;
      weatherConditionElement.textContent = data.weather[0].description;
      weatherIconElement.src = `https://openweathermap.org/img/wn/${data.weather[0].icon}@4x.png`;
      feelsLikeElement.textContent = `Feels like: ${Math.round(data.main.feels_like)}${unitSymbol}`;
      humidityElement.textContent = `${data.main.humidity}%`;
      const windSpeed = currentUnit === 'metric' ? (data.wind.speed * 3.6).toFixed(1) : data.wind.speed.toFixed(1);
      windSpeedElement.textContent = `${windSpeed} ${speedUnit}`;
      pressureElement.textContent = `${data.main.pressure} hPa`;
      visibilityElement.textContent = `${metersToKm(data.visibility)} km`;
      sunriseElement.textContent = formatTime(data.sys.sunrise, timezoneOffset);
      sunsetElement.textContent = formatTime(data.sys.sunset, timezoneOffset);
      setWeatherBackground(data.weather[0].main);
      document.title = `${Math.round(data.main.temp)}${unitSymbol} - ${displayName} | Weather Weather No Mi`;
    }

    function updateForecastUI(data) {
      const unitSymbol = currentUnit === 'metric' ? '°C' : '°F';
      const timezoneOffset = data.city.timezone;
      forecastCardsElement.innerHTML = '';
      const dailyForecasts = [];
      const days = {};
      data.list.forEach(forecast => {
        const dateKey = new Date(forecast.dt * 1000).toDateString();
        if (!days[dateKey]) {
          days[dateKey] = [];
        }
        days[dateKey].push(forecast);
      });
      Object.keys(days).forEach(day => {
        const forecasts = days[day];
        let noonForecast = forecasts.reduce((prev, curr) => {
          const prevHour = new Date(prev.dt * 1000).getHours();
          const currHour = new Date(curr.dt * 1000).getHours();
          return Math.abs(currHour - 12) < Math.abs(prevHour - 12) ? curr : prev;
        });
        dailyForecasts.push(noonForecast);
      });
      const limitedForecasts = dailyForecasts.slice(0, 5);
      limitedForecasts.forEach(forecast => {
        const card = document.createElement('div');
        card.className = 'forecast-day bg-white rounded shadow-sm weather-card';
        const day = document.createElement('p');
        day.className = 'mb-2 fw-bold';
        day.textContent = formatDay(forecast.dt, timezoneOffset);
        const icon = document.createElement('img');
        icon.src = `https://openweathermap.org/img/wn/${forecast.weather[0].icon}.png`;
        icon.alt = forecast.weather[0].description;
        icon.className = 'mb-2';
        icon.style.width = '60px';
        icon.style.height = '60px';
        const temp = document.createElement('p');
        temp.className = 'mb-0 fs-5 fw-bold';
        temp.textContent = `${Math.round(forecast.main.temp)}${unitSymbol}`;
        const desc = document.createElement('p');
        desc.className = 'mb-0 small text-muted';
        desc.textContent = forecast.weather[0].description;
        card.appendChild(day);
        card.appendChild(icon);
        card.appendChild(temp);
        card.appendChild(desc);
        forecastCardsElement.appendChild(card);
      });
      updateForecastChart(limitedForecasts, timezoneOffset);
    }

    function updateForecastChart(forecasts, timezoneOffset) {
      const unitSymbol = currentUnit === 'metric' ? '°C' : '°F';
      const labels = forecasts.map(forecast => formatDay(forecast.dt, timezoneOffset));
      const temps = forecasts.map(forecast => Math.round(forecast.main.temp));
      const feelsLike = forecasts.map(forecast => Math.round(forecast.main.feels_like));
      const ctx = document.getElementById('forecast-chart').getContext('2d');
      if (forecastChart) {
        forecastChart.destroy();
      }
      forecastChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [
            {
              label: `Temperature (${unitSymbol})`,
              data: temps,
              borderColor: 'rgb(255, 99, 132)',
              backgroundColor: 'rgba(255, 99, 132, 0.5)',
              tension: 0.1,
              borderWidth: 2
            },
            {
              label: `Feels Like (${unitSymbol})`,
              data: feelsLike,
              borderColor: 'rgb(54, 162, 235)',
              backgroundColor: 'rgba(54, 162, 235, 0.5)',
              tension: 0.1,
              borderWidth: 2
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'top' },
            tooltip: { mode: 'index', intersect: false }
          },
          scales: { y: { beginAtZero: false } }
        }
      });
    }

    function toggleUnit() {
      currentUnit = currentUnit === 'metric' ? 'imperial' : 'metric';
      const displayName = cityNameElement.textContent.trim();
      if (displayName !== 'Loading...') {
        const cityName = displayName.split(',')[0].trim();
        fetchWeatherByCity(cityName, true);
      }
    }

    function calculateCentroid(feature) {
      let latSum = 0, lonSum = 0, pointCount = 0;
      const coordinates = feature.geometry.type === 'Polygon'
        ? feature.geometry.coordinates[0]
        : feature.geometry.coordinates[0][0];
      coordinates.forEach(coord => {
        lonSum += coord[0];
        latSum += coord[1];
        pointCount++;
      });
      return { lat: latSum / pointCount, lon: lonSum / pointCount };
    }

    function updateMapHighlight() {
      if (geoJsonLayer) {
        geoJsonLayer.setStyle((feature) => {
          const isoCode = feature.properties.ISO_A2 || '';
          return {
            weight: isoCode === selectedCountry ? 2 : 1,
            opacity: 1,
            color: isoCode === selectedCountry ? '#000000' : '#3388ff',
            fillOpacity: isoCode === selectedCountry ? 0.5 : 0.2,
            fillColor: isoCode === selectedCountry ? '#ff5733' : '#3388ff'
          };
        });
      }
    }

    function initWorldMap() {
      map = L.map('world-map').setView([20, 0], 2);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      fetch('https://raw.githubusercontent.com/nvkelso/natural-earth-vector/master/geojson/ne_110m_admin_0_countries.geojson')
        .then(response => response.json())
        .then(geojson => {
          geoJsonLayer = L.geoJSON(geojson, {
            style: (feature) => ({
              weight: (feature.properties.ISO_A2 || '') === selectedCountry ? 2 : 1,
              opacity: 1,
              color: (feature.properties.ISO_A2 || '') === selectedCountry ? '#000000' : '#3388ff',
              fillOpacity: (feature.properties.ISO_A2 || '') === selectedCountry ? 0.5 : 0.2,
              fillColor: (feature.properties.ISO_A2 || '') === selectedCountry ? '#ff5733' : '#3388ff'
            }),
            onEachFeature: (feature, layer) => {
              layer.on({
                mouseover: (e) => {
                  if ((feature.properties.ISO_A2 || '') !== selectedCountry) {
                    e.target.setStyle({
                      fillOpacity: 0.5,
                      fillColor: '#ff5733'
                    });
                  }
                },
                mouseout: (e) => {
                  if ((feature.properties.ISO_A2 || '') !== selectedCountry) {
                    e.target.setStyle({
                      fillOpacity: 0.2,
                      fillColor: '#3388ff'
                    });
                  }
                },
                click: (e) => {
                  const countryCode = feature.properties.ISO_A2 || '';
                  const countryName = normalizeCountryName(feature.properties.NAME);
                  const capital = findBestMatchCountry(countryName);
                  if (capital) {
                    selectedCountry = countryCodeMap[countryCode] || countryCode;
                    updateMapHighlight();
                    fetchWeatherByCoords(capital.latitude, capital.longitude, `${capital.nome_capital}, ${capital.nome_pais}`, selectedCountry, true);
                    const zoomLevel = ['VA', 'MC', 'SM'].includes(countryCode) ? 10 : 4;
                    map.flyTo([capital.latitude, capital.longitude], zoomLevel);
                  } else {
                    console.warn(`No capital found for ${countryName} (ISO_A2: ${countryCode})`);
                    const centroid = calculateCentroid(feature);
                    selectedCountry = countryCodeMap[countryCode] || countryCode;
                    updateMapHighlight();
                    fetchWeatherByCoords(centroid.lat, centroid.lon, countryName, selectedCountry, true);
                    map.flyTo([centroid.lat, centroid.lon], 4);
                  }
                }
              });
              layer.bindTooltip(feature.properties.NAME, {
                permanent: false,
                direction: 'center',
                className: 'country-tooltip'
              });
            }
          }).addTo(map);
        })
        .catch(error => {
          console.error('GeoJSON load error:', error);
          alert('Failed to load map data. Please try again later.');
        });
    }

    document.addEventListener('DOMContentLoaded', async () => {
      console.log('DOM loaded, starting initialization...');
      await fetchCapitalsData();
      const savedLocations = localStorage.getItem('recentLocations');
      if (savedLocations) {
        recentLocations = JSON.parse(savedLocations);
        renderRecentLocations();
      }
      document.getElementById("detectLocation").addEventListener("click", () => {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            fetchWeatherByCoords(position.coords.latitude, position.coords.longitude, "Current Location", null, true);
          },
          () => {
            alert("Could not get your location. Please allow location access or search for a city manually.");
          }
        );
      });
      document.getElementById("searchCityBtn").addEventListener("click", () => {
        const city = document.getElementById("cityInput").value.trim();
        if (city) {
          fetchWeatherByCity(city, true);
        } else {
          alert("Please enter a city or country name.");
        }
      });
      document.getElementById("cityInput").addEventListener("keypress", (event) => {
        if (event.key === "Enter") {
          const city = document.getElementById("cityInput").value.trim();
          if (city) {
            fetchWeatherByCity(city, true);
          }
        }
      });
      unitToggle.addEventListener('change', toggleUnit);
      initWorldMap();
      fetchWeatherByCity("Lisboa", true); // Initial load for Lisboa
    });
  </script>
</body>
</html>