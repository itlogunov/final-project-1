<?php

require_once '../src/init.php';

$users = [];
$dbConnection = getConnection();
foreach ($dbConnection->query('SELECT * FROM `users`') as $row) {
    $users[] = $row;
}

echo $twig->render('admin/users.twig', compact('users'));
