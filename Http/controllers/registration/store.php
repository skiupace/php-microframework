<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
if (!Validator::email($email)) {
  $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 8, 32)) {
  $errors['password'] = 'Please provide a password of at least 8 characters.';
}

if (!empty($errors)) {
  return view('registration/create.view.php', [
    'errors' => $errors
  ]);
}

$db = App::resolve(Database::class);
$user = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $email
])->fetch();

if (!$user) {
  $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
    'email'     => $email,
    'password'  => password_hash($password, PASSWORD_BCRYPT)
  ]);

  login($user);

  header('location: /');
  exit();
}

return view('registration/create.view.php', [
  'errors' => [
    'email' => 'This email address already exists!'
  ]
]);
