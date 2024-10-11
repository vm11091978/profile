<?php
// Проверим все поля кроме последнего на корректность ввода данных

function validateFields($login, $phone, $email, $password, &$message1, &$message2, &$message3, &$message4, &$message5)
{
    if (!preg_match("#^[0-9a-zA-Zа-яА-ЯёЁ]+$#u", $login)) {
        $message1 = '<span class="message">Логин должен содержать только буквы и цифры!</span><br>';
    }
    if (!preg_match("#^\+?[0-9]+$#", $phone)) {
        $message2 = '<span class="message">Номер телефона должен содержать только цифры!</span><br>';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message3 = '<span class="message">Некорректно введён email!</span><br>';
    }
    if (!empty($password)) {
        if (!preg_match("#^[0-9a-zA-Z]+$#", $password)) {
            $message4 = '<span class="message">Пароль должен содержать только цифры и латинские буквы!</span><br>';
        }
        if (!preg_match("#^.{4,60}$#", $password)) {
            $message5 = '<span class="message">Пароль должен иметь длинну от 4 до 60 символов!</span><br>';
        }
    }
    if (empty($message1) && empty($message2) && empty($message3) && empty($message4) && empty($message5)) {
        return true;
    } else {
        return false;
    }
}
