# TODO: Fix Forgot Password and Sign-Up Screens

## Database Fixes
- [x] Update Usuarios table in banco.sql: Add AUTO_INCREMENT PRIMARY KEY, align fields (username, senha, cargo, email), add index on email.

## Sign-Up (inscreverse.php)
- [x] Update PHP: Add password hashing, email input, validation, error handling, redirect on success.
- [x] Update HTML: Add full structure, CSS link, mobile-first layout (phone-content, header, form card).
- [x] Add JS for client-side validation if needed.

## Forgot Password (esqueceuasenha.php)
- [x] Fix HTML: Remove duplicates, complete structure, fix JS (backBtn, form submit).
- [x] Add PHP backend: Check email, generate token, send email (demo alert), redirect.
- [x] Update layout to match mobile-first design.

## CSS (style.css)
- [x] Add styles for .forgot-password-container and .signup-container: Adapt from login styles (cards, inputs, buttons).
- [x] Ensure mobile responsiveness.

## Testing
- [ ] Test sign-up: Register user, check DB.
- [ ] Test forgot password: Submit email, check response.
- [ ] Verify layouts in browser.
