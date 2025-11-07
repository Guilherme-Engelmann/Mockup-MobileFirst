<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotas</title>
    <link rel="stylesheet" href="../css/rotas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
      #map031, #map057 {
        height: 400px;
        width: 100%;
        border-radius: 10px;
      }
      .aba-content {
        display: none;
      }
      .aba-content.active {
        display: block;
      }
    </style>
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
        <div class="aba-content active" id="linha031">
          <div class="map-section">
            <div class="linha-info">
              <div class="train-icon">🚆</div>
              <div class="linha-num">031</div>
            </div>
            <div id="map031"></div>
          </div>

          <div class="info">
            <p class="data">28 de março de 2025</p>

            <div class="hora-bloco">
              <span class="hora">10:30</span>
              <button class="acao">Saída da Estação X</button>
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
            <div id="map057"></div>
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
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFw0Qbyq9zTFTd-tUY6d-s6Y4cwwuVHCQ&libraries=places,directions"></script>
    <script>
      let map031, map057;
      let directionsService031, directionsRenderer031;
      let directionsService057, directionsRenderer057;

      // Função para toggle das abas
      function toggleAba(linhaId) {
        const content = document.getElementById(linhaId);
        const icon = document.getElementById('icon' + linhaId.replace('linha', ''));
        
        if (content.classList.contains('active')) {
          content.classList.remove('active');
          icon.classList.remove('fa-chevron-up');
          icon.classList.add('fa-chevron-down');
        } else {
          // Fecha todas as outras abas
          document.querySelectorAll('.aba-content').forEach(aba => {
            aba.classList.remove('active');
          });
          document.querySelectorAll('.aba-icon').forEach(ic => {
            ic.classList.remove('fa-chevron-up');
            ic.classList.add('fa-chevron-down');
          });
          
          // Abre a aba selecionada
          content.classList.add('active');
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-up');
          
          // Inicializa o mapa se ainda não foi inicializado
          if (linhaId === 'linha031' && !map031) {
            initMap031();
          } else if (linhaId === 'linha057' && !map057) {
            initMap057();
          } else {
            // Ajusta o tamanho do mapa quando a aba é aberta
            setTimeout(() => {
              if (linhaId === 'linha031' && map031) {
                google.maps.event.trigger(map031, 'resize');
              } else if (linhaId === 'linha057' && map057) {
                google.maps.event.trigger(map057, 'resize');
              }
            }, 100);
          }
        }
      }

      // Inicializa mapa da Linha 031
      function initMap031() {
        map031 = new google.maps.Map(document.getElementById('map031'), {
          zoom: 13,
          center: {lat: -26.304408, lng: -48.848022},
          mapTypeControl: true,
          streetViewControl: true,
          fullscreenControl: true,
          zoomControl: true,
          mapTypeId: 'roadmap'
        });

        directionsService031 = new google.maps.DirectionsService();
        directionsRenderer031 = new google.maps.DirectionsRenderer({
          map: map031,
          suppressMarkers: false,
          polylineOptions: {
            strokeColor: '#0066cc',
            strokeWeight: 5,
            strokeOpacity: 0.8
          }
        });

        // Pontos da rota 031
        const origem031 = {lat: -26.304408, lng: -48.848022};
        const destino031 = {lat: -26.320000, lng: -48.850000};

        // Marcadores
        const markerOrigem031 = new google.maps.Marker({
          position: origem031,
          map: map031,
          title: 'Estação X (Joinville)',
          icon: {
            url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
          }
        });

        const markerDestino031 = new google.maps.Marker({
          position: destino031,
          map: map031,
          title: 'SENAI SUL',
          icon: {
            url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
          }
        });

        // Info windows
        const infoWindowOrigem031 = new google.maps.InfoWindow({
          content: '<div style="padding: 10px;"><strong>Estação X</strong><br>Joinville, SC</div>'
        });

        const infoWindowDestino031 = new google.maps.InfoWindow({
          content: '<div style="padding: 10px;"><strong>SENAI SUL</strong><br>Joinville, SC</div>'
        });

        markerOrigem031.addListener('click', () => {
          infoWindowOrigem031.open(map031, markerOrigem031);
        });

        markerDestino031.addListener('click', () => {
          infoWindowDestino031.open(map031, markerDestino031);
        });

        // Calcula a rota
        const request031 = {
          origin: origem031,
          destination: destino031,
          travelMode: 'DRIVING'
        };

        directionsService031.route(request031, (result, status) => {
          if (status === 'OK') {
            directionsRenderer031.setDirections(result);
          } else {
            console.error('Erro ao calcular rota 031:', status);
          }
        });
      }

      // Inicializa mapa da Linha 057
      function initMap057() {
        map057 = new google.maps.Map(document.getElementById('map057'), {
          zoom: 13,
          center: {lat: -26.280000, lng: -48.830000},
          mapTypeControl: true,
          streetViewControl: true,
          fullscreenControl: true,
          zoomControl: true,
          mapTypeId: 'roadmap'
        });

        directionsService057 = new google.maps.DirectionsService();
        directionsRenderer057 = new google.maps.DirectionsRenderer({
          map: map057,
          suppressMarkers: false,
          polylineOptions: {
            strokeColor: '#0066cc',
            strokeWeight: 5,
            strokeOpacity: 0.8
          }
        });

        // Pontos da rota 057
        const origem057 = {lat: -26.280000, lng: -48.840000};
        const destino057 = {lat: -26.270000, lng: -48.820000};

        // Marcadores
        const markerOrigem057 = new google.maps.Marker({
          position: origem057,
          map: map057,
          title: 'Expoville',
          icon: {
            url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
          }
        });

        const markerDestino057 = new google.maps.Marker({
          position: destino057,
          map: map057,
          title: 'SENAI NORTE',
          icon: {
            url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
          }
        });

        // Info windows
        const infoWindowOrigem057 = new google.maps.InfoWindow({
          content: '<div style="padding: 10px;"><strong>Expoville</strong><br>Joinville, SC</div>'
        });

        const infoWindowDestino057 = new google.maps.InfoWindow({
          content: '<div style="padding: 10px;"><strong>SENAI NORTE</strong><br>Joinville, SC</div>'
        });

        markerOrigem057.addListener('click', () => {
          infoWindowOrigem057.open(map057, markerOrigem057);
        });

        markerDestino057.addListener('click', () => {
          infoWindowDestino057.open(map057, markerDestino057);
        });

        // Calcula a rota
        const request057 = {
          origin: origem057,
          destination: destino057,
          travelMode: 'DRIVING'
        };

        directionsService057.route(request057, (result, status) => {
          if (status === 'OK') {
            directionsRenderer057.setDirections(result);
          } else {
            console.error('Erro ao calcular rota 057:', status);
          }
        });
      }

      // Inicializa o primeiro mapa quando a página carregar
      window.addEventListener('DOMContentLoaded', function() {
        initMap031();
      });
    </script>
</body>
</html>