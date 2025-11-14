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
      <?php
      include "db.php";
      $rotas = [];
      $result = $conn->query("SELECT r.*, e1.nomeEstacao AS origem, e1.latitude AS lat_origem, e1.longitude AS lng_origem, e2.nomeEstacao AS destino, e2.latitude AS lat_destino, e2.longitude AS lng_destino FROM Rotas r JOIN Estacoes e1 ON r.estacaoOrigem = e1.idEstacao JOIN Estacoes e2 ON r.estacaoDestino = e2.idEstacao ORDER BY r.nomeRota");
      if($result){
          while($row = $result->fetch_assoc()){
              $rotas[] = $row;
          }
          $result->free();
      }
      if(empty($rotas)){
          echo "<p>Nenhuma rota cadastrada.</p>";
      }else{
          foreach($rotas as $index => $rota){
              $linhaId = 'linha' . ($index + 1);
              $iconId = 'icon' . ($index + 1);
              $mapId = 'map' . ($index + 1);
              $origem = $rota['origem'];
              $destino = $rota['destino'];
              $lat_origem = $rota['lat_origem'];
              $lng_origem = $rota['lng_origem'];
              $lat_destino = $rota['lat_destino'];
              $lng_destino = $rota['lng_destino'];
              ?>
              <div class="linha-aba">
                <div class="aba-header" onclick="toggleAba('<?=$linhaId?>')">
                  <div class="linha-info-header">
                    <div class="train-icon">🚆</div>
                    <div class="linha-num"><?=$rota['nomeRota']?></div>
                  </div>
                  <i class="fas fa-chevron-down aba-icon" id="<?=$iconId?>"></i>
                </div>
                <div class="aba-content" id="<?=$linhaId?>">
                  <div class="map-section">
                    <div class="linha-info">
                      <div class="train-icon">🚆</div>
                      <div class="linha-num"><?=$rota['nomeRota']?></div>
                    </div>
                    <div id="<?=$mapId?>" style="height:300px;width:100%;border-radius:10px;"></div>
                  </div>

                  <div class="info">
                    <p class="data">Distância: <?=$rota['distanciaTotal']?> km | Tempo Médio: <?=$rota['tempoMedioPercurso']?></p>

                    <?php
                    // Buscar viagens para esta rota
                    $viagens = [];
                    $stmt = $conn->prepare("SELECT horario_partida_previsto, horario_chegada_previsto FROM Viagens WHERE idRota = ? ORDER BY horario_partida_previsto");
                    $stmt->bind_param("i", $rota['idRota']);
                    $stmt->execute();
                    $result_viagens = $stmt->get_result();
                    while($viagem = $result_viagens->fetch_assoc()){
                        $viagens[] = $viagem;
                    }
                    $stmt->close();
                    ?>

                    <?php if(!empty($viagens)): ?>
                      <h4>Horários:</h4>
                      <?php foreach($viagens as $viagem): ?>
                        <div class="hora-bloco">
                          <span class="hora">Saída: <?=$viagem['horario_partida_previsto']?></span>
                          <button class="acao"><?=$origem?></button>
                        </div>
                        <div class="pontos">⋮</div>
                        <div class="hora-bloco">
                          <span class="hora">Chegada: <?=$viagem['horario_chegada_previsto']?></span>
                          <button class="acao"><?=$destino?></button>
                        </div>
                        <hr style="margin: 10px 0;">
                      <?php endforeach; ?>
                    <?php else: ?>
                      <div class="hora-bloco">
                        <span class="hora">Saída</span>
                        <button class="acao"><?=$origem?></button>
                      </div>
                      <div class="pontos">⋮</div>
                      <div class="hora-bloco">
                        <span class="hora">Chegada</span>
                        <button class="acao"><?=$destino?></button>
                      </div>
                      <p style="color: #666; font-size: 12px;">Nenhum horário cadastrado</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <script>
                function initMap<?=$index + 1?>() {
                  if (window.map<?=$index + 1?>) return;

                  window.map<?=$index + 1?> = L.map('<?=$mapId?>').setView([<?=$lat_origem?>, <?=$lng_origem?>], 13);
                  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                  }).addTo(window.map<?=$index + 1?>);

                  var estacaoOrigem = L.latLng(<?=$lat_origem?>, <?=$lng_origem?>);
                  var estacaoDestino = L.latLng(<?=$lat_destino?>, <?=$lng_destino?>);

                  L.marker(estacaoOrigem).addTo(window.map<?=$index + 1?>)
                    .bindPopup('<?=$origem?>');

                  L.marker(estacaoDestino).addTo(window.map<?=$index + 1?>)
                    .bindPopup('<?=$destino?>');

                  L.Routing.control({
                    waypoints: [estacaoOrigem, estacaoDestino],
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
                  }).addTo(window.map<?=$index + 1?>);
                }
              </script>
              <?php
          }
      }
      ?>
    </section>
    
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
    <script>
      
      
      function toggleAba(linhaId) {
        var content = document.getElementById(linhaId);
        var icon = document.getElementById('icon' + linhaId.replace('linha', ''));

        if (content.style.display === 'none' || content.style.display === '') {
          content.style.display = 'block';
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-up');

          // Inicializar mapa dinamicamente
          var mapId = 'map' + linhaId.replace('linha', '');
          if (!window['map' + linhaId.replace('linha', '')]) {
            window['initMap' + linhaId.replace('linha', '')]();
          }
        } else {
          content.style.display = 'none';
          icon.classList.remove('fa-chevron-up');
          icon.classList.add('fa-chevron-down');
        }
      }
      
      

      
      
      window.addEventListener('DOMContentLoaded', function() {
        // Abrir a primeira aba se existir
        if (document.getElementById('linha1')) {
          toggleAba('linha1');
        }
      });
    </script>
</body>
</html>