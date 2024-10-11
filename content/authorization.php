<h2>Что бы продолжить, войдите</h2>
<p>Или вернитесь на главную: <a href="/">вернуться</a></p>

<div
    style="height: 100px"
    id="captcha-container"
    class="smart-captcha"
    data-sitekey="ysc1_RJWSCSOOS39nQdDb6NdaMLPTlvzmjdnpu1LnRylQ67b73c19"
></div>

<div class="form">
    <form method="POST">
        <input type="hidden" id="token" name="token" value="" />
        Введите свой е-майл или телефон в формате +71234567890 (только цифры, без скобок и дефисов):<br>
        <?=$message_login?>
        <input name="login_enter" type="text" placeholder="e-mail or phone" value="<?=$login_enter_chars?>"><br>
        Введите пароль:<br>
        <?=$message_password?>
        <input name="password_enter" type="password" placeholder="password" value="<?=$password_enter_chars?>"><br>
        <?=$message_enter?>
        <input name="submit_auth" style="display: none" type="submit" value="Войти">
        <p id="continue">Чтобы войти, пройдите капчу</p>
    </form><br>
</div>

<script>
    let flag = 0;
    setInterval(function() {
        // Если (когда) загрузилась форма капчи на страницу авторизации:
        if (flag == 0 && document.querySelector('input[name=smart-token]')) {
            // Значение в скрытом инпуте появляется, когда пользователь "поставил галочку":
            if (document.querySelector('input[name=smart-token]').value) {
                let token_value = document.querySelector('input[name=smart-token]').value;
                document.getElementById("token").value = token_value;
                document.getElementById("continue").style.visibility='hidden';
                document.querySelector('input[name=submit_auth]').removeAttribute('style');
                flag = 1;
                console.log(token_value);
            }
        }
    }, 200);
</script>
