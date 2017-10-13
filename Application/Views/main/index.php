<h1 class="text-center"><?=$title;?></h1>
<div class="container">
    <div class="panel panel-default">
            <div class="panel-body">
                Сортировка: 
                
                    <?php if($sort['login'] === 'loginASC'): ?>
                        <a class="btn btn-default" href="<?=$uri;?>&sort=<?= $sort['login']; ?>" role="button">
                        По логину
                        <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                    <?php else: ?>
                        <a class="btn btn-default" href="<?=$uri;?>&sort=<?= $sort['login']; ?>" role="button">
                        По логину
                        <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                    <?php endif; ?>
                        
                    <?php if($sort['name'] === 'nameASC'): ?>
                        <a class="btn btn-default" href="<?=$uri;?>&sort=<?= $sort['name']; ?>" role="button">
                        По фамилии/имени
                        <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                    <?php else: ?>
                        <a class="btn btn-default" href="<?=$uri;?>&sort=<?= $sort['name']; ?>" role="button">
                        По фамилии/имени
                        <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                    <?php endif; ?>
                        
                        <?php if($sort['role'] === 'roleASC'): ?>
                        <a class="btn btn-default" href="<?=$uri;?>&sort=<?= $sort['role']; ?>" role="button">
                        По роли
                        <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                    <?php else: ?>
                        <a class="btn btn-default" href="<?=$uri;?>&sort=<?= $sort['role']; ?>" role="button">
                        По роли
                        <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    
    
    <?php if($currentUser && $currentUser->isAdmin()): ?>
        <p class="lead">
        </p>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-10">
            <?php foreach($this->users as $user): ?>
            <div class="row">
                <div class="col-md-2 col-md-offset-1">
                    <div class="thumbnail">
                        <?php if($user->image): ?>
                            <img class="img-thumbnail" src="./assets/upload/user/thumb/<?=$user->image?>" alt="...">
                        <?php else: ?>
                            <img class="img-thumbnail" src="./assets/images/no-image.jpg" alt="Без фотографии">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center"><?php echo $user->lastname . ' ' . $user->firstname?></h3>
                        </div>
                        <div class="panel-body">
                            <p><b>Адрес электронной почты: </b><?= $user->email; ?></p>
                            <p><b>Логин: </b><?= $user->login; ?></p>
                            <p><b>Роль: </b><?= $user->getRole(); ?></p>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" href="index.php?controller=main&action=view&id=<?= $user->id; ?>" role="button">Просмотр</a>
                            <?php if($currentUser && $currentUser->isAdmin()): ?>
                                <a class="btn btn-default" href="index.php?controller=main&action=update&id=<?= $user->id; ?>" role="button">Редактировать</a>
                                <a class="btn btn-default" href="index.php?controller=main&action=delete&id=<?= $user->id; ?>" role="button">Удалить</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>        
            <?php endforeach;?>
        </div>
        <div class="col-md-2">
            <?php Application\Widgets\Filter\WidgetFilter::display(); ?>
        </div>
    </div>
</div>