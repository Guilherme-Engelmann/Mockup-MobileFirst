# TODO: Implementar Cadastro e Visualização de Rotas, Linhas e Trens para Administrador

## Passos a Executar

1. **Modificar index.php** - Alterar redirecionamento para admin ir para admin_dashboard.php em vez de cadastro.php. ✅

2. **Criar admin_dashboard.php** - Dashboard para admin com links para:
   - Cadastrar/Listar Estações
   - Cadastrar/Listar Rotas
   - Cadastrar/Listar Trens ✅

3. **Criar criar_estacao.php** - Formulário para inserir estações (nome, latitude, longitude, tipo). ✅

4. **Criar criar_rota.php** - Formulário para inserir rotas (estacaoOrigem, estacaoDestino, nomeRota, distanciaTotal, tempoMedioPercurso). ✅

5. **Criar criar_trem.php** - Formulário para inserir trens (numero_serie, modeloTrem, data_fabricacao, capacidade_passageiros, capacidade_carga, status_operacional). ✅

6. **Criar listar_estacoes.php** - Página para listar todas as estações cadastradas. ✅

7. **Criar listar_rotas.php** - Página para listar todas as rotas cadastradas. ✅

8. **Criar listar_trens.php** - Página para listar todos os trens cadastrados. ✅

9. **Modificar rotas.php** - Carregar rotas do banco em vez de hardcoded. ✅

10. **Modificar statusTrans.php** - Carregar trens do banco em vez de hardcoded. ✅

11. **Testar inserções e listagens** - Verificar se dados são salvos e exibidos corretamente.

12. **Verificar permissões** - Garantir que apenas admin acesse admin_dashboard e páginas relacionadas (usar sessões). ✅
