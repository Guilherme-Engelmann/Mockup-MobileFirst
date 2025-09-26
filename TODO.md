# TODO: Align User Registration and Login Systems

## Database Fixes
- [x] Update Usuarios table in banco.sql: Change fields to nomeUsuario, Senha, tipoUsuario, email, ultimoLogin; add index on nomeUsuario.

## Sign-Up (inscreverse.php)
- [x] Update PHP: Align fields to nomeUsuario, Senha (hashed), tipoUsuario, email; add duplicate checks for nomeUsuario/email; map cargo to admin/funcionario.
- [x] Update navigation: Back button and redirect to index.php instead of login.php.

## Admin Registration (cadastro.php)
- [x] Update PHP: Add email field, password hashing, duplicate checks, align fields/schema, map cargo.
- [x] Update HTML: Add mobile-first structure, CSS, icons, JS validation to match inscreverse.php.

## Forgot Password (esqueceuasenha.php)
- [x] Update navigation: Back button to index.php.
- [x] Update query: Use Usuarios table.

## Login (login.php)
- [x] Deleted as per user request; login handled in index.php.

## CSS (style.css)
- [ ] Verify/add styles for .login-bg, .login-content, .login-card, .message.error, .forgot-link, .signup-link if missing (not needed since login.php deleted).

## Testing
- [ ] Apply banco.sql changes to database (run migrate_usuarios.sql or manual ALTER).
- [ ] Test sign-up via inscreverse.php: Register user, verify hashed password in DB, login via index.php works.
- [ ] Test admin registration via cadastro.php: Ensure only logged-in users can access, new users can login.
- [ ] Test forgot password: Check email validation and response.
- [ ] Verify all layouts in browser for mobile responsiveness.
