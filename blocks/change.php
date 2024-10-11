<?php
// Получим и обработаем данные со страницы профиля при изменении личных данных
require_once 'blocks/partData.php';
require_once 'blocks/partValidation.php';
require_once 'blocks/partCheck.php';

// Если форма для изменения данных профиля отправлена...
if (!empty($_POST["submit_profile"])) {
    // Если не заполнено хотя бы одно из необходимых полей:
    if (empty($login) || empty($phone) || empty($email)) {
        $message = '<span class="message message_bottom">Все поля обязательны к заполнению!<br></span>';
	// Если форма регистрации отправлена со всеми заполненными обязательными полями:
    } else {
        $time = time();
        $data = date("Y-m-d H:i:s", $time);

        // Проверим все поля кроме последнего на корректность ввода данных:
        $valid = validateFields($login, $phone, $email, $password, $message1, $message2, $message3, $message4, $message5);

        // Если поля прошли проверку на корректность:
        if ($valid) {
            // Пароль и подтверждение совпадают - двигаемся дальше
            if ($password_chars == $confirm_chars) {
                // Проверим, не существуют ли уже введённые данные в БД у других пользователей:
                $id = $_SESSION['id'];
				$check = checkUser($link, $login_chars, $phone_chars, $email_chars, $id, $message1, $message2, $message3);
                
                // Если другого пользователя с такими учётными данными не существует - вносим новые данные в БД:
                if ($check) {
                    // Если пользователь решил не менять пароль, оставив соответствующие поля пустыми
                    if (empty($password_chars)) {
                        // Формируем и отсылаем SQL запрос:
                        $query = "UPDATE `users` SET `login` = '$login_chars', `phone` = '$phone_chars',
								`email` = '$email_chars' WHERE `id` = '$id'";
                        mysqli_query($link, $query);
                    } else {
                        $hashed_password = password_hash($password_chars, PASSWORD_DEFAULT);
                        // Формируем и отсылаем SQL запрос:
                        $query = "UPDATE `users` SET `login` = '$login_chars', `phone` = '$phone_chars',
								`email` = '$email_chars', `password` = '$hashed_password' WHERE `id` = '$id'";
                        mysqli_query($link, $query);
                    }

                    // Пишем в сессию новые данные профиля:
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
