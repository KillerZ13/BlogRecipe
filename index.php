<?php
require('config/db.php');

// Variable to store the post data
$post = null;
$posts = [];

// Check if form is submitted for deleting a post
if (isset($_POST['delete'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    $query = "DELETE FROM post WHERE id={$delete_id}";

    if (mysqli_query($conn, $query)) {
        header("Location: post.php");
        exit;
    } else {
        echo "ERROR: " . mysqli_error($conn);
    }
}

// Check if ID is set in the URL to view a single post
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT post.*, categories.name AS category_name FROM post
              LEFT JOIN categories ON post.category_id = categories.id
              WHERE post.id={$id}";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $post = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    } else {
        echo "ERROR: " . mysqli_error($conn);
        exit;
    }
} else {
    // Check if query parameter is set to search posts
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $query = mysqli_real_escape_string($conn, $_GET['query']);
        $sql = "SELECT post.*, categories.name AS category_name FROM post
                LEFT JOIN categories ON post.category_id = categories.id
                WHERE post.title LIKE '%$query%' OR post.body LIKE '%$query%'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            echo "ERROR: " . mysqli_error($conn);
            exit;
        }
    } else {
        // Default action to list all posts
        $query = "SELECT post.*, categories.name AS category_name FROM post
                  LEFT JOIN categories ON post.category_id = categories.id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            echo "ERROR: " . mysqli_error($conn);
            exit;
        }
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Blog</title>
    <?php require('inc/header.php'); ?>
</head>
<body>
    <?php require('inc/navbar.php'); ?>
    <div class="container-fluid" style="background-color:burlywood; padding:20px; height:100vh">
        <div class="container">
            <?php if ($post): ?>
                <!-- Single Post View -->
                <div class="row justify-content-between">
                    <div class='col-2'>
                        <a href="post.php"><button class="btn btn-alert">Back</button></a>
                    </div>
                    <div class='col-8'>
                        <h1 class="text-right">
                            <?php echo htmlspecialchars($post['title']); ?> |
                        </h1>
                    </div>
                </div>
                <hr>
                <div class="jumbotron bg-dark" style="color:ghostwhite">
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="width:100%; height:auto;">
                    <?php endif; ?>
                    <h3>"<?php echo htmlspecialchars($post['body']); ?>"</h3>
                    <br><br>
                    <p class="text-right" style="font-size:1.2vw">
                        Category: <span style="color:yellow"><?php echo htmlspecialchars($post['category_name']); ?></span><br>
                        Created On: <?php echo htmlspecialchars($post['created_at']); ?>
                        <br>-
                        <span style="color:yellow">
                            <?php echo htmlspecialchars($post['author']); ?>
                        </span>
                    </p>
                    <hr>
                    <div class="row justify-content-between">
                        <div class="col-3">
                            <a href="editpost.php?id=<?php echo htmlspecialchars($post['id']); ?>"><button class="btn btn-alert">Edit Blog</button></a>
                        </div>
                        <div class="col-3">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . htmlspecialchars($post['id']); ?>">
                                <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                                <input type="submit" name="delete" value="Delete Blog" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Posts List and Search Results -->
                <h1 class="text-center"><?php echo isset($_GET['query']) ? 'Search Results' : 'Bon Appétit Blog'; ?></h1>
                <hr>
                <?php if (count($posts) > 0): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="jumbotron bg-dark" style="color:ghostwhite">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                            <?php if (!empty($post['image'])): ?>
                                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="width:100%; height:auto;">
                            <?php endif; ?>
                            <p><?php echo htmlspecialchars($post['body']); ?></p>
                            <p class="text-right">
                                Category: <span style="color:yellow"><?php echo htmlspecialchars($post['category_name']); ?></span><br>
                                Created On: <?php echo htmlspecialchars($post['created_at']); ?>
                                <br>-
                                <span style="color:yellow"><?php echo htmlspecialchars($post['author']); ?></span>
                            </p>
                            <a href="post.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="btn btn-outline-light">Read More</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No posts found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php require('inc/footer.php'); ?>
</body>
</html>
