<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alertas e Notificações</title>
  <link rel="stylesheet" href="../css/alertas.css">
  <script src="../Js/alertas.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
</head>
<body>

  

    <div class="phone-content">
      <div class="header">
        <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Alertas e notificações</h2>
        </div>
      </div>

      

        <div class="screen">
          <?php
          include "db.php";
          // Buscar alertas ativas
          $alertas = [];
          $result = $conn->query("SELECT a.*, v.idTrem, r.nomeRota FROM Alertas a JOIN Viagens v ON a.idViagem = v.idViagem JOIN Rotas r ON v.idRota = r.idRota WHERE a.statusResolucao = 'pendente' ORDER BY a.tempoAlerta DESC");
          if($result){
              while($row = $result->fetch_assoc()){
                  $alertas[] = $row;
              }
              $result->free();
          }
          ?>

          <section class="problemas">
            <h2>Linhas com problemas</h2>
            <div class="seta">⌄</div>

            <?php if(empty($alertas)): ?>
              <p style="text-align: center; color: #666; padding: 20px;">Nenhum problema reportado</p>
            <?php else: ?>
              <?php foreach($alertas as $alerta): ?>
                <div class="linha-card">
                  <div class="linha-icon">🚆<span><?=$alerta['idTrem']?></span></div>
                  <div class="linha-info">
                    <p><strong><?=$alerta['tipoAlerta']?> - <?=$alerta['severidadeAlerta']?></strong></p>
                    <p><?=$alerta['descricaoAlerta']?></p>
                    <p class="atraso">Rota: <?=$alerta['nomeRota']?></p>
                    <p style="font-size: 12px; color: #666;"><?=$alerta['tempoAlerta']?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </section>

          <section class="notificacoes">
            <h2>Notificações</h2>
            <div class="seta">⌄</div>
            <?php
            // Buscar todas as notificações/alertas
            $notificacoes = [];
            $result_notif = $conn->query("SELECT a.*, r.nomeRota FROM Alertas a JOIN Viagens v ON a.idViagem = v.idViagem JOIN Rotas r ON v.idRota = r.idRota ORDER BY a.tempoAlerta DESC LIMIT 10");
            if($result_notif){
                while($row = $result_notif->fetch_assoc()){
                    $notificacoes[] = $row;
                }
                $result_notif->free();
            }
            ?>

            <?php if(empty($notificacoes)): ?>
              <div class="notificacao">
                ✅ Nenhuma notificação pendente
              </div>
            <?php else: ?>
              <?php foreach($notificacoes as $notif): ?>
                <div class="notificacao">
                  ⚠️ <?=$notif['tipoAlerta']?> na rota <?=$notif['nomeRota']?> - <?=$notif['tempoAlerta']?>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </section>
        </div>
      </div>
    </div>
  </div>



</body>
</html>