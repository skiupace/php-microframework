<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class); // it equals to -> 'Core\Database'

$currentUserId = 1;

$note = $db->query('SELECT * FROM notes WHERE id = :id', [
  'id' => $_POST['id']
])->fetchOrAbort();

authorize($note['user_id'] === $currentUserId);

$db->query('DELETE FROM notes WHERE id = :id', [
  'id' => $_POST['id']
]);

header('location: /notes');
