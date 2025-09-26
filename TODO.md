# TODO: Align User Registration and Login Systems

## Database Fixes
- [x] Revert Usuarios table in banco.sql to original: username, senha, cargo, email, ultimo_login; table usuarios.

## Sign-Up (inscreverse.php)
- [x] Update PHP: Match cadastro.php - plain text senha, no email, insert username, senha, cargo; redirect to index.php.
- [x] Update HTML: Simple form like cadastro.php, back to index.php.

## Admin Registration (cadastro.php)
- [x] Revert to original: Plain text senha, no email, session check for user_pk, display username.

## Forgot Password (esqueceuasenha.php)
- [x] Update query: Use usuarios table, SELECT pk FROM usuarios WHERE email = ?

## Login (index.php)
- [x] Update to use usuarios table, plain text senha, session user_pk, username.

## Login (login.php)
- [x] Deleted as per user request; login handled in index.php.

## Testing
- [ ] Apply banco.sql changes to database (drop and recreate table if needed).
- [ ] Test sign-up via inscreverse.php: Register user, verify plain password in DB, login via index.php works.
- [ ] Test admin registration via cadastro.php: Ensure only logged-in users can access, new users can login.
- [ ] Test forgot password: Check email validation and response.
- [ ] Verify all layouts in browser for mobile responsiveness.
