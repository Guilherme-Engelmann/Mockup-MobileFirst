# TODO: Implement CRUD Operations for User Data in meusDados.php with API Validation

## Tasks
- [x] Update banco.sql: Add telefone, cpf, endereco, cep columns to Usuarios table and create Auditoria table for logging.
- [x] Update migrate_usuarios.sql: Add ALTER TABLE statements for new columns.
- [x] Create html/api_validators.php: Implement validation functions for CPF, telefone, CEP (using ViaCEP API), endereco.
- [x] Modify html/meusDados.php: Add PHP backend to fetch user data, populate form, handle POST updates with validation, save to DB, log audit.
- [x] Update README.md: Explain API used (ViaCEP), endpoints, and testing instructions.
- [ ] Test: Run migration, access meusDados.php as logged-in user, submit form with valid/invalid data, check DB updates and audit logs.
