<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velocidade dos Trens</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
</head>
<body>
 

    <div class="phone-content">
      <div class="header">
       <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Velocidade</h2>
        </div>
      </div>
  

    <div class="container">
      <div class="card">
        <div class="card-header">
          <span>Linhas</span>
          <span>Velocidade</span>
          <span>Km/h</span>
        </div>
        <div class="card-content">
          <div class="icon-section">
            
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
              <rect x="10" y="8" width="28" height="24" rx="8" stroke="white" stroke-width="3" fill="none"/>
              <rect x="16" y="14" width="16" height="10" rx="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="16" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="32" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <line x1="16" y1="40" x2="12" y2="44" stroke="white" stroke-width="2"/>
              <line x1="32" y1="40" x2="36" y2="44" stroke="white" stroke-width="2"/>
            </svg>
            <div class="line-number">031</div>
          </div>
          <div class="speedometer-section">
        
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
              <circle cx="30" cy="30" r="24" stroke="white" stroke-width="3" fill="none"/>
              <path d="M30 30 L50 30" stroke="white" stroke-width="3" />
              <path d="M30 30 L44 44" stroke="white" stroke-width="3" />
              <path d="M30 30 L30 50" stroke="white" stroke-width="3" />
            </svg>
          </div>
          <div class="speed-section">
            <div class="speed-value" id="speed-1">60</div>
            <div class="arrows">
              <button class="arrow-btn" onclick="changeSpeed('speed-1', 1)">▲</button>
              <button class="arrow-btn" onclick="changeSpeed('speed-1', -1)">▼</button>
            </div>
          </div>
        </div>
      </div>
    
      <div class="card">
        <div class="card-header">
          <span>Linhas</span>
          <span>Velocidade</span>
          <span>Km/h</span>
        </div>
        <div class="card-content">
          <div class="icon-section">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
              <rect x="10" y="8" width="28" height="24" rx="8" stroke="white" stroke-width="3" fill="none"/>
              <rect x="16" y="14" width="16" height="10" rx="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="16" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="32" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <line x1="16" y1="40" x2="12" y2="44" stroke="white" stroke-width="2"/>
              <line x1="32" y1="40" x2="36" y2="44" stroke="white" stroke-width="2"/>
            </svg>
            <div class="line-number">057</div>
          </div>
          <div class="speedometer-section">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
              <circle cx="30" cy="30" r="24" stroke="white" stroke-width="3" fill="none"/>
              <path d="M30 30 L50 30" stroke="white" stroke-width="3" />
              <path d="M30 30 L44 44" stroke="white" stroke-width="3" />
              <path d="M30 30 L30 50" stroke="white" stroke-width="3" />
            </svg>
          </div>
          <div class="speed-section">
            <div class="speed-value" id="speed-2">75</div>
            <div class="arrows">
              <button class="arrow-btn" onclick="changeSpeed('speed-2', 1)">▲</button>
              <button class="arrow-btn" onclick="changeSpeed('speed-2', -1)">▼</button>
            </div>
          </div>
        </div>
      </div>
    
      <div class="card">
        <div class="card-header">
          <span>Linhas</span>
          <span>Velocidade</span>
          <span>Km/h</span>
        </div>
        <div class="card-content">
          <div class="icon-section">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
              <rect x="10" y="8" width="28" height="24" rx="8" stroke="white" stroke-width="3" fill="none"/>
              <rect x="16" y="14" width="16" height="10" rx="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="16" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="32" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <line x1="16" y1="40" x2="12" y2="44" stroke="white" stroke-width="2"/>
              <line x1="32" y1="40" x2="36" y2="44" stroke="white" stroke-width="2"/>
            </svg>
            <div class="line-number">341</div>
          </div>
          <div class="speedometer-section">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
              <circle cx="30" cy="30" r="24" stroke="white" stroke-width="3" fill="none"/>
              <path d="M30 30 L50 30" stroke="white" stroke-width="3" />
              <path d="M30 30 L44 44" stroke="white" stroke-width="3" />
              <path d="M30 30 L30 50" stroke="white" stroke-width="3" />
            </svg>
          </div>
          <div class="speed-section">
            <div class="speed-value" id="speed-3">90</div>
            <div class="arrows">
              <button class="arrow-btn" onclick="changeSpeed('speed-3', 1)">▲</button>
              <button class="arrow-btn" onclick="changeSpeed('speed-3', -1)">▼</button>
            </div>
          </div>
        </div>
      </div>
    
      <div class="card">
        <div class="card-header">
          <span>Linhas</span>
          <span>Velocidade</span>
          <span>Km/h</span>
        </div>
        <div class="card-content">
          <div class="icon-section">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
              <rect x="10" y="8" width="28" height="24" rx="8" stroke="white" stroke-width="3" fill="none"/>
              <rect x="16" y="14" width="16" height="10" rx="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="16" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <circle cx="32" cy="36" r="3" stroke="white" stroke-width="2" fill="none"/>
              <line x1="16" y1="40" x2="12" y2="44" stroke="white" stroke-width="2"/>
              <line x1="32" y1="40" x2="36" y2="44" stroke="white" stroke-width="2"/>
            </svg>
            <div class="line-number">157</div>
          </div>
          <div class="speedometer-section">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
              <circle cx="30" cy="30" r="24" stroke="white" stroke-width="3" fill="none"/>
              <path d="M30 30 L50 30" stroke="white" stroke-width="3" />
              <path d="M30 30 L44 44" stroke="white" stroke-width="3" />
              <path d="M30 30 L30 50" stroke="white" stroke-width="3" />
            </svg>
          </div>
          <div class="speed-section">
            <div class="speed-value" id="speed-4">60</div>
            <div class="arrows">
              <button class="arrow-btn" onclick="changeSpeed('speed-4', 1)">▲</button>
              <button class="arrow-btn" onclick="changeSpeed('speed-4', -1)">▼</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 

  <script>
     document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "dashboard3.html";
    });
    function changeSpeed(id, delta) {
      const el = document.getElementById(id);
      let value = parseInt(el.textContent, 10);
      value = Math.max(0, value + delta);
      el.textContent = value;
    }
  </script>
</body>
</html>