# TODO: Align User Registration and Login Systems

## Database Fixes
- [x] Update Usuarios table in banco.sql: Change fields to nomeUsuario, Senha, tipoUsuario, email, ultimoLogin; add index on nomeUsuario.

## Sign-Up (inscreverse.php)
- [x] Update PHP: Align fields to nomeUsuario, Senha (hashed), tipoUsuario, email; add duplicate checks for nomeUsuario/email; map cargo to admin/funcionario.
- [x] HTML/JS: Already functional.

## Admin Registration (cadastro.php)
- [x] Update PHP: Add email field, password hashing, duplicate checks, align fields/schema, map cargo.
- [x] Update HTML: Add mobile-first structure, CSS, icons, JS validation to match inscreverse.php.

## Login (login.php)
- [x] Update PHP: Use db.php for connection, improve error handling with $login_msg.
- [x] Update HTML: Add full mobile-first structure, form with icons, links to forgot password and sign-up.

## CSS (style.css)
- [ ] Verify/add styles for .login-bg, .login-content, .login-card, .message.error, .forgot-link, .signup-link if missing.

## Testing
- [ ] Apply banco.sql changes to database (run SQL or migrate existing data).
- [ ] Test sign-up via inscreverse.php: Register user, verify hashed password in DB, login works.
- [ ] Test admin registration via cadastro.php: Ensure only logged-in users can access, new users can login.
- [ ] Test login: Proper redirects, error messages displayed.
- [ ] Verify all layouts in browser for mobile responsiveness.
