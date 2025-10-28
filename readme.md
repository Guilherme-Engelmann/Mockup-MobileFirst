Passo 1:
Ao abrir na tela de login, entre com seu email e senha. Caso não tenha uma conta, clique em criar uma conta. Caso tenha esquecido sua senha, clique em esqueceu sua senha.

Passo 2: Agora você estará no dashboard geral. Nele você terá opções de páginas para poder consultar variadas informações, como rotas, velocidade, Status trens, chat, calendário, entre outros.

Passo 3: Escolha a opção que você procura e consulte as informações desejadas

## API de Validação de Dados

### API Utilizada: ViaCEP
- **Descrição**: API gratuita para consulta de CEPs brasileiros, fornecendo informações de endereço.
- **Endpoint**: `https://viacep.com.br/ws/{CEP}/json/`
- **Exemplo de Uso**: Para validar CEP 01001000, chama `https://viacep.com.br/ws/01001000/json/`
- **Resposta**: JSON com campos como logradouro, bairro, cidade, uf, etc. Se CEP inválido, retorna `{"erro": true}`.

### Validações Implementadas
- **CPF**: Algoritmo de validação brasileiro (dígitos verificadores).
- **Telefone**: Formato brasileiro (10-11 dígitos).
- **Email**: Validação básica de formato.
- **Endereço**: Comprimento mínimo.
- **CEP**: Consulta na API ViaCEP para verificar existência.

### Como Testar
1. Faça login no sistema.
2. Acesse a página "Meus Dados".
3. Preencha os campos com dados válidos/inválidos.
4. Clique em "Salvar" para testar validações.
5. Verifique mensagens de erro e logs de auditoria no banco.
