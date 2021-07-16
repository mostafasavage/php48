<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">PHP48</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php">Members</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="prodect.php">Prodects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="category.php">Category</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['FULL_NAME']?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="members.php?action=profilo&selection=<?= $_SESSION['ID'] ?>">Profile</a></li>
            <li><a class="dropdown-item" href="members.php?check=ahmed">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <?php if($_SESSION['Lang']=='en') : ?>
              <li><a class="dropdown-item" href="?lang=ar">اللغه العربيه</a></li>
              <?php $_SESSION['Lang'] =='ar' ?>
              <?php elseif($_SESSION['Lang']=='ar') : ?>
              <li><a class="dropdown-item" href="?lang=en">English</a></li>
              <?php $_SESSION['Lang'] =='en' ?>
              <?php endif ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>