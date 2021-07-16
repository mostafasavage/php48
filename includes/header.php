<!doctype html>
<html
<?php if($_SESSION['Lang']=='ar') : ?>
  lang="ar" dir ="rtl"
  <?php else : ?>
  lang="en" dir ="ltr"
  <?php endif ?>
>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if($_SESSION['Lang'] =='ar') : ?>
      <link rel="stylesheet" href="assest/css/bootstrap.rtl.min.css">
      <?php elseif($_SESSION['Lang']=='en') : ?>
        <link rel="stylesheet" href="assest/css/bootstrap.min.css">
      <?php endif ?>
      <link rel="stylesheet" href="assest/css/all.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.1.0/css/searchBuilder.bootstrap5.min.css"/>
  -->
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <title>Hello, world!</title>
  </head>
  <body>
  