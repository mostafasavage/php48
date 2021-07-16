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
<?php if($action =='index') : ?>
<?php
    $checkadmin = isset($_GET['check'])?'role!=0':'role=0';
        $stmt = $con->prepare("SELECT * FROM user WHERE ".$checkadmin);
        $stmt->execute();
        $users = $stmt->fetchAll();
        ?>
<table id="example" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Email Address</th>
            <th scope="col">Full Name</th>
            <th scope="col">Photo</th>
            <th scope="col">Control</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user) : ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['username'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['fullname'] ?></td>
            <td><img src="assest/image/<?= $user['image'] ?>" style="height: 10vh" </td> <td>
                <a href="?action=show&selection=<?= $user['id'] ?>" class="btn btn-primary">Show Data</a>
                <?php if( $_SESSION['ROLE']==1) : ?>
                <a href="?action=edit&selection=<?= $user['id'] ?>" class="btn btn-info">Edit Data</a>
                <a href="?action=delete&selection=<?= $user['id'] ?>" class="btn btn-danger">Delete Data</a>
                <?php endif ?>
            </td>
        </tr>
    </tbody>
    <?php endforeach ?>
</table>
<a href="?action=create" class="btn btn-info"><?= $lang['Create_New_Data'] ?></a>
<?php elseif($action =='create') : ?>
<div class="container mt-4">
    <h1 class="text-center"><?= $lang['create_admin'] ?></h1>
    <section class="mult-lang">
        <a href="?lang=en">English</a>
        <a href="?lang=ar">اللغه العربية</a>
    </section>
    <form method="POST" action="?action=store" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="isnert username">
            <label for="floatingInput"><?= $lang['username'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="isnert Email Address">
            <label for="floatingInput"><?= $lang['email'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword"><?= $lang['password'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="fullname" placeholder="isnert Full Name">
            <label for="floatingInput"><?= $lang['fullname'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="file" class="form-control" id="floatingInput" name="avaters" placeholder="isnert Avater Photo">
            <label for="floatingInput"><?= $lang['Photo'] ?></label>
        </div>
        <button type="submit" class="btn btn-primary"><?= $lang['create'] ?></button>
    </form>
</div>
<?php elseif($action =='store') : ?>
<?php
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $avaters = $_FILES['avaters'];
            $avatersName = $_FILES['avaters']['name'];
            $avatersType = $_FILES['avaters']['type'];
            $avatersTempName = $_FILES['avaters']['tmp_name'];
            $avatersError = $_FILES['avaters']['error'];
            $avatersSize = $_FILES['avaters']['size'];
            $exptionArrowed = array('image/jpg','image/jpeg','image/png');
            if(in_array($avatersType , $exptionArrowed)){
                $randname = rand(0 , 10000)."_" .$avatersName;
                $dstmationImage = "assest/image//".$randname;
                move_uploaded_file($avatersTempName ,$dstmationImage);
            }
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = sha1($_POST['password']);
            $fullname = $_POST['fullname'];
            $fromError = array();
           if(strlen($username)<4 || empty($username)){
               $fromError[] = "Inset User Name";
           }
            if(empty($email)){
                $fromError[] = "Insert Email Address";
            }
            if(empty($password)){
                $fromError[] = "Insert Password";
            }
            if(empty($fullname)){
                $fromError[] = "Insert Full Name";
            }
            if(empty($avaters)){
                $fromError[] = "Insert Avter";
            }
            if(empty($fromError)){
                $stmt = $con->prepare("INSERT INTO user (username , email , password , fullname , image  ,role) VALUES(?,?,?,?,?,0)");
                $stmt->execute(array($username , $email , $password , $fullname,$randname));
                header("Location:members.php?action=create");
            }else{
                foreach($fromError as $error){
                    echo "<div class='alert alert-danger'>.$error</div>";
                }
            }
        }
        ?>
<?php elseif($action =='edit') : ?>
<?php
        $userId = isset($_GET['selection'])&&is_numeric($_GET['selection'])?intval($_GET['selection']):0;
        $stmt = $con->prepare("SELECT * FROM user WHERE id=?");
        $stmt->execute(array($userId));
        $users = $stmt->fetch();
        $count = $stmt->rowCount();
        ?>
<?php if($count > 0) : ?>
<div class="container mt-4">
    <h1 class="text-center"><?= $lang['update_admin'] ?></h1>
    <section class="mult-lang">
        <a href="?lang=en">English</a>
        <a href="?lang=ar">اللغه العربية</a>
    </section>
    <form method="POST" action="?action=update" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="floatingInput" value="<?= $users['id'] ?>" name="userid"
            placeholder="isnert username">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" value="<?= $users['username'] ?>" name="username"
                placeholder="isnert username">
            <label for="floatingInput"><?= $lang['username'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="<?= $users['email'] ?>"
                placeholder="isnert Email Address">
            <label for="floatingInput"><?= $lang['email'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="oldpassword" placeholder="Password">
            <input type="hidden" class="form-control" id="floatingPassword" value="<?= $users['password'] ?>"
                name="newpassword" placeholder="Password">
            <label for="floatingPassword"><?= $lang['password'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="fullname" value="<?= $users['fullname'] ?>"
                placeholder="isnert Full Name">
            <label for="floatingInput"><?= $lang['fullname'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="file" class="form-control" id="floatingInput" value="<?= $users['image'] ?>" name="avaters"
                placeholder="isnert Avater Photo">
            <label for="floatingInput"><?= $lang['Photo'] ?></label>
        </div>
        <button type="submit" class="btn btn-primary"><?= $lang['update'] ?></button>
    </form>
</div>
<?php else : ?>
<?php header("loction:members.php"); ?>
<?php endif ?>
<?php elseif($action =='update') : ?>
<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $avaters = $_FILES['avaters'];
        $avatersName = $_FILES['avaters']['name'];
        $avatersType = $_FILES['avaters']['type'];
        $avatersTempName = $_FILES['avaters']['tmp_name'];
        $avatersError = $_FILES['avaters']['error'];
        $avatersSize = $_FILES['avaters']['size'];
        $exptionArrowed = array('image/jpg','image/jpeg','image/png');
        if(in_array($avatersType , $exptionArrowed)){
            $randname = rand(0 , 10000)."_" .$avatersName;
            $dstmationImage = "assest/image//".$randname;
            move_uploaded_file($avatersTempName ,$dstmationImage);
        }
        $userid = $_POST['userid'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);
        $fullname = $_POST['fullname'];
        $stmt = $con->prepare("UPDATE user SET username =? , email =? , password =? , fullname =? , image =? WHERE id =?");
        $stmt->execute(array($username , $email , $password , $fullname , $randname , $userid));
        header("Location:members.php");
    }
    ?>
<?php elseif($action =='profilo') : ?>
<div class="container mt-4">
    <h1 class="text-center"><?= $lang['update_admin'] ?></h1>
    <section class="mult-lang">
        <a href="?lang=en">English</a>
        <a href="?lang=ar">اللغه العربية</a>
    </section>
    <form method="POST" action="?action=update" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" value="<?=$_SESSION['USER_NAME'] ?>"
                name="username" placeholder="isnert username">
            <label for="floatingInput"><?= $lang['username'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="<?= $_SESSION['EMAIL'] ?>"
                placeholder="isnert Email Address">
            <label for="floatingInput"><?= $lang['email'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="fullname"
                value="<?=$_SESSION['FULL_NAME'] ?>" placeholder="isnert Full Name">
            <label for="floatingInput"><?= $lang['fullname'] ?></label>
        </div>
        <a href="members.php" class="btn btn-dark">Back</a>
    </form>
</div>
<?php elseif($action =='show') : ?>
<?php
        $userId = isset($_GET['selection'])&&is_numeric($_GET['selection'])?intval($_GET['selection']):0;
        $stmt = $con->prepare("SELECT * FROM user WHERE id=?");
        $stmt->execute(array($userId));
        $users = $stmt->fetch();
        $count = $stmt->rowCount();
        ?>
<?php if($count > 0) : ?>
<div class="container mt-4">
    <h1 class="text-center"><?= $lang['update_admin'] ?></h1>
    <section class="mult-lang">
        <a href="?lang=en">English</a>
        <a href="?lang=ar">اللغه العربية</a>
    </section>
    <form method="POST" action="?action=show" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" value="<?= $users['username'] ?>" name="username"
                placeholder="isnert username">
            <label for="floatingInput"><?= $lang['username'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" value="<?= $users['email'] ?>"
                placeholder="isnert Email Address">
            <label for="floatingInput"><?= $lang['email'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="fullname" value="<?= $users['fullname'] ?>"
                placeholder="isnert Full Name">
            <label for="floatingInput"><?= $lang['fullname'] ?></label>
        </div>
        <div class="form-floating mb-3">
            <input type="file" class="form-control" id="floatingInput" value="<?= $users['image'] ?>" name="avaters"
                placeholder="isnert Avater Photo">
            <label for="floatingInput"><?= $lang['Photo'] ?></label>
        </div>
        <a href="members.php" class="btn btn-dark">Back</a>
    </form>
</div>
<?php else : ?>
<?php header("Location:members.php"); ?>
<?php endif ?>
<?php elseif($action =='delete') : ?>
<?php
     $userId = isset($_GET['selection'])&&is_numeric($_GET['selection'])?intval($_GET['selection']):0;
     $stmt = $con->prepare("DELETE  FROM user WHERE id=?");
     $stmt->execute(array($userId));
     header("Location:members.php");
        ?>

<?php else : $error ?>
<?php endif ?>
<?php include "includes/footer.php" ?>