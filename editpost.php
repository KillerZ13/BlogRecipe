<?php
require('config/db.php');

# Check for database connection error
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

# Fetch categories for dropdown
$categories_result = mysqli_query($conn, "SELECT id, name FROM categories");
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

# Check if form is submitted for updating the post
if (isset($_POST['submit'])) 
{
    $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category']);

    # Update query
    $query = "UPDATE post SET
        title='$title',
        author='$author',
        body='$body',
        category_id='$category_id'
        WHERE id={$update_id}";

    if (mysqli_query($conn, $query)) {
        header('Location: post.php?id=' . $update_id);
        exit;
    } else {
        echo "ERROR: " . mysqli_error($conn);
    }
}

# Check if ID is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    # Get ID and sanitize it
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    # Create query
    $query = "SELECT * FROM post WHERE id={$id}";

    # Get result
    $result = mysqli_query($conn, $query);

    # Check if query was successful
    if ($result) {
        # Fetch data
        $post = mysqli_fetch_assoc($result);

        # Free result
        mysqli_free_result($result);
    } else {
        echo "ERROR: " . mysqli_error($conn);
        exit;
    }
} else {
    echo "ERROR: ID parameter is missing.";
    exit;
}

# Close connection
mysqli_close($conn);
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
    <div class="container-fluid" style="background-color:#C1E899; padding: 20px; height: 100vh;">
        <div class="jumbotron bg-dark" style="max-width: 450px; padding: 20px; color: ghostwhite; margin: auto;">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id); ?>" method="post">
                <h1 class="text-center">--- EDIT BLOG ---</h1>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" style="max-width: 400px" value="<?php echo htmlspecialchars($post['title']); ?>">
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" style="max-width: 400px" value="<?php echo htmlspecialchars($post['author']); ?>">
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <textarea rows="5" type="text" name="body" class="form-control" style="max-width: 400px"><?php echo htmlspecialchars($post['body']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" style="max-width: 400px">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo $post['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row justify-content-around">
                    <input type="hidden" name="update_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                    <div class="col-4 text-center">
                        <input type="submit" value="submit" name="submit" class="btn btn-alert btn-md">
                    </div>
                    <div class="col-4 text-center">
                        <a href="post.php?id=<?php echo htmlspecialchars($post['id']); ?>"><button type="button" class="btn btn-alert">back</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require('inc/footer.php'); ?>
</body>
</html>
