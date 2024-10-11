<?php
// ini_set('display_errors', 'off');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
session_start();

require_once 'blocks/connect.php';

// Создадим таблицу с пользователями, если таковой ещё нет
$query = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(60) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8";
mysqli_query($link, $query) or die(mysqli_error($link));

// Если пользователь вышел, уничтожим его сессию
if (!empty($_POST['logout'])) {
    // $_SESSION['auth'] = null;
    session_destroy();
}

$current_url = substr($_SERVER['REQUEST_URI'], 1);

switch ($current_url) {
    case '':
        $content = 'main.php';
        break;
    case 'authorization':
        require_once 'blocks/auth.php';
        $content = 'authorization.php';
        break;
    case 'registration':
        require_once 'blocks/registr.php';
        $content = 'registration.php';
        break;
    case 'profile':
        // Если пользователь попал на эту страницу неавторизованным, отправим его на главную
        if ($_SESSION['auth'] == null) {
            header('Location: /');
        } else {
            // Если пользователь авторизован, покажем ему приватный контент
            require_once 'blocks/change.php';
            $content = 'profile.php';
            if (isset($_SESSION['flash'])) {
                $flash = $_SESSION['flash'];
            } else {
                $flash = '';
            }
            $login = $_SESSION['login'];
            $phone = $_SESSION['phone'];
            $email = $_SESSION['email'];
        }
        break;
    default:
        $content = 'page404.php';
        break;
}

require_once 'content/head.php'
?>
