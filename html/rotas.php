<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotas</title>
    <link rel="stylesheet" href="../css/rotas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
</head>
<body>
 
    <div class="phone-content">
      <div class="header">
         <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Rotas</h2>
        </div>
      </div>
  
    
     
      
      
    </header>
    <section class="route-box">
      
      <!-- Linha 031 -->
      <div class="linha-aba">
        <div class="aba-header" onclick="toggleAba('linha031')">
          <div class="linha-info-header">
            <div class="train-icon">🚆</div>
            <div class="linha-num">031</div>
          </div>
          <i class="fas fa-chevron-down aba-icon" id="icon031"></i>
        </div>
        <div class="aba-content" id="linha031">
          <div class="map-section">
            <div class="linha-info">
              <div class="train-icon">🚆</div>
              <div class="linha-num">031</div>
            </div>
            <div id="map031" style="height:300px;width:100%;border-radius:10px;"></div>
          </div>

          <div class="info">
            <p class="data">28 de março de 2025</p>

            <div class="hora-bloco">
              <span class="hora">10:30</span>
              <button class="acao">Saída da estação X</button>
            </div>

            <div class="pontos">⋮</div>

            <div class="hora-bloco">
              <span class="hora">10:50</span>
              <button class="acao">Chegada no SENAI SUL</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Linha 057 -->
      <div class="linha-aba">
        <div class="aba-header" onclick="toggleAba('linha057')">
          <div class="linha-info-header">
            <div class="train-icon">🚌</div>
            <div class="linha-num">057</div>
          </div>
          <i class="fas fa-chevron-down aba-icon" id="icon057"></i>
        </div>
        <div class="aba-content" id="linha057">
          <div class="map-section">
            <div class="linha-info">
              <div class="train-icon">🚌</div>
              <div class="linha-num">057</div>
            </div>
            <div id="map057" style="height:300px;width:100%;border-radius:10px;"></div>
          </div>

          <div class="info">
            <p class="data">28 de março de 2025</p>

            <div class="hora-bloco">
              <span class="hora">11:00</span>
              <button class="acao">Saída do Expoville</button>
            </div>

            <div class="pontos">⋮</div>

            <div class="hora-bloco">
              <span class="hora">11:25</span>
              <button class="acao">Chegada no SENAI NORTE</button>
            </div>
          </div>
        </div>
      </div>
      
    </section>
    
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
    <script>
      
      // Função para toggle das abas
      function toggleAba(linhaId) {
        var content = document.getElementById(linhaId);
        var icon = document.getElementById('icon' + linhaId.replace('linha', ''));
        
        if (content.style.display === 'none' || content.style.display === '') {
          content.style.display = 'block';
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-up');
          
          // Inicializa o mapa quando a aba é aberta
          if (linhaId === 'linha031' && !window.map031) {
            initMap031();
          } else if (linhaId === 'linha057' && !window.map057) {
            initMap057();
          }
        } else {
          content.style.display = 'none';
          icon.classList.remove('fa-chevron-up');
          icon.classList.add('fa-chevron-down');
        }
      }
      
      // Mapa Linha 031 - Estação X até SENAI SUL
      function initMap031() {
        if (window.map031) return;
        
        window.map031 = L.map('map031').setView([-26.304408, -48.848022], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '© OpenStreetMap'
        }).addTo(window.map031);
        
        var estacaoX = L.latLng(-26.304408, -48.848022);
        var senaiSul = L.latLng(-26.320000, -48.850000);
        
        L.marker(estacaoX).addTo(window.map031)
          .bindPopup('Estação X (Joinville)');
        
        L.marker(senaiSul).addTo(window.map031)
          .bindPopup('SENAI SUL');
        
        // Rota seguindo as ruas usando OSRM
        L.Routing.control({
          waypoints: [estacaoX, senaiSul],
          router: L.Routing.osrmv1({
            serviceUrl: 'https://router.project-osrm.org/route/v1'
          }),
          routeWhileDragging: false,
          lineOptions: {
            styles: [
              {color: '#0066cc', opacity: 0.8, weight: 5}
            ]
          },
          addWaypoints: false,
          draggableWaypoints: false,
          fitSelectedRoutes: true,
          showAlternatives: false
        }).addTo(window.map031);
      }
      
      // Mapa Linha 057 - Expoville até SENAI NORTE
      function initMap057() {
        if (window.map057) return;
        
        window.map057 = L.map('map057').setView([-26.280000, -48.830000], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '© OpenStreetMap'
        }).addTo(window.map057);
        
        var expoville = L.latLng(-26.280000, -48.840000);
        var senaiNorte = L.latLng(-26.270000, -48.820000);
        
        L.marker(expoville).addTo(window.map057)
          .bindPopup('Expoville');
        
        L.marker(senaiNorte).addTo(window.map057)
          .bindPopup('SENAI NORTE');
        
        // Rota seguindo as ruas usando OSRM
        L.Routing.control({
          waypoints: [expoville, senaiNorte],
          router: L.Routing.osrmv1({
            serviceUrl: 'https://router.project-osrm.org/route/v1'
          }),
          routeWhileDragging: false,
          lineOptions: {
            styles: [
              {color: '#0066cc', opacity: 0.8, weight: 5}
            ]
          },
          addWaypoints: false,
          draggableWaypoints: false,
          fitSelectedRoutes: true,
          showAlternatives: false
        }).addTo(window.map057);
      }
      
      // Abre a primeira aba por padrão
      window.addEventListener('DOMContentLoaded', function() {
        toggleAba('linha031');
      });
    </script>
</body>
</html>