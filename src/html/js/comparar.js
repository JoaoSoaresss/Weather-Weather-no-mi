// Dark Mode 
  document.addEventListener('DOMContentLoaded', function() {
    // Check for saved dark mode preference
    const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';
    if (darkModeEnabled) {
      document.body.classList.add('dark-mode');
      updateDarkModeIcon(true);
    }

    // Dark mode toggle
    document.getElementById('darkModeToggle').addEventListener('click', function() {
      document.body.classList.toggle('dark-mode');
      const isDarkMode = document.body.classList.contains('dark-mode');
      localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
      updateDarkModeIcon(isDarkMode);
      updateChartTheme(isDarkMode);
    });

    // Update dark mode icon
  function updateDarkModeIcon(isDarkMode) {
  const icon = document.querySelector('#darkModeToggle i');
  if (!icon) return;
  icon.classList.toggle('bi-moon', !isDarkMode);
  icon.classList.toggle('bi-sun', isDarkMode);
}


    // Update chart theme based on dark mode
    function updateChartTheme(isDarkMode) {
      if (window.comparisonChart) {
        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        const tickColor = isDarkMode ? '#e6e6e6' : '#666';
        
        window.comparisonChart.options.scales.x.grid.color = gridColor;
        window.comparisonChart.options.scales.y.grid.color = gridColor;
        window.comparisonChart.options.scales.x.ticks.color = tickColor;
        window.comparisonChart.options.scales.y.ticks.color = tickColor;
        window.comparisonChart.update();
      }
    }
  });
