<?=$flash?>
<?php $_SESSION['flash'] = ''; ?>
<p>Эта страница видна только вам</p>
<br>

<h2>Данные вашего профиля:</h2>
<p>Логин: <?=$login?></p>
<p>Телефон: <?=$phone?></p>
<p>Е-майл: <?=$email?></p>

<form method="POST" action="/">
    <input style="font-size: 16px; margin: 10px 0; " name="logout" type="submit" value="Выйти">
</form>
<br>

<h2>Редактировать личные данные:</h2>

<div class="form">
    <form method="POST">
        Логин:<br>
        <?=$message1?>
        <input name="login" type="text" placeholder="login" value="<?=$login?>"><br>
        Телефон:<br>
        <?=$message2?>
        <input name="phone" type="text" placeholder="phone" value="<?=$phone?>"><br>
        Е-майл:<br>
        <?=$message3?>
        <input name="email" type="text" placeholder="e-mail" value="<?=$email?>"><br>
        Если хотите сменить пароль, придумайте новый пароль:<br>
        <?=$message4?>
        <?=$message5?>
        <input name="password" type="password" placeholder="password" value=""><br>
        Введите новый пароль ещё раз:<br>
        <?=$message6?>
        <input name="confirm" type="password" placeholder="password" value=""><br>
        <?=$message?>
        <input name="submit_profile" type="submit" value="Сохранить"><br>
    </form><br>
</div>
