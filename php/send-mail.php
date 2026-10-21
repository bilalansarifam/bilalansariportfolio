<?php
// Contact handler for the portfolio.
// Configure PHP mail() on the hosting server. No SMTP password is stored here.

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.html#contact');
    exit;
}

if (!empty($_POST['company'] ?? '')) {
    header('Location: ../index.html?status=success#contact');
    exit;
}

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

$name = preg_replace('/[\r\n]+/', ' ', $name);
$email = preg_replace('/[\r\n]+/', '', $email);
$message = preg_replace('/\r\n|\r/', "\n", $message);

if ($name === '' || mb_strlen($name) > 80 || $message === '' || mb_strlen($message) > 2000 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../index.html?status=error#contact');
    exit;
}

$recipient = 'saifullahiqbal976@gmail.com';
$subject = 'Portfolio Contact — ' . $name;
$body = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}";
$server = preg_replace('/[^a-zA-Z0-9.\-]/', '', $_SERVER['SERVER_NAME'] ?? 'localhost');
$headers = "From: Portfolio <no-reply@{$server}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($recipient, $subject, $body, $headers);

header('Location: ../index.html?status=' . ($sent ? 'success' : 'error') . '#contact');
exit;
