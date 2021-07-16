<?php
session_start();
// $_SESSION['Lang'] = isset($_GET['lang'])?$_GET['lang']:'en';
if($_SESSION['Lang']=='en'){
    include "lang/en.php";
}elseif($_SESSION['Lang']=='ar'){
    include "lang/ar.php";
}else{
    include "lang/en.php";
}
require "includes/config.php";
?>
<?php include "includes/navbar.php" ?>
<?php include "includes/header.php" ?>
<div class="container">
    <h1 class="text-center"><?= $lang['dashboard'] ?></h1>
    <div class="row">
        <?php
        $stmt = $con->prepare("SELECT count(id) FROM user WHERE role=0");
        $stmt->execute();
        $count= $stmt->rowCount();
        ?>
    <div class="col-md-3">
    <a href="members.php" class="membercon d-flex justify-content-center"> <i class="fa fa-users fa-3x"></i></a>
    </div>
    <div class="col-md-3">
        <h4><?= $count ?></h4>
    </div>
    </div>
</div>
<?php include "includes/footer.php" ?>