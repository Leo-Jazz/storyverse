<?php
$versions = json_decode(file_get_contents('versions.json'), true);
require_once "db_connection.php";

$sql = "SELECT * FROM stories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3MY8P0HHH2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-3MY8P0HHH2');
</script>


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Read Stories</title>
 
  <link rel="stylesheet" href="styles.css?v=<?= $versions['styles'] ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">

  <script src="read_story_script.js?v=<?= $versions['scripts'] ?>"></script>


</head>
<body>
<header> <?php include 'header.php'; ?> </header>

  <h1>Read Stories</h1>
  <div class="container-read">
    <div class="story-list">
      <h2>Stories</h2>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $id = $row['id'];
          $story_name = $row['story_name'];
          $author_name = $row['author_name'];
          echo "<p class=\"story-title\" data-id=\"$id\">$story_name by $author_name</p>";
        }
      } else {
        echo "<p>No stories found.</p>";
      }
      ?>
    </div>
    <div class="story-content">
    
      <div class="story-data">
      <!-- Story data will be displayed here -->
      </div>
    
      <div class="like-button-container hidden">
        <button class="like-button" onclick="handleLikeClick(this)">Like</button>
        <span id="like-count">0</span>
      </div>

      <div class="comment-section hidden">
        <h3>Comments</h3>
        <form id="comment-form">
          <textarea id="comment-text" rows="3" placeholder="Write your comment here..."></textarea>
          <button type="submit">Submit</button>
        </form>
        <div id="comments-list"></div>
      </div>

    </div>
  </div>
  <nav>
  <a href="write_story.php" class="button">Write a new story</a>
  </nav>

  
</body>
</html>
