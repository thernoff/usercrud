<form class="form-signin" role="form" action="index.php?controller=main&action=autorize" method="post">
    <h2 class="form-signin-heading">Авторизуйтесь</h2>
    <?php if ($this->error): ?>
        <div class="alert alert-danger" role="alert"><?=$this->error; ?></div>
    <?php endif; ?>
    <input type="text" class="form-control" name="login" placeholder="Логин" required autofocus>
    <input type="password" class="form-control" name="password" placeholder="Пароль" required>
    <label class="checkbox">
      <input type="checkbox" name="remember" value="remember-me" checked> Запомнить меня
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>