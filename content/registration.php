<h2>Что бы продолжить, зарегистрируйтесь</h2>
<p>Или вернитесь на главную: <a href="/">вернуться</a></p>

<p>
    Сначала придумайте логин<br>
    Логин должен состоять из цифр и/или русских и латинских букв<br>
    Пароль должен состоять из цифр и/или латинских букв<br>
    Буквы могут быть как заглавными, так и прописными<br>
    Использование других символов в логине и пароле не допускается<br>
    Пароль должен иметь длинну не менее 4 символов, но не более 60<br>
    Все поля обязательны к заполнению<br>
</p>

<div class="form">
    <form method="POST">
        Придумайте логин:<br>
        <?=$message1?>
        <input name="login" type="text" placeholder="login" value="<?=$login_chars?>"><br>
        Введите свой телефон, в формате +71234567890, только цифры (без скобок и дефисов):<br>
        <?=$message2?>
        <input name="phone" type="text" placeholder="phone" value="<?=$phone_chars?>"><br>
        Укажите свой e-mail:<br>
        <?=$message3?>
        <input name="email" type="text" placeholder="e-mail" value="<?=$email_chars?>"><br>
        Придумайте пароль:<br>
        <?=$message4?>
        <?=$message5?>
        <input name="password" type="password" placeholder="password" value="<?=$password_chars?>"><br>
        Введите пароль ещё раз:<br>
        <?=$message6?>
        <input name="confirm" type="password" placeholder="password" value="<?=$confirm_chars?>"><br>
        <?=$message?>
        <input name="submit_registr" type="submit" value="Зарегестрироваться"><br>
    </form><br>
</div>
