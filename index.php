<?php
require('config/db.php');

// Create query
$query = 'SELECT * FROM post ORDER BY created_at DESC';
// Get result
$result = mysqli_query($conn, $query);
// Fetch data
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Free result
mysqli_free_result($result);
// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Php Blog</title>
    <?php require('inc/header.php'); ?>
</head>
<body>
    <?php require('inc/navbar.php'); ?>
    <div class="container-fluid" style="background-color:burlywood; padding:20px;">
        <h1 class="text-center h"><b>BLOG RECIPE</b></h1>
        <div class="container">
            <?php foreach($posts as $post): ?>
                <hr>
                <div class="jumbotron bg-dark" style="color:ghostwhite">
                    <h3><?php echo $post['title']; ?></h3>
                    <small>
                        Created On 
                        <?php echo $post['created_at']; ?>
                        <br>by 
                        <span style="color:yellow"> <?php echo $post['author']; ?></span>
                    </small>
                    <hr>
                    <?php if(!empty($post['image'])): ?>
                        <img src="uploads/<?php echo $post['image']; ?>" alt="Post Image" style="width:100%; height:auto;">
                    <?php endif; ?>
                    <i><p style="padding-left:5%; padding-right:10%; font-size:2vw">"<?php echo $post['body']; ?>"</p></i>
                    <br>
                    <div class="text-right">
                        <a class="btn btn-success" href="post.php?id=<?php echo $post['id']; ?>">read more</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php require('inc/footer.php'); ?>
</body>
</html>
