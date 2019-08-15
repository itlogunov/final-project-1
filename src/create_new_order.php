<?php

$name = trim(htmlspecialchars($_POST['name']));
$phone = trim(htmlspecialchars($_POST['phone']));
$email = trim(htmlspecialchars($_POST['email']));
$street = trim(htmlspecialchars($_POST['street']));
$home = trim(htmlspecialchars($_POST['home']));
$part = trim(htmlspecialchars($_POST['part']));
$appt = trim(htmlspecialchars($_POST['appt']));
$floor = trim(htmlspecialchars($_POST['floor']));
$comment = trim(htmlspecialchars($_POST['comment']));
$payment = (!empty($_POST['payment'])) ? trim(htmlspecialchars($_POST['payment'])) : false;
$callback = (!empty($_POST['callback'])) ? 1 : false;

$arrErrors = [];
if ($name && $phone && $email && $street && $home) {

    require_once 'init.php';

    if (!$arrUser = getUserByEmail($email)) {
        if (!$arrUser = registerUser($email, $name, $phone)) {
            $arrErrors[] = 'Пользователь не был создан!';
        }
    }

    if ($arrUser) {
        $arrAddress = [
            'street' => $street,
            'home' => $home,
            'part' => $part,
            'appt' => $appt,
            'floor' => $floor
        ];
        $orderId = createNewOrder($arrUser, $arrAddress, $comment, $payment, $callback);
        if ($orderId) {
            $message = 'Заказ №' . $orderId . PHP_EOL;
            $message .= 'Состав заказа: DarkBeefBurger за 500 рублей, 1 шт' . PHP_EOL;

            $address = 'ул. ' . $street . ', д. ' . $home;
            $address .= ($part) ? 'к' . $part : '';
            $address .= ($appt) ? ', кв. ' . $appt : '';
            $address .= ($floor) ? ', эт. ' . $floor : '';
            $message .= 'Ваш заказ будет доставлен по адресу: ' . $address . PHP_EOL;

            $ordersCount = getOrdersCountByUser($arrUser);
            if ($ordersCount == 1) {
                $message .= 'Спасибо – это Ваш первый заказ';
            } else {
                $message .= 'Спасибо! Это уже ' . $ordersCount . ' заказ';
            }

            sendMail($email, 'Заказ №' . $orderId, $message);
            if (file_exists('../mails/')) {
                file_put_contents('../mails/' . str_replace(' ', '_', date('d.m.Y H:i:s') . '.log'), $message);
            }
        }
    }
}

echo json_encode([
    'order' => $orderId ?? 0,
    'errors' => implode(', ', $arrErrors)
]);
