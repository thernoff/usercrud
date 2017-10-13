
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <title>Users</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">UserCRUD</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav pull-right">
            <!--<li><button type="button" data-toggle="modal" data-target="#myModal">Войти</button></li>-->
            <?php if ($currentUser): ?>
                <li><a class="btn btn-default navbar-btn" href="index.php?controller=main&action=update&id=<?= $currentUser->id; ?>" >Редактировать</a></li>
                <?php if($currentUser && $currentUser->isAdmin()): ?>
                    <li><a class="btn btn-default navbar-btn" href="index.php?controller=main&action=create">Добавить</a></li>
                <?php endif; ?>
                <li><a class="btn btn-default navbar-btn" href="index.php?controller=main&action=logout" >Выйти</a></li>
                <li>
                        <?php if($currentUser->image): ?>
                        <img class="img-circle navbar-image" src="./assets/upload/user/thumb/<?= $currentUser->image; ?>" alt="..." width="60px">
                        <?php else: ?>
                            <img class="img-circle" src="./assets/images/no-image.jpg" alt="..." width="60px">
                        <?php endif; ?>
                        
                        <?php //echo $currentUser->firstname . ' ' . $currentUser->lastname?>
                </li>
            <?php else: ?>
                <li><a href="index.php?controller=main&action=autorize" class="btn btn-default navbar-btn">Войти</a></li>
            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">        
        <div class="starter-template">
            <?php echo $content;?>
        </div>
    </div><!-- /.container -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Авторизуйтесь</h4>
          </div>
          <div class="modal-body">
              <form action="index.php?controller=main&action=autorize" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Логин</label>
                  <input type="text" class="form-control" id="login" name="login" placeholder="Логин">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Пароль</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                </div>                
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Запомнить меня
                  </label>
                </div>
                <button type="submit" class="btn btn-default">Войти</button>
            </form>
          </div>
          <!--<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            <button type="button" class="btn btn-primary">Войти</button>
          </div>-->
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
  </body>
</html>