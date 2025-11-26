# 📱 Documentação Completa - Sistema de Gerenciamento de Trens

**Versão:** 1.0  
**Data:** Novembro 2025  
**Aplicação:** Mockup Mobile First - Sistema de Monitoramento e Gerenciamento Ferroviário

---

## 📋 Índice

1. [Visão Geral](#visão-geral)
2. [Arquitetura do Sistema](#arquitetura-do-sistema)
3. [Guia de Uso por Página](#guia-de-uso-por-página)
4. [Recursos e Funcionalidades](#recursos-e-funcionalidades)
5. [Segurança e Validações](#segurança-e-validações)
6. [Troubleshooting](#troubleshooting)

---

## 🎯 Visão Geral

O Sistema de Gerenciamento de Trens é uma aplicação mobile-first desenvolvida em PHP que permite o gerenciamento completo de operações ferroviárias, incluindo:

- **Gestão de Rotas:** Criação, edição e exclusão de rotas ferroviárias
- **Controle de Trens:** Cadastro e monitoramento de trens
- **Gerenciamento de Estações:** Criação de pontos de origem e destino
- **Monitoramento em Tempo Real:** Velocidade, status e alertas
- **Sistema de Alertas:** Notificações de problemas e anomalias
- **Manutenção Preventiva:** Agendamento e acompanhamento de manutenções
- **Relatórios:** Análise de dados operacionais

---

## 🏗️ Arquitetura do Sistema

### Estrutura de Pastas

```
Mockup-MobileFirst/
├── html/                  # Arquivos PHP principais
├── css/                   # Estilos CSS
├── imagens/              # Assets e imagens
├── banco.sql             # Script do banco de dados
├── index.php             # Página de login
└── readme.md             # Readme original
```

### Tipos de Usuários

O sistema possui **2 tipos de perfis de usuário**:

| Perfil | Acesso | Funcionalidades |
|--------|--------|-----------------|
| **ADM (Administrador)** | Dashboard Admin | Criar/Editar/Deletar rotas, trens, estações, usuários, alertas e manutenções |
| **FUNC (Funcionário)** | Dashboard Funcionário | Visualizar rotas, velocidade, alertas, status de trens e dados pessoais |

### Credenciais de Teste

```
Usuário: adm
Senha: 123
Cargo: ADM
```

---

## 📖 Guia de Uso por Página

### 🔐 **1. PÁGINA DE LOGIN** (`index.php`)

**Localização:** Primeira página ao acessar a aplicação

**Funcionalidades:**
- Login com usuário e senha
- Redirecionamento automático baseado no tipo de usuário
- Links para "Esqueceu a senha?" e "Criar conta"

**Como Usar:**

1. Insira seu **usuário** no campo "Usuário"
2. Insira sua **senha** no campo "Senha"
3. Clique no botão **"Entrar"**
4. Se os dados forem válidos, você será redirecionado ao dashboard correspondente

**Dica:** Primeira vez? Use as credenciais: `adm / 123`

**Recursos de Segurança:**
- Senhas são armazenadas com hash (password_hash)
- Compatibilidade com senhas legadas (migração automática para hash)
- Session ID regenerado após login

---

### 📊 **2. DASHBOARD FUNCIONÁRIO** (`dashboard3.php`)

**Localização:** Acessível após login com perfil FUNC

**Menu Principal - 6 Opções:**

#### A. **Dashboard Geral** (`dashboardGeral.php`)
- Visualização de dados resumidos
- Estatísticas operacionais
- Informações gerais do sistema

#### B. **Velocidade** (`velocidade.php`)
- Monitoramento de velocidade em tempo real de cada linha
- Exibição de velocímetro visual
- Dados por linha ferroviária (ex: Linha 031)
- Controles para aumentar/diminuir velocidade (▲/▼)

#### C. **Rotas** (`rotas.php`)
- **Quando há rotas cadastradas:**
  - Lista de todas as rotas disponíveis
  - Informações: origem, destino, distância total, tempo médio
  - Mapa interativo de cada rota
  - Horários das viagens

- **Quando NÃO há rotas cadastradas:**
  - Exibição da imagem ferrorama.png
  - Mensagem "Nenhuma rota cadastrada"

**Como Usar:**
1. Clique em "Rotas" no dashboard
2. Se houver rotas, clique em qualquer linha para expandir detalhes
3. Visualize o mapa, horários e informações da rota
4. Use os horários para planejar viagens

#### D. **Meus Dados** (`meusDados.php`)
- Edição de informações pessoais
- Campos: Email, Telefone, CPF, Endereço, CEP

**Validações Aplicadas:**
- **Email:** Formato válido (ex: usuario@email.com)
- **Telefone:** Formato brasileiro (10-11 dígitos)
- **CPF:** Algoritmo de validação brasileira
- **CEP:** Validação através da API ViaCEP
- **Endereço:** Mínimo de caracteres

**Como Usar:**
1. Preencha todos os campos com dados válidos
2. Clique em "Salvar"
3. Caso haja erro, mensagem será exibida
4. Ao sucesso, "Dados atualizados com sucesso!" aparecerá

#### E. **Status do Trem** (`statusTrans.php`)
- Visualização do status de cada trem
- Informações de operação
- Dados de localização e situação atual

#### F. **Alertas e Notificações** (`alertas.php`)
- **Seção "Linhas com problemas":**
  - Alertas ativos (pendentes)
  - Tipo de alerta (falha, atraso, etc.)
  - Severidade (crítica, alta, média, baixa)
  - Rota e ID do trem afetado

- **Seção "Notificações":**
  - Histórico de notificações
  - Últimas 10 notificações registradas

**Como Usar:**
1. Visualize os alertas pendentes na primeira seção
2. Leia a descrição do problema e a rota afetada
3. Informe ao administrador sobre problemas críticos
4. Verifique o histórico de notificações

---

### ⚙️ **3. DASHBOARD ADMINISTRADOR** (`admin_dashboard.php`)

**Localização:** Acessível apenas com perfil ADM

**Menu Principal - 11 Opções:**

#### A. **Cadastrar Rota** (`criar_rota.php`)
- Formulário para criar novas rotas
- Campos: Nome da Rota, Estação Origem, Estação Destino, Distância Total, Tempo Médio

**Como Usar:**
1. Selecione estação de origem e destino (dropdown)
2. Digite distância total em km
3. Digite tempo médio de percurso
4. Clique em "Cadastrar"
5. Mensagem de sucesso confirmará adição

#### B. **Listar Rotas** (`listar_rotas.php`)
- Visualização de todas as rotas
- Opções de editar e deletar
- Informações completas da rota

**Como Usar:**
1. Veja lista de rotas cadastradas
2. Clique em "Editar" para modificar informações
3. Clique em "Deletar" para remover (irrevogável)
4. Atualizações são refletidas imediatamente

#### C. **Cadastrar Trem** (`criar_trem.php`)
- Formulário para registrar novos trens
- Campos: Número do Trem, Capacidade, Tipo, Status

**Como Usar:**
1. Digite número identificador do trem
2. Defina capacidade máxima de passageiros
3. Selecione tipo (ex: Metrô, Intercidades, etc.)
4. Configure status inicial
5. Clique em "Cadastrar"

#### D. **Listar Trens** (`listar_trens.php`)
- Visualização de todos os trens cadastrados
- Informações: número, capacidade, tipo, status
- Opções de editar e deletar

**Como Usar:**
1. Visualize trens disponíveis
2. Monitore capacidade e status de cada um
3. Edite informações conforme necessário
4. Remova trens descontinuados

#### E. **Cadastrar Estação** (`criar_estacao.php`)
- Formulário para registrar novas estações
- Campos: Nome, Endereço, Latitude, Longitude

**Como Usar:**
1. Digite nome descritivo da estação
2. Informe endereço completo
3. Defina coordenadas GPS (latitude/longitude)
4. Clique em "Cadastrar"
5. Estação ficará disponível para rotas

#### F. **Listar Estações** (`listar_estacoes.php`)
- Visualização de todas as estações
- Informações de localização e coordenadas
- Opções de editar e deletar

**Como Usar:**
1. Consulte todas as estações cadastradas
2. Edite informações de localização se necessário
3. Remova estações desativadas

#### G. **Cadastrar Usuário** (`cadastro.php`)
- Formulário para adicionar novos usuários ao sistema
- Campos: Usuário, Senha, Cargo (ADM ou FUNC)

**Como Usar:**
1. Digite nome de usuário único
2. Define senha segura
3. Selecione cargo: ADM (Administrador) ou FUNC (Funcionário)
4. Clique em "Cadastrar"
5. Novo usuário poderá fazer login imediatamente

#### H. **Manutenções** (`manutencao.php`)
- Gerenciamento de manutenções de trens
- **Criar Manutenção:**
  - Selecione trem
  - Digite descrição do serviço
  - Defina data agendada
- **Listar Manutenções:**
  - Visualize todas as manutenções
  - Edite ou delete conforme necessário

**Como Usar:**
1. Acesse seção de manutenções
2. Para nova manutenção: selecione trem, descrição e data
3. Clique "Agendar"
4. Visualize histórico de manutenções agendadas

#### I. **Relatórios** (`relatorios.php`)
- Análise de dados operacionais
- Estatísticas de operação
- Gráficos e resumos

**Como Usar:**
1. Acesse seção de relatórios
2. Selecione período desejado
3. Escolha tipo de relatório
4. Exporte dados se necessário

#### J. **Cadastrar Alerta/Notificação** (`criar_alerta.php`)
- Formulário para criar alertas para os usuários
- Campos: Tipo de Alerta, Severidade, Descrição, Rota

**Como Usar:**
1. Selecione tipo de alerta (falha, atraso, manutenção, etc.)
2. Defina severidade (crítica, alta, média, baixa)
3. Descreva o problema
4. Selecione rota afetada
5. Clique "Enviar Alerta"
6. Alerta aparecerá para todos os funcionários

#### K. **Listar Alertas/Notificações** (`listar_alertas.php`)
- Visualização de todos os alertas enviados
- Informações: tipo, severidade, descrição, data
- Opções para editar ou resolver alertas

**Como Usar:**
1. Visualize todos os alertas do sistema
2. Clique em alerta para ver detalhes completos
3. Edite se informação estiver incorreta
4. Marque como resolvido quando problema for corrigido

---

## 🛠️ Recursos e Funcionalidades

### 📍 **Integração com API ViaCEP**
- Validação automática de CEPs brasileiros
- Retorna informações de endereço
- Endpoint: `https://viacep.com.br/ws/{CEP}/json/`

### 🗺️ **Mapas Interativos (Leaflet)**
- Visualização de rotas em mapa
- Marcadores de estações
- Roteamento automático entre pontos
- Integração com OpenStreetMap

### 📱 **Design Mobile-First**
- Interface otimizada para celulares
- Responsiva para tablets e desktops
- Ícones Font Awesome
- Animações suaves

### 🔒 **Sistema de Segurança**
- Autenticação de usuário
- Sessões protegidas
- Preparação de statements SQL (prevenção de SQL Injection)
- Validação de dados no cliente e servidor

### 📊 **Auditoria**
- Log de ações de usuários
- Registro de atualizações
- Rastreamento de erros

---

## 🔐 Segurança e Validações

### Validações Implementadas

#### CPF
```
Algoritmo de validação brasileiro
- Valida dígitos verificadores
- Rejeita CPFs conhecidamente inválidos
```

#### Telefone
```
Formato: (XX) XXXX-XXXX ou (XX) XXXXX-XXXX
- 10 dígitos: telefone fixo
- 11 dígitos: celular
```

#### Email
```
Validação de formato
- Presença de @
- Domínio válido
```

#### CEP
```
Validação via API ViaCEP
- Consulta banco de dados de CEPs brasileiros
- Retorna false se CEP não existir
```

#### Endereço
```
- Mínimo de 5 caracteres
- Rejeita campos vazios
```

### Proteções Implementadas

- **SQL Injection:** Uso de prepared statements
- **XSS (Cross-Site Scripting):** Sanitização com htmlspecialchars
- **Session Hijacking:** Regeneração de ID após login
- **Força Bruta:** Sistema de login simples (implementar rate limiting recomendado)

---

## 📋 Fluxos Principais

### Fluxo de Login

```
1. Usuário acessa index.php
2. Insere credenciais
3. Sistema verifica no banco de dados
4. Se válido:
   - Verifica cargo (ADM ou FUNC)
   - Redireciona para dashboard apropriado
5. Se inválido:
   - Exibe mensagem de erro
   - Permite nova tentativa
```

### Fluxo de Cadastro de Rota (Admin)

```
1. Admin acessa Dashboard Admin
2. Clica em "Cadastrar Rota"
3. Seleciona estações de origem e destino
4. Insere distância e tempo
5. Clica "Cadastrar"
6. Rota é salva no banco de dados
7. Aparece automaticamente para funcionários
```

### Fluxo de Consulta de Rotas (Funcionário)

```
1. Funcionário acessa Dashboard
2. Clica em "Rotas"
3. Se rotas existem:
   - Lista é carregada do banco
   - Clica para expandir detalhes
   - Visualiza mapa interativo
4. Se sem rotas:
   - Vê imagem ferrorama.png
   - Mensagem explicativa
```

---

## 🐛 Troubleshooting

### Problema: "Usuário ou senha incorretos"
**Solução:**
- Verifique capitalização do usuário
- Certifique-se de que a senha está correta
- Se esqueceu, clique em "Esqueceu a senha?"

### Problema: Mapa não aparece em Rotas
**Solução:**
- Verifique conexão com internet
- Aguarde carregamento do OpenStreetMap
- Limpe cache do navegador (Ctrl+Shift+Delete)

### Problema: CEP não é validado
**Solução:**
- Verifique se o CEP existe no Brasil
- Use formato correto: XXXXX-XXX
- A API ViaCEP pode estar indisponível (tente depois)

### Problema: Dados não salvam em "Meus Dados"
**Solução:**
- Verifique se todos os campos estão preenchidos
- Valide CPF e Email
- Certifique-se de que CPF/Email não estão cadastrados para outro usuário

### Problema: Alertas não aparecem
**Solução:**
- Admin precisa criar alerta primeiro em "Cadastrar Alerta"
- Verifique se alerta foi criado para rota ativa
- Atualize página (F5)

### Problema: Erro de Banco de Dados
**Solução:**
- Verifique se servidor MySQL está rodando
- Valide credenciais em `db.php`
- Execute `banco.sql` para criar tabelas
- Verifique conexão com localhost

---

## 📞 Suporte

Para dúvidas ou problemas:
1. Consulte a seção [Troubleshooting](#troubleshooting)
2. Verifique logs no navegador (F12 → Console)
3. Contate o administrador do sistema

---

## 📝 Notas Importantes

- ⚠️ **Backup Regular:** Faça backup do banco de dados regularmente
- ⚠️ **Senhas Fortes:** Use senhas com 8+ caracteres ao criar usuários
- ⚠️ **Manutenção:** Revise alertas resolvidos periodicamente
- ⚠️ **Atualização de Dados:** Mantenha rotas e estações atualizadas
- ✅ **Mobile First:** Aplicação otimizada para dispositivos móveis

---

**Última Atualização:** Novembro 2025  
**Versão do Sistema:** 1.0
