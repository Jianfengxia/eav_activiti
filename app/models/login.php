<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/7/27
 * Time: 10:11
 */

class login extends dbconn
{
    public $action;

    public function __construct(){

    }

    public function LogoutAction() {
        session_destroy();
        header('Location:/login.php');
    }

    public function LoginAction($username,$password) {
        $username = trim($username);
        $password = trim($password);
        $qry = "SELECT users.id,dept.dname,roles.rname,users.uname,users.email,dept.drule,roles.rrule,users.created_at,users.updated_at FROM users INNER JOIN roles ON roles.id = users.role_id INNER JOIN dept ON dept.id = users.dept_id  where email='$username' and password='$password' ";
        $user=$this->conn()->query($qry,PDO::FETCH_ASSOC)->fetch();
        if(!$user) {
            return false;
        }
        $_SESSION['user'] = $user;
        header('Location:/project/');
        return true;
    }

    public function CheckLogin() {
        if(empty($_SESSION['user'])) {
            header('Location:/login.php');
            return false;
        }
        return true;
    }


}