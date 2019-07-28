<?php

require '../src/functions.php';

$arrUsers = [];
$dbConnection = getConnection();
foreach ($dbConnection->query('SELECT * FROM `users`') as $row) {
    $arrUsers[] = $row;
}
if (!empty($arrUsers)): ?>
    <h1>Список пользователей</h1>
    <table>
        <tr>
            <td>id</td>
            <td>email</td>
            <td>name</td>
            <td>phone</td>
        </tr>
        <? foreach ($arrUsers as $arrUser): ?>
            <tr>
                <td><?= $arrUser['id']; ?></td>
                <td><?= $arrUser['email']; ?></td>
                <td><?= $arrUser['name']; ?></td>
                <td><?= $arrUser['phone']; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
<? else: ?>
    <h1>Пользователей нет</h1>
<? endif; ?>