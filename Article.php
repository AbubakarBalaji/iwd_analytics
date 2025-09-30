<?php
include("path.php");
include("connect.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Article not specified.";
    exit;
}

$id = (int) $_GET['id'];

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, trim($_POST['comment']));
    if (!empty($comment)) {
        $insert = "INSERT INTO comments (post_id, content) VALUES ($id, '$comment')";
        mysqli_query($conn, $insert);
    }
}

// Fetch the article
$query = "SELECT p.*, a.name AS author_name, a.position, a.email, a.phone
          FROM posts p
          LEFT JOIN authors a ON p.author_id = a.id
          WHERE p.id = $id
          LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Post not found.";
    exit;
}

$post = mysqli_fetch_assoc($result);

// Fetch comments
$commentsQuery = "SELECT * FROM comments WHERE post_id = $id ORDER BY created_at DESC";
$commentsResult = mysqli_query($conn, $commentsQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($post['title']); ?> | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/article.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  
<?php include(ROOT_PATH."/App/includes/Header.php"); ?>

<div class="article-container">
  <h1 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h1>

  <?php if (!empty($post['author_name'])): ?>
  <div class="author-details">
    <img src="App/Database/Images/IWD LOGO new.png" alt="Author Picture" class="author-pic" />
    <div class="author-bio">
      <strong><?php echo htmlspecialchars($post['author_name']); ?></strong><br>
      <small><?php echo htmlspecialchars($post['position']); ?></small><br>
      <small>Email: <?php echo htmlspecialchars($post['email']); ?></small><br>
      <small>Phone: <?php echo htmlspecialchars($post['phone']); ?></small>
    </div>
  </div>
  <?php endif; ?>

  <p class="publication-date"><em>Posted on <?php echo date("F j, Y", strtotime($post['created_at'])); ?></em></p>

  <?php if (!empty($post['image'])): ?>
  <div class="article-image">
    <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Article Image" />
  </div>
  <?php endif; ?>

  <div class="article-content">
    <?php echo $post['content']; ?>
  </div>

  <!-- Comments Section -->
  <div class="comments-section">
    <h2>Comments</h2>

    <div class="comment-list">
      <?php if (mysqli_num_rows($commentsResult) > 0): ?>
        <?php while ($comment = mysqli_fetch_assoc($commentsResult)): ?>
          <div class="single-comment">
            <p><?php echo htmlspecialchars($comment['content']); ?></p>
            <small><em><?php echo date("F j, Y, g:i a", strtotime($comment['created_at'])); ?></em></small>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No comments yet. Be the first to comment!</p>
      <?php endif; ?>
    </div>

    <form action="" method="post" class="comment-form">
      <textarea name="comment" id="commentInput" placeholder="Write your comment here..." required></textarea>
      <button type="submit">Post Comment</button>
    </form>
  </div>
</div>

<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</body>
</html>
