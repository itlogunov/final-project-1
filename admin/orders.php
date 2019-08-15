<?php

require_once '../src/init.php';

$orders = [];
$dbConnection = getConnection();
foreach ($dbConnection->query('SELECT `orders`.*, `users`.`email`, `users`.`name`, `users`.`phone` FROM `orders` LEFT JOIN `users` ON users.id = orders.user_id GROUP BY `orders`.`id`') as $row) {
    $orders[] = $row;
}

echo $twig->render('admin/orders.twig', compact('orders'));
