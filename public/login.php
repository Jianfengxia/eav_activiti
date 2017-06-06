<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/7/26
 * Time: 13:33
 */
require 'layout.php';

$login = new login();

if (isset($_GET['logout'])){
    $login->LogoutAction();
}
if (isset($_POST['username'])){
    $login = $login->LoginAction($_POST['username'],$_POST['password']);
}

?>

<link href="<?php echo $layout->skinUrl ?>skin/css/signin.css" rel="stylesheet">

    <form class="form-signin" method="post" action="login.php">
        <h2 class="form-signin-heading">请登录</h2>
        <label for="inputEmail" class="sr-only">邮箱地址</label>
        <input type="email" name="username" class="form-control" placeholder="GTA邮箱地址" required autofocus>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" name="password" class="form-control" placeholder="密码" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me" checked > 记住我
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div> <!-- /container -->

</body>
</html>