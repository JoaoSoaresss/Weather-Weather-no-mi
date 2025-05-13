// Dark Mode 
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    
    // Change the icon
    const icon = document.querySelector('#darkModeToggle i');
    if (document.body.classList.contains('dark-mode')) {
      icon.classList.remove('bi-moon');
      icon.classList.add('bi-sun');
      localStorage.setItem('darkMode', 'enabled');
      
      // Fix for forecast cards - force reapply styles
      const forecastCards = document.querySelectorAll('.forecast-day');
      forecastCards.forEach(card => {
        card.style.background = '#16213e';
        card.style.color = '#e6e6e6';
      });
    } else {
      icon.classList.remove('bi-sun');
      icon.classList.add('bi-moon');
      localStorage.setItem('darkMode', 'disabled');
      
      // Reset forecast cards in light mode
      const forecastCards = document.querySelectorAll('.forecast-day');
      forecastCards.forEach(card => {
        card.style.background = '';
        card.style.color = '';
      });
    }
    
    // Update chart theme if it exists
    if (forecastChart) {
      updateChartTheme();
    }
  }
  
  // Update Chart Theme for Dark/Light Mode
  function updateChartTheme() {
    const isDarkMode = document.body.classList.contains('dark-mode');
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    const tickColor = isDarkMode ? '#e6e6e6' : '#666';
    const textColor = isDarkMode ? '#e6e6e6' : '#666';
    
    if (forecastChart) {
      // Update all chart theme properties
      forecastChart.options.scales.x.grid.color = gridColor;
      forecastChart.options.scales.y.grid.color = gridColor;
      forecastChart.options.scales.x.ticks.color = tickColor;
      forecastChart.options.scales.y.ticks.color = tickColor;
      forecastChart.options.plugins.legend.labels.color = textColor;
      forecastChart.options.plugins.tooltip.backgroundColor = isDarkMode ? '#16213e' : '#fff';
      forecastChart.options.plugins.tooltip.titleColor = isDarkMode ? '#e6e6e6' : '#000';
      forecastChart.options.plugins.tooltip.bodyColor = isDarkMode ? '#e6e6e6' : '#000';
      forecastChart.options.color = textColor;
      
      // Apply changes
      forecastChart.update();
    }
  }
  
  // Check for Dark Mode Preference in LocalStorage
  function checkDarkModePreference() {
    const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';
    if (darkModeEnabled) {
      document.body.classList.add('dark-mode');
      const icon = document.querySelector('#darkModeToggle i');
      icon.classList.remove('bi-moon');
      icon.classList.add('bi-sun');
      
      // Fix for forecast cards when page loads in dark mode
      setTimeout(() => {
        const forecastCards = document.querySelectorAll('.forecast-day');
        forecastCards.forEach(card => {
          card.style.background = '#16213e';
          card.style.color = '#e6e6e6';
        });
      }, 500);
    }
  }
  
  // Update Chart Config to Support Dark Mode
  function createForecastChart(ctx, labels, temps, feelsLike) {
    const isDarkMode = document.body.classList.contains('dark-mode');
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    const tickColor = isDarkMode ? '#e6e6e6' : '#666';
    const textColor = isDarkMode ? '#e6e6e6' : '#666';
    
    if (forecastChart) {
      forecastChart.destroy();
    }
    
    forecastChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: `Temperature (${currentUnit === 'metric' ? '°C' : '°F'})`,
            data: temps,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            tension: 0.1,
            borderWidth: 2
          },
          {
            label: `Feels Like (${currentUnit === 'metric' ? '°C' : '°F'})`,
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
        color: textColor,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              color: textColor
            }
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            backgroundColor: isDarkMode ? '#16213e' : '#fff',
            titleColor: isDarkMode ? '#e6e6e6' : '#000',
            bodyColor: isDarkMode ? '#e6e6e6' : '#000'
          }
        },
        scales: {
          x: {
            grid: {
              color: gridColor
            },
            ticks: {
              color: tickColor
            }
          },
          y: {
            beginAtZero: false,
            grid: {
              color: gridColor
            },
            ticks: {
              color: tickColor
            }
          }
        }
      }
    });
    
    return forecastChart;
  }
  
  // Place this in your document ready function
  document.addEventListener('DOMContentLoaded', () => {
    // Add event listener for dark mode toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
      darkModeToggle.addEventListener('click', toggleDarkMode);
    }
    
    // Check for dark mode preference
    checkDarkModePreference();
    
    // Apply additional styling fixes when forecast cards are added to DOM
    // This ensures the forecast cards are styled correctly when they're dynamically added
    const observer = new MutationObserver((mutations) => {
      if (document.body.classList.contains('dark-mode')) {
        mutations.forEach(mutation => {
          if (mutation.addedNodes.length) {
            const forecastCards = document.querySelectorAll('.forecast-day');
            forecastCards.forEach(card => {
              card.style.background = '#16213e';
              card.style.color = '#e6e6e6';
            });
          }
        });
      }
    });
    
    // Start observing the forecast-cards container
    const forecastCardsContainer = document.getElementById('forecast-cards');
    if (forecastCardsContainer) {
      observer.observe(forecastCardsContainer, { childList: true, subtree: true });
    }
  });
  
  // Update your updateForecastChart function with this:
  function updateForecastChart(forecasts) {
    const labels = forecasts.map(forecast => formatDay(forecast.dt));
    const temps = forecasts.map(forecast => Math.round(forecast.main.temp));
    const feelsLike = forecasts.map(forecast => Math.round(forecast.main.feels_like));
    
    const ctx = document.getElementById('forecast-chart').getContext('2d');
    
    // Create chart with dark mode support
    createForecastChart(ctx, labels, temps, feelsLike);
  }