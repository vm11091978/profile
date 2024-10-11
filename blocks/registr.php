<?php
// Получим и обработаем данные со страницы регистрации
require_once 'blocks/partData.php';
require_once 'blocks/partValidation.php';
require_once 'blocks/partCheck.php';

// Если форма регистрации отправлена...
if (!empty($_POST["submit_registr"])) {
    // Если не заполнено хотя бы одно поле:
    if (empty($login) && empty($phone) && empty($email) && empty($password) && empty($confirm)) {
        $message = '<span class="message message_bottom">Все поля обязательны к заполнению!<br></span>';
    // Если форма регистрации отправлена со всеми заполненными обязательными полями:
    } else {
        // Проверим все поля кроме последнего на корректность ввода данных:
		$valid = validateFields($login, $phone, $email, $password, $message1, $message2, $message3, $message4, $message5);

        // Если поля прошли проверку на корректность:
        if ($valid) {
            // Пароль и подтверждение совпадают - двигаемся дальше
            if ($password_chars == $confirm_chars) {
                // Проверим, не существуют ли уже введённые данные в БД у других пользователей
                $id = 0;
                $check = checkUser($link, $login_chars, $phone_chars, $email_chars, $id, $message1, $message2, $message3);

                // Если пользователя с такими учётными данными не существует в БД - регистрируем его:
                if ($check) {
                    $hashed_password = password_hash($password_chars, PASSWORD_DEFAULT);
                    // Формируем и отсылаем SQL запрос:
                    $query = "INSERT INTO `users` SET `login` = '$login_chars', `phone` = '$phone_chars',
							`email` = '$email_chars', `password` = '$hashed_password'";
                    mysqli_query($link, $query);
                    $id = mysqli_insert_id($link);

                    // Пишем в сессию пометку об авторизации и данные профиля:
                    $flash = '<p>Вы успешно зарегестрированы!</p>';
                    $_SESSION['auth'] = true;
                    $_SESSION['flash'] = $flash;
                    $_SESSION['id'] = $id;
                    $_SESSION['login'] = $login_chars;
                    $_SESSION['phone'] = $phone_chars;
                    $_SESSION['email'] = $email_chars;

                    header('Location: /profile');
                }
            } else {
                // Пароль и подтверждение НЕ совпадают - выведем сообщение:
                $message6 = '<span class="message">Ошибка! Пароль и его подтверждение не совпадают!<br></span>';
            } 
        }
    }
}
