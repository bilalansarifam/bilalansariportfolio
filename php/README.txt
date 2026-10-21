CONTACT FORM SETUP

The form posts to send-mail.php and uses PHP's mail() function. No SMTP password is stored in the project.

If your hosting provider supports PHP mail(), upload the project and test the contact form.
If SMTP is required, install/configure PHPMailer or another SMTP library on the server and keep credentials outside public source files (environment variables or hosting secrets).
