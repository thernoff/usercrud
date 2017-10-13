<?php

namespace Application\Models;

use Application\Model;
use Application\Db;

class User
    extends Model
{
    use \Application\Singleton;
    
    const TABLE = 'usercrud_users';
    
    public $login;
    public $password;
    public $firstname;
    public $lastname;
    public $roleId;
    public $email;
    public $image;
    
    private $id_user;
    private $role;

    public function login($login, $password, $remember = true)
    {
        //Получаем пользователя из базы данных
        $user = $this->getByLogin($login);
        
        if ($user == null){
            return false;
        }
        
        $this->id_user = $user->id;
        
        //Проверка пароля
        if ($user->password !== md5($password)){
            return false;
        }
        
        //Запоминаем имя и md5(пароль)
        if ($remember){
            $expire = time() +3600 * 24 * 100;
            setcookie('id_user', $this->id_user, $expire);
        }else{
            setcookie('id_user', $this->id_user);
        }
        
        return true;
    }
    
    public function logout()
	{
            setcookie('id_user', '', time() - 1);
            unset($_COOKIE['id_user']);
            header("Location: /index.php?controller=main&action=index");
	}
    
    /*
     * Получение пользователя по логину
     */
    public function getByLogin($login)
    {
        $db = Db::instance();
        $sql = "SELECT * FROM " . self::TABLE . " WHERE login = :login";
        $res = $db->query($sql, self::class, [':login' => $login]);
        //В случае успеха возвращаем объект класса User
	return ($res) ? $res[0] : null;
    }    
    
    /*
     * Получение текущего пользователя
     */
    public function getCurrentUser($id_user = null)
    {
        $id_user = $this->getIdUser();
        
        //Возвращаем пользователя по id_user
        if ($id_user){
            return parent::findById($id_user);
        }
        return null;
    }
    
    /*
     * Получение id текущего пользователя
     */
    
    public function getIdUser()
    {
        if ($this->id_user){
            return $this->id_user;
        }
        
        if ($_COOKIE['id_user']){
            return $_COOKIE['id_user'];
        }
        
        return null;
    }
    
    public function getRole()
    {
        if ($this->id){
            $db = Db::instance();
            $sql = "SELECT role FROM usercrud_role WHERE id = :roleId";
            $res = $db->select($sql, [':roleId' => $this->roleId]);
            
            return $res[0]["role"];
        }
        
        return false;
    }
    
    public function isAdmin(){
        if ($this->getRole() === "admin"){
            return true;
        }
        
        return false;
    }
    
    public function isUser(){
        if ($this->getRole() === "user"){
            return true;
        }
        
        return false;
    }
    
    public function isAutorize()
    {
        if ($this->id){
            return true;
        }
        
        return false;
    }

    private function hash($str)
    {
        return md5(md5($str));
    }
}
