<?php
session_start();
if(isset($_GET['lang'])){
    $_SESSION['Lang'] = $_GET['lang'];
}
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
$userid = $_SESSION['ID'];
$stmt = $con->prepare("SELECT * FROM user WHERE id =?");
$stmt->execute(array($userid));
$users = $stmt->fetch();  
?>
<?php include "includes/navbar.php" ?>
<?php include "includes/header.php" ?>
<?php
$action = "";
if(isset($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = "index";
}
?>
<?php include "includes/navbar.php" ?>
<?php include "includes/header.php" ?>
<div class="container mt-4">
    <h1 class="text-center"><?= $lang['update_admin'] ?></h1>
     <section class="mult-lang">
     <a href="?lang=en">English</a>
    <a href="?lang=ar">اللغه العربية</a>
     </section>
    <form method="POST" action="?action=update" enctype="multipart/form-data">
    <input type="hidden" class="form-control" id="floatingInput" value="<?= $users['id'] ?>" name="userid" placeholder="isnert username">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" value="<?= $users['username'] ?>" name="username" placeholder="isnert username">
            <label for="floatingInput"><?= $lang['username'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="<?= $users['email'] ?>" placeholder="isnert Email Address">
            <label for="floatingInput"><?= $lang['email'] ?></label>
        </div>
        <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPassword" name="oldpassword" placeholder="Password">
            <input type="hidden" class="form-control" id="floatingPassword" value="<?= $users['password'] ?>" name="newpassword" placeholder="Password">
            <label for="floatingPassword"><?= $lang['password'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="fullname" value="<?= $users['fullname'] ?>" placeholder="isnert Full Name">
            <label for="floatingInput"><?= $lang['fullname'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="file" class="form-control" id="floatingInput" value="<?= $users['image'] ?>" name="avaters" placeholder="isnert Avater Photo">
            <label for="floatingInput"><?= $lang['Photo'] ?></label>
        </div>
      <a href="members.php" class="btn btn-dark">Back</a>
    </form>
</div>
<?php include "includes/footer.php" ?>