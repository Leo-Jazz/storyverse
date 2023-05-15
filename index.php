<?php
// Load the JSON file containing version numbers for cache-busting.
$versions = json_decode(file_get_contents('versions.json'), true);

// Include the database connection file.
require_once "db_connection.php";

// Fetch 3 stories from the database with the most likes to be featured.
$sql = "SELECT * FROM stories ORDER BY likes DESC LIMIT 3";
$result = $conn->query($sql);
$featured_stories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($featured_stories, $row);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Analytics script -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3MY8P0HHH2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-3MY8P0HHH2');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include the stylesheets -->
    <link rel="stylesheet" href="styles.css?v=<?= $versions['styles'] ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">

    <title>Storyverse</title>
</head>
<body>
    <header>
        <!-- Include the header content -->
        <?php include 'header.php'; ?>

        <!-- Display the Storyverse logo and introductory content -->
        <img src="images/storyverse-logo.png" alt="Storyverse Logo" id="logo">
        <h1 class="subtitle">Unleash Your Creativity in the World of Stories</h1>
        <p class="description">Welcome to Storyverse, a platform where parents, uncles, teachers, and kids themselves can share their stories! Dive into a world of imagination and adventure, or create your own stories and bring them to life. Join our community, and let's make storytelling more fun and accessible for everyone.</p>
    </header>

    <!-- Navigation buttons -->
    <nav class="buttons-container">
        <a href="write_story.php" class="button">Write Your Story</a>
        <a href="read_story.php" class="button">Read Stories</a>
    </nav>

    <!-- Display featured stories -->
    <div class="featured-stories">
        <div class="subtitle">Gallery of featured stories</div>
        <?php
            foreach ($featured_stories as $story) {
                $story_name = $story['story_name'];
                $author_name = $story['author_name'];
                $story_id = $story['id'];
                $images_array = json_decode($story['images'], true); // Decode the JSON string into an array
                
                if (!empty($images_array[0])) {
                    $story_image = stripslashes($images_array[0]); // Remove the extra backslashes
                } else {
                    $story_image = "images/book-icon.jpg";
                }
                
                echo "<div class=\"story-thumbnail\" data-id=\"$story_id\">
                        <img class=\"thumbnail-image\" src=\"$story_image\" alt=\"Story thumbnail\">
                        <h4>$story_name</h4>
                        <p>by $author_name</p>
                    </div>";
            }
        ?>
    </div>

    <!-- JavaScript for handling story thumbnail click events -->
    <script>
        const storyThumbnails = document.querySelectorAll('.story-thumbnail');

        storyThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                const id = thumbnail.getAttribute('data-id');
                window.location.href = `read_story.php?id=${id}&display=content`;
            });
        });
    </script>
</body>
</html>
