# TODO: Implementar Criptografia de Senhas

## Tarefas Pendentes
- [x] Editar html/inscreverse.php para criptografar senha com password_hash antes de inserir no banco
- [x] Editar html/cadastro.php para criptografar senha com password_hash antes de inserir no banco
- [x] Editar html/index.php para usar password_verify na verificação de login
- [ ] Testar funcionalidade de cadastro e login após mudanças

## Arquivos Afetados
- html/inscreverse.php
- html/cadastro.php
- html/index.php

## Notas
- A tabela Usuarios no banco já suporta hashes (VARCHAR(255))
- html/create.php já implementa corretamente
- Usar PASSWORD_DEFAULT para hashing
