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
        <div class="map-section">
        <div class="linha-info">
          <div class="train-icon">🚆</div>
          <div class="linha-num">031</div>
        </div>
        <div id="map" style="height:300px;width:100%;border-radius:10px;"></div>
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
          <button class="acao">Chegada na estação Y</button>
        </div>
      </div>

      
    </section>
    
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
    <script>
      
      var map = L.map('map').setView([-26.304408, -48.848022], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
      }).addTo(map);
      
      var estacaoX = L.latLng(-26.304408, -48.848022);
      var senaiSul = L.latLng(-26.320000, -48.850000);
      
      L.marker(estacaoX).addTo(map)
        .bindPopup('Estação X (Joinville)');
      
      L.marker(senaiSul).addTo(map)
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
      }).addTo(map);
    </script>
    <script>
    document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "dashboard3.html";
    });
  </script>
</body>
</html>