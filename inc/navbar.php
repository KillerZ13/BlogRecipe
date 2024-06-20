<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Blog</title>
    <?php require('inc/header.php'); ?>
    <style>
        .navbar .nav-link, .navbar .navbar-brand {
          /* background-color: #55883B;   */
          color: white;
        }
    </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Bon Appétit Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="addpost.php">Add Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comment.php">Comment</a>
        </li>

      <form class="form-inline my-2 my-lg-0" action="post.php" method="get">
        <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <li class="nav-item">
          <a class="nav-link" href="signin.php">Logout</a>
      </li>
    </div>
  </nav>
</body>
</html>