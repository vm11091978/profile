<?php
// Проверим, не существуют ли уже введённые данные в БД у других пользователей

function checkUser($link, $login_chars, $phone_chars, $email_chars, $id, &$message1, &$message2, &$message3)
{
    // Пробуем получить юзера с таким логином:
    $user_login = checkAttribute($link, 'login', $login_chars, $id);
    // Пробуем получить юзера с таким телефоном:
    $user_phone = checkAttribute($link, 'phone', $phone_chars, $id);
    // Пробуем получить юзера с таким е-майлом:
    $user_email = checkAttribute($link, 'email', $email_chars, $id);

    if (!empty($user_login)) {
        // Логин занят, выведем сообщение об этом:
        $message1 = '<span class="message">Этот логин занят! Придумайте другой логин!<br></span>';
    }
    if (!empty($user_phone)) {
        // Телефон уже существует в БД, выведем сообщение об этом:
        $message2 = '<span class="message">Этот телефон уже существует в нашей базе.<br>
                Возможно, вы ошиблись при вводе, или регистрировались на нашем сервисе раньше.<br></span>';
    }
    if (!empty($user_email)) {
        // Почта уже существует в БД, выведем сообщение об этом:
        $message3 = '<span class="message">Этот адрес электронной почты уже существует в нашей базе.<br>
                Возможно, вы ошиблись при вводе, или регистрировались на нашем сервисе раньше.<br></span>';
    }
    if (empty($user_login) && empty($user_phone) && empty($user_email)) {
        return true;
    } else {
        return false;
    }
}

function checkAttribute($link, $field, $attribute, $id)
{
    // Пробуем получить ID юзера с таким аттрибутом:
    $query = "SELECT `id` FROM `users` WHERE `id` != '$id' AND `$field` = '$attribute'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);
    return $user;
}
