<?php
define('SMARTCAPTCHA_SERVER_KEY', '');

// Получим и обработаем данные со страницы авторизации

// В поле "login_enter" может быть введён е-майл или телефон 
if (!empty($_POST["login_enter"])) {
    $login_enter = trim($_POST["login_enter"]);
    $login_enter_chars = htmlspecialchars($login_enter);
} else {
    $login_enter_chars = '';
}
if (!empty($_POST["password_enter"])) {
    $password_enter = trim($_POST["password_enter"]);
    $password_enter_chars = htmlspecialchars($password_enter);
} else {
    $password_enter_chars = '';
}

if (!empty($_POST["token"])) {
    $token = $_POST["token"];
    if (check_captcha($token)) {
        // echo "Passed\n";
        $captcha_check = true; 
    } else {
        // echo "Robot\n";
        $captcha_check = '';
    }
} else {
    $captcha_check = '';
}

function check_captcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP пользователя.
                                         // Как правильно получить IP зависит от вашего прокси.
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        // echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}

$message_login = '';
$message_password = '';
$message_enter = '';

function checkLogin($link, $phone_or_email, $login_enter_chars, $password_enter_chars)
{
    // чтобы узнать данные пользователя по его "login_enter" формируем и отсылаем SQL запрос:
    $query = "SELECT * FROM `users` WHERE `$phone_or_email` = '$login_enter_chars'";
    $result = mysqli_query($link, $query);
    // Преобразуем ответ из БД в нормальный массив PHP:
    $user_data = mysqli_fetch_assoc($result);

    if (!empty($user_data) && password_verify($password_enter_chars, $user_data['password'])) {
        // Если пользователь прошёл авторизацию, пишем в сессию пометку об авторизации и данные профиля:
        $flash = '<p>Вы успешно авторизованы!</p>';
        $_SESSION['auth'] = true;
        $_SESSION['flash'] = $flash;
        $_SESSION['id'] = $user_data['id'];
        $_SESSION['login'] = $user_data['login'];
        $_SESSION['phone'] = $user_data['phone'];
        $_SESSION['email'] = $user_data['email'];

        header('Location: /profile');
    } else {
        // Пользователь неверно ввёл логин или пароль:
        $message_enter = '<span class="message message_bottom">Неправильный логин и/или пароль!
				Доступ запрещён!<br></span>';
        return $message_enter;
    }
}

// Если форма авторизации отправлена при пройденной капче
if (!empty($_POST["submit_auth"]) && $captcha_check == true) {
	if (empty($login_enter)) {
		$message_login = '<span class="message">Вы не ввели логин!<br></span>';
	} elseif (empty($password_enter)) {
		$message_password = '<span class="message">Вы не ввели пароль!<br></span>';
	} else {
        if (preg_match("#^\+?[0-9]+$#", $login_enter)) {
            // Значит, пользователь пытается залогиниться с помощью номера телефона
            // Если пользователь забыл поставить '+' перед номером телефона, исправим это
            $phone = '+'.ltrim(trim($login_enter_chars, '+'));
            $message_enter = checkLogin($link, 'phone', $phone, $password_enter_chars);
        } elseif (filter_var($login_enter, FILTER_VALIDATE_EMAIL)) {
            // Значит, пользователь пытается залогиниться с помощью адреса е-майл
            $message_enter = checkLogin($link, 'email', $login_enter_chars, $password_enter_chars);
        } else {
            // Иначе пользователь ввёл какую-то абракадабру
            $message_enter = '<span class="message message_bottom">
					Вы ввели некорректный е-майл или номер телефона!<br></span>';
        }
	}
}
