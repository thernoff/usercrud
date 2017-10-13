<h1 class="text-center"><?=$title;?></h1>
<?php if (count($errors) > 0): ?>
    <?php foreach($errors as $error): ?>
        <div class="alert alert-danger" role="alert"><?=$error; ?></div>
    <?php endforeach; ?>
<?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="login">Логин<sup>*</sup></label>
        <input type="text" class="form-control" id="login" name="login" placeholder="Логин" value="<?= $user->login; ?>">
    </div>
    <div class="form-group">
        <label for="firstname">Имя<sup>*</sup></label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Иван" value="<?= $user->firstname; ?>">
    </div>
    <div class="form-group">
        <label for="lastname">Фамилия<sup>*</sup></label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Иванов" value="<?= $user->lastname; ?>">
    </div>
    <div class="form-group">
        <label for="email">Email<sup>*</sup></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $user->email; ?>">
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
    </div>
    <div class="form-group">
        <label for="image">Выберите изображение</label>
        <input type="file" id="image" name="image" />
    </div>
    <?php if($user->image): ?>
        <div class="form-group">
            <p>Текущее изображение:<br/> <img width = "200px" src="/assets/upload/user/thumb/<?=$user->image;?>"></p>
            <input type="hidden" name="image" value="<?php echo $user->image; ?>">
        </div>
    <?php else: ?>
        <div class="form-group">
            <p>Текущее изображение:<br/> <img src="./assets/images/no-image.jpg" alt="Без фотографии"></p>
        </div>
    <?php endif; ?>
    <?php if($currentUser && $currentUser->isAdmin()): ?>
        <div class="form-group">
            <label class="radio-inline">
                <input type="radio" name="roleId" value="1" <?php if($user->roleId == 1){echo "checked";} ?>> Администратор
            </label>
            <label class="radio-inline">
                <input type="radio" name="roleId" value="2" <?php if($user->roleId == 2){echo "checked";} ?>> Пользователь
            </label>
        </div>
    <?php endif; ?>
    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
    <a class="btn btn-warning" href="/" role="button">Отмена</a>
    <button type="submit" class="btn btn-default" name="submitUpdate" value="Сохранить">Сохранить</button>
</form>