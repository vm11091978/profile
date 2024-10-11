<?php
// Получим и обработаем данные со страницы регистрации или со страницы профиля пользователя

if (!empty($_POST["login"])) {
    $login = trim($_POST["login"]);
    $login_chars = htmlspecialchars($login);
} else {
    $login_chars = '';
}
if (!empty($_POST["phone"])) {
    // Если пользователь забыл поставить '+' перед номером телефона, исправим это
    $phone = '+'.ltrim(trim($_POST["phone"]), '+');
    $phone_chars = htmlspecialchars($phone);
} else {
    $phone_chars = '';
}
if (!empty($_POST["email"])) {
    $email = trim($_POST["email"]);
    $email_chars = htmlspecialchars($email);
} else {
    $email_chars = '';
}
if (!empty($_POST["password"])) {
    $password = trim($_POST["password"]);
    $password_chars = htmlspecialchars($password);
} else {
    $password_chars = '';
}
if (!empty($_POST["confirm"])) {
    $confirm = trim($_POST["confirm"]);
    $confirm_chars = htmlspecialchars($confirm);
} else {
    $confirm_chars = '';
}

$message1 = '';
$message2 = '';
$message3 = '';
$message4 = '';
$message5 = '';
$message6 = '';
$message = '';
