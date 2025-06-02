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


   const logo = document.getElementById('logo');

function setDarkMode(isDark) {
  if(isDark) {
    logo.src = 'img/logo/image2vector.svg';
  } else {
    logo.src = 'img/logo/image2vector.svg';
  }
}

// Exemplo de ativar dark mode
setDarkMode(true); // usa logo branca




///fetch da api pra fonte de dados
fetch('api/api_fonte_dados.php')
  .then(response => {
    if (!response.ok) {
      throw new Error(`Erro HTTP: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    console.log("Resposta recebida:", data); // Confirma a resposta

    const container = document.getElementById('lista-fontes');
    if (!container) {
      console.error("❌ Elemento com ID 'lista-fontes' não encontrado!");
      return;
    }

    container.innerHTML = ''; // Limpa o conteúdo anterior

    data.forEach(fonte => {
      const p = document.createElement('p');
      p.innerHTML = `<strong>${fonte.nome}</strong> - Status: 
        <span class="${fonte.status === 'online' ? 'text-success' : 'text-danger'}">
          ${fonte.status}
        </span>`;
      container.appendChild(p);
    });
  })
  .catch(error => console.error('Erro ao carregar fontes:', error));