<?php
// Устанавливаем доступы к базе данных:
    $host = 'localhost';
	$user = 'root';
	$password = '';
	$db_name = 'profile';

// Соединяемся с базой данных используя наши доступы:
    $link = mysqli_connect($host, $user, $password, $db_name);

// Устанавливаем кодировку (не обязательно, но поможет избежать проблем):
    mysqli_query($link, "SET NAMES 'utf8'");
