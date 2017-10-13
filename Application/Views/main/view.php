<div class="row">
    <div class="col-md-2 col-md-offset-1">
        <?php if($user->image): ?>
        <div class="form-group">
            <div class="thumbnail">
                <?php if($user->image): ?>
                    <img class="img-thumbnail" src="./assets/upload/user/thumb/<?=$user->image?>" alt="...">
                <?php else: ?>
                    <img class="img-thumbnail" src="./assets/images/no-image.jpg" alt="Без фотографии">
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="form-group">
            <img class="img-thumbnail" src="./assets/images/no-image.jpg" alt="Без фотографии">
        </div>
    <?php endif; ?>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center"><?php echo $user->lastname . ' ' . $user->firstname?></h3>
            </div>
            <div class="panel-body">
                <p><b>Адрес электронной почты:</b> <?= $user->email; ?></p>
                <p><b>Логин: </b><?= $user->login; ?></p>
                <p><b>Роль:</b> <?= $user->getRole(); ?></p>
            </div>
            <div class="panel-footer">
                <a class="btn btn-default" href="index.php?controller=main&action=index" role="button">На главную</a>
            </div>
        </div>
    </div>

</div>