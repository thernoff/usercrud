<?php

namespace Application\Controllers;

use Application\View;
use Application\Controller;
use Application\Exceptions\Core;
use Application\Models\User;

class Main
    extends Controller
{
    private $user;
    private $errors = [];
    private $sort = ['login' => 'loginASC', 'name' => 'nameASC' ,'role' => 'roleASC'];
    private $uri = '';
    protected function beforeAction()
    {
        $this->user = User::instance()->getCurrentUser();
        if ($this->user && $this->user->isAutorize()){
            $this->view->currentUser = User::instance()->getCurrentUser();
        }
    }
    
    protected function actionIndex()
    {
        $this->view->title = "Список пользователей";
        
        $sort = $_GET["sort"];
        
        $filterLogin = $_GET["filterLogin"];        
        $filterLastName = $_GET["filterLastName"];
        $filterFirstName = $_GET["filterFirstName"];

        if ( !empty($filterLogin) || !empty($filterLastName) || !empty($filterFirstName)) {
            $uri = '&filterLogin=' . $filterLogin . '&filterLastName=' . $filterLastName . '&filterFirstName=' . $filterFirstName;
        }
        /*$posSpace = stripos(trim($filterName), ' ');
        if ($posSpace > -1){
            $filterFirstname = substr($filterName, $posSpace, strlen($filterName));
            $filterLastname = substr($filterName, 0, $posSpace);
        }else{
            $filterFirstname = trim($filterName);
            $filterLastname = trim($filterName);
        }*/
        
        $arrFilter = ['login' => $filterLogin, 'lastname' => $filterLastName, 'firstname' => $filterFirstName];
        
        switch ($sort){
            case 'loginASC': 
                $this->sort['login'] = 'loginDESC';
                $users = User::findAllBySortAndFilter($arrFilter, ['login' => 'ASC']);
                break;
            case 'loginDESC': 
                $this->sort['login'] = 'loginASC'; 
                $users = User::findAllBySortAndFilter($arrFilter, ['login' => 'DESC']);
                break;
            case 'nameASC': 
                $this->sort['name'] = 'nameDESC'; 
                //$users = User::findAllBySort(['lastname', 'firstname'], 'ASC');
                $users = User::findAllBySortAndFilter($arrFilter, ['lastname' => 'ASC', 'firstname' => 'ASC']);
                break;
            case 'nameDESC': 
                $this->sort['name'] = 'nameASC'; 
                $users = User::findAllBySortAndFilter($arrFilter, ['lastname' => 'DESC', 'firstname' => 'DESC']);
                break;
            case 'roleASC': 
                $this->sort['role'] = 'roleDESC'; 
                $users = User::findAllBySortAndFilter($arrFilter, ['roleId' => 'ASC']);
                break;
            case 'roleDESC': 
                $this->sort['role'] = 'roleASC'; 
                $users = User::findAllBySortAndFilter($arrFilter, ['roleId' => 'DESC']);
                break;
            default:
                $users = User::findAllBySortAndFilter($arrFilter, []);
        }
        
        $this->view->sort = $this->sort;
        $this->view->uri = $uri;                
        $this->view->users = $users;
        
        echo $this->view->render(__DIR__ . '/../Views/layout/base.php', __DIR__ . '/../Views/main/index.php');
    }
    
    protected function actionAutorize()
    {  
        $user = User::instance();
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        
        if ($login && $password){
            
            if ($user->login($login, $password)){
                $user = $user->getCurrentUser();
                header("Location: /");
            }else{
                $this->view->error = "Не верно введены логин или пароль.";
                echo $this->view->render(__DIR__ . '/../Views/layout/base.php', __DIR__ . '/../Views/main/autorize.php');
            }
        }else{
            //$this->view->error = 'Поля должны быть заполнены.';            
        }
        echo $this->view->render(__DIR__ . '/../Views/layout/base.php', __DIR__ . '/../Views/main/autorize.php');
    }
    
    protected function actionLogout()
    {
        $user = User::instance();
        $user->logout();
    }
    
    protected function actionCreate()
    {
        if (isset($_POST['submitCreate'])){        
            var_dump($_POST);
            $user = User::instance();            
            $errors = [];
                
            if (!\Application\Components\Validator::validateEmpty($_POST)){
                $errors[] = "Заполните все поля, отмеченные знаком *";
            }

            if (!\Application\Components\Validator::validateEmail($_POST['email'])){
                $errors[] = "Не верный адрес электронной почты";
            }                        
            
            $user->fillFromArray($_POST);
            $user->password = md5($_POST['password']);
            
            if (count($errors) == 0){                                
                if ($_FILES["image"]["name"]){
                    $config = \Application\Core\Config::instance()->data;
                    $path_main_image = $config['user']['path_main_image'];
                    $path_main_image_thumb = $config['user']['path_main_image_thumb'];
                    $image = new \Application\Models\Image();
                    $image->name = $_FILES["image"]["name"];
                    $image->load($_FILES["image"]["tmp_name"], $path_main_image);
                    $width = $config['user']['width_main_image'];
                    $height = $config['user']['height_main_image'];
                    if ($image->createThumbnail($path_main_image, $path_main_image_thumb, $image->name, $width, $height)){
                        if ($page->main_image && file_exists($path_main_image_thumb . $page->main_image)){
                            unlink($path_main_image_thumb . $page->main_image);
                        }
                        if ($page->main_image && file_exists($path_main_image . $page->main_image)){
                            unlink($path_main_image . $page->main_image);
                        }
                        $user->image = $image->name;
                    };
                }

                $user->save();
                header("Location: /index.php?controller=main&action=index");
            }                                         
        }
        $this->view->user = $user;
        $this->view->errors = $errors;
        $this->view->title = "Добавление нового пользователя";
        echo $this->view->render(__DIR__ . '/../Views/layout/base.php', __DIR__ . '/../Views/main/create.php');
    }
    
    protected function actionView()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $user = \Application\Models\User::findById($id);
        $this->view->user = $user;
        echo $this->view->render(__DIR__ . '/../Views/layout/base.php', __DIR__ . '/../Views/main/view.php');
    }
    
    protected function actionUpdate()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        if (isset($_POST['submitUpdate'])){
                $user = User::instance();
                $errors = [];
                
                if (!\Application\Components\Validator::validateEmpty($_POST, ['password'])){
                    $errors[] = "Заполните все поля, отмеченные знаком *";
                }
                
                if (!\Application\Components\Validator::validateEmail($_POST['email'])){
                    $errors[] = "Не верный адрес электронной почты";
                }                
                
                if (count($errors) == 0){
                    $user->fillFromArray($_POST);

                    if ($_POST['password']){
                        $user->password = md5($_POST['password']);
                    }
                    
                    if ($_FILES["image"]["name"]){
                        $config = \Application\Core\Config::instance()->data;
                        $path_main_image = $config['user']['path_main_image'];
                        $path_main_image_thumb = $config['user']['path_main_image_thumb'];
                        $image = new \Application\Models\Image();
                        $image->name = $_FILES["image"]["name"];
                        $image->load($_FILES["image"]["tmp_name"], $path_main_image);
                        $width = $config['user']['width_main_image'];
                        $height = $config['user']['height_main_image'];
                        if ($image->createThumbnail($path_main_image, $path_main_image_thumb, $image->name, $width, $height)){
                            if ($page->main_image && file_exists($path_main_image_thumb . $page->main_image)){
                                unlink($path_main_image_thumb . $page->main_image);
                            }
                            if ($page->main_image && file_exists($path_main_image . $page->main_image)){
                                unlink($path_main_image . $page->main_image);
                            }
                            $user->image = $image->name;
                        };
                    }
                    $user->save();
                    header("Location: /index.php?controller=main&action=index");
                }            
        }
        $this->view->errors = $errors;
        $user = \Application\Models\User::findById($id);
        $this->view->user = $user;
        $this->view->title = "Редактирование пользователя";
        echo $this->view->render(__DIR__ . '/../Views/layout/base.php', __DIR__ . '/../Views/main/update.php');
    }
    
    protected function actionDelete()
    {
        if (!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        $user = \Application\Models\User::findById($id);
        $user->delete();
        header("Location: /index.php?controller=main&action=index");
    }
    
    protected function actionSearchOld(){
        $this->view->title = "Результаты поиска";
        if (!empty($_POST['search'])){
            //var_dump($_POST);
            $search = htmlspecialchars($_POST['search']);
            $pages = \Application\Models\Page::search('content', $search);
            //var_dump($pages);
            $this->view->pages = $pages;
            echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/search.php');
        }else{
            $this->actionError404();
        }
    }

    protected function actionError404()
    {
        echo $this->view->render(__DIR__ . '/../Views/layout/main.php', __DIR__ . '/../Views/main/error404.php');
    }
}