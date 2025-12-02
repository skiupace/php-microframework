<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user_id = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $_SESSION['user']['email']
])->fetch()['id'];

$notes = $db->query('SELECT * FROM notes WHERE user_id = 1')->fetchAll();

view('notes/index.view.php', [
  'heading' => 'My Notes',
  'notes'   => $notes
]);
