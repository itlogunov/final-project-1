<?php

/**
 * @return PDO
 */
function getConnection(): object
{
    try {
        $dbConnection = new PDO('mysql:host=localhost;dbname=final_project_1', 'root', 'root');
    } catch (PDOException $exception) {
        echo 'Error!: ' . $exception->getMessage() . '<br>';
        die();
    }

    return $dbConnection;
}

/**
 * @param PDO $dbConnection
 */
function closeConnection(PDO $dbConnection): void
{
    if ($dbConnection) {
        $dbConnection = null;
    }
}

/**
 * @param string $email
 * @return array
 */
function getUserByEmail(string $email): array
{
    $arrUser = [];

    if ($email) {
        $dbConnection = getConnection();
        $query = $dbConnection->prepare('SELECT * FROM users WHERE email = :email');
        $query->execute([':email' => $email]);
        if ($result = $query->fetchAll(PDO::FETCH_ASSOC)) {
            $arrUser = $result[0];
        }
    }

    return $arrUser;
}

/**
 * @param string $email
 * @param string $name
 * @param string $phone
 * @return array
 */
function registerUser(string $email, string $name, string $phone): array
{
    $arrUser = [];
    if ($email && $name && $phone) {
        $dbConnection = getConnection();
        $query = $dbConnection->prepare('INSERT INTO `users` (`email`, `name`, `phone`) VALUES (?,?,?)');
        if ($query->execute([$email, $name, $phone])) {
            $arrUser = [
                'id' => $dbConnection->lastInsertId(),
                'email' => $email,
                'name' => $name,
                'phone' => $phone
            ];
        }
    }

    return $arrUser;
}

/**
 * @param array $arrUser
 * @param array $arrAddress
 * @param bool $comment
 * @param bool $payment
 * @param bool $callback
 * @return int
 */
function createNewOrder(array $arrUser, array $arrAddress, $comment = false, $payment = false, $callback = false): int
{
    $orderId = 0;
    if ($arrUser && $arrAddress) {
        $dbConnection = getConnection();

        $query = $dbConnection->prepare(
            'INSERT INTO `orders` (`user_id`, `street`, `home`, `part`, `appt`, `floor`, `comment`, `payment`, `callback`) 
                        VALUES (?,?,?,?,?,?,?,?,?)'
        );
        $result = $query->execute([
            $arrUser['id'],
            $arrAddress['street'],
            $arrAddress['home'],
            $arrAddress['part'] ? $arrAddress['part'] : null,
            $arrAddress['appt'] ? $arrAddress['appt'] : null,
            $arrAddress['floor'] ? $arrAddress['floor'] : null,
            $comment,
            $payment,
            $callback ? $callback : null
        ]);
        if ($result) {
            $orderId = $dbConnection->lastInsertId();
        }
    }

    return $orderId;
}

function getOrdersCountByUser(array $arrUser): int
{
    $ordersCount = 0;
    if ($arrUser['id']) {
        $dbConnection = getConnection();
        $query = $dbConnection->prepare('SELECT id FROM orders WHERE user_id = :user_id');
        $query->execute([':user_id' => $arrUser['id']]);
        $ordersCount = $query->rowCount();
    }

    return $ordersCount;
}