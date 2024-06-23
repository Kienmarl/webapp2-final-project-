<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
    <div class="posts-container">
        <h1>Post Page</h1>
        <div id="postDetail">
        <?php
        
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT * FROM `posts` WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->execute([':id' => $id]);

            $post = $statement->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                echo '<h3>Title: ' . $post['title'] . '</h3>';
                echo '<p>Body: ' . $post['body'] . '</p>';
            } else {
                echo "No post found with ID $id!";
            }
        } else {
            echo "No post ID provided!";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
</div>
        
</div>
</body>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get("id");
            fetch(`https://jsonplaceholder.typicode.com/posts/${postId}`)
            .then(response => response.json())
            .then(post => {
                const postDetails = document.getElementById("postDetail");
                postDetails.innerHTML = `
                    <h3>Title: ${post.title}</h3>
                    <p>Body: ${post.body}</p>
                `;
        })
        .catch(error => console.error("Error fetching posts:", error));
    });
</script> -->

</html>