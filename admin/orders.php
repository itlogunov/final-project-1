<?php

require '../src/functions.php';

$arrOrders = [];
$dbConnection = getConnection();
foreach ($dbConnection->query('SELECT `orders`.*, `users`.`email`, `users`.`name`, `users`.`phone` FROM `orders` LEFT JOIN `users` ON users.id = orders.user_id GROUP BY `orders`.`id`') as $row) {
    $arrOrders[] = $row;
}
if (!empty($arrOrders)): ?>
    <h1>Список заказов</h1>
    <table>
        <tr>
            <td>order id</td>
            <td>email</td>
            <td>name</td>
            <td>phone</td>
            <td>street</td>
            <td>home</td>
            <td>part</td>
            <td>appt</td>
            <td>floor</td>
            <td>comment</td>
            <td>payment</td>
            <td>callback</td>
        </tr>
        <? foreach ($arrOrders as $arrUser): ?>
            <tr>
                <td><?= $arrUser['id']; ?></td>
                <td><?= $arrUser['email']; ?></td>
                <td><?= $arrUser['name']; ?></td>
                <td><?= $arrUser['phone']; ?></td>
                <td><?= $arrUser['street']; ?></td>
                <td><?= $arrUser['home']; ?></td>
                <td><?= $arrUser['part']; ?></td>
                <td><?= $arrUser['appt']; ?></td>
                <td><?= $arrUser['floor']; ?></td>
                <td><?= $arrUser['comment']; ?></td>
                <td><?= $arrUser['payment']; ?></td>
                <td><?= $arrUser['callback']; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
<? else: ?>
    <h1>Заказов нет</h1>
<? endif; ?>
