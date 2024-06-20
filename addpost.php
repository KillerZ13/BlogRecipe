<?php
require('config/db.php');

if(isset($_POST['submit'])){
    $m = "Your post has been added!";
    echo "<script type='text/javascript'>alert('$m');</script>";

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/".basename($image);

    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_status = "Image uploaded successfully";
    } else {
        $image_status = "Failed to upload image";
    }

    $query = "INSERT INTO post(title, author, body, image, category_id) VALUES ('$title', '$author', '$body', '$image', '$category_id')";

    if(mysqli_query($conn, $query)){
        header("Location: index.php");
    } else {
        echo "ERROR: ".mysqli_error($conn);
    }
}

// Fetch categories for dropdown
$categories_result = mysqli_query($conn, "SELECT id, name FROM categories");
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Php Blog</title>
    <?php require('inc/header.php'); ?>
    <style>
        .navbar .user {
            color: #9A6735;
        }
        .jumbotron.bg-dark {
            background-color: #9A6735 !important;
        }
    </style>
</head>
<body>
    <?php require('inc/navbar.php'); ?>
    <div class="container-fluid" style="background-color:#C1E899; padding:20px; height:100vh;">
        <div class="jumbotron bg-dark" style="max-width:450px; padding:20px 20px; color:ghostwhite; margin: auto;">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <h1 class="text-center">--- ADD POSTS ---</h1>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" style="max-width:400px">
                </div>

                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" style="max-width:400px">
                </div>

                <div class="form-group">
                    <label>Body</label>
                    <textarea rows="5" type="text" name="body" class="form-control" style="max-width:400px"></textarea>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control-file" style="max-width:400px">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" style="max-width:400px">
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row justify-content-around">
                    <div class="col-4 text-center">
                        <input type="submit" value="submit" name="submit" class="btn btn-alert btn-md">
                    </div>
                    <div class='col-4 text-center'>
                        <a href="index.php"><button type="button" class="btn btn-alert">back</button></a>
                    </div>
                </div>
            </form>
        </div>    
    </div>
    <?php require('inc/footer.php'); ?>
</body>
</html>
