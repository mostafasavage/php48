<!-- savage -->
<?php
session_start();
$_SESSION['Lang'] = isset($_GET['lang'])?$_GET['lang']:'en';
if($_SESSION['Lang']=='en'){
    include "lang/en.php";
}elseif($_SESSION['Lang']=='ar'){
    include "lang/ar.php";
}else{
    include "lang/en.php";
}
require "includes/config.php";
?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $adminUserName = $_POST['adminusername'];
    $adminPassword = sha1($_POST['adminpassword']);
    $stmt = $con->prepare("SELECT * FROM user WHERE username =? AND password =? AND role!=0");
    $stmt->execute(array($adminUserName ,$adminPassword));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    $dbcount = 1;
    if($count ==$dbcount){
        $_SESSION['ID'] = $row['id'];
        $_SESSION['ROLE'] = $row['role'];
        $_SESSION['USER_NAME'] = $adminUserName;
        $_SESSION['EMAIL'] = $row['email'];
        $_SESSION['FULL_NAME'] = $row['fullname'];
        header("location:dasboard.php");
    }else{
        echo "<div class='alert alert-danger'>Data Is Error</div>";
    }
}
?>
<?php include "includes/header.php" ?>
<div class="container mt-4">
    <h1 class="text-center"><?= $lang['admin_user'] ?></h1>
     <section class="mult-lang">
     <a href="?lang=en">English</a>
    <a href="?lang=ar">اللغه العربية</a>
     </section>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="adminusername" placeholder="isnert username">
            <label for="floatingInput"><?= $lang['username'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="adminpassword" placeholder="Password">
            <label for="floatingPassword"><?= $lang['password'] ?></label>
        </div>
        <button type="submit" class="btn btn-primary"><?= $lang['login'] ?></button>
    </form>
</div>
<?php include "includes/footer.php" ?>