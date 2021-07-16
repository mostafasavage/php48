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
<?php
$stmt = $con->prepare("SELECT prodects.* , categories.* FROM prodects INNER JOIN categories ON categories.category_id = prodects.category_id");
$stmt->execute();
$prodects =  $stmt->fetchAll();
?>
<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Prodect Id</th>
      <th scope="col">Prodect Name</th>
      <th scope="col">Prodect  Price</th>
      <th scope="col">Category Name</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($prodects as $prodect) : ?>
    <tr>
      <td><?= $prodect['prodect_id'] ?></td>
      <td><?= $prodect['prodect_name'] ?></td>
      <td><?= $prodect['prodect_price'] ?></td>
      <td><?= $prodect['category_name'] ?></td>
      <td>
      <a href="?action=show&selection=<?= $user['id'] ?>" class="btn btn-primary">Show Data</a>
      <a href="?action=edit&selection=<?= $user['id'] ?>" class="btn btn-info">Edit Data</a>
        <a href="?action=delete&selection=<?= $user['id'] ?>" class="btn btn-danger">Delete Data</a>
      </td>
    </tr>
  </tbody>
  <?php endforeach ?>
</table>
<?php include "includes/footer.php" ?>