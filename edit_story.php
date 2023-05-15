<?php
require_once "db_connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Story</title>
    <link rel="stylesheet" href="styles.css?v=<?= $versions['styles'] ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <h1>Edit Story</h1>
    
    <input type="number" id="story-id-input" placeholder="Enter story ID">
    <button id="fetch-story-data">Fetch Story Data</button>
    <br><br>

    <form id="edit-story-form" enctype="multipart/form-data">
        <!-- Form fields will be added here -->

        <input type="hidden" id="id" name="id">
        <label for="story_name">Story Name:</label>
        <input type="text" id="story_name" name="story_name" value="<?= htmlspecialchars($story_data['story_name']) ?>" required>
        <br>
        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" value="<?= htmlspecialchars($story_data['author_name']) ?>" required>
        <br>
        <label for="story_language">Story Language:</label>
        <select id="story_language" name="story_language" required></select>
        <br>
        <label for="story_text">Story Text:</label>
        <div class="quill-editor" id="story_text" style="height: 200px"><?= htmlspecialchars($story_data['story_text']) ?></div>
        <br>
        <label for="translation_language">Translation Language:</label>
        <select id="translation_language" name="translation_language"></select>
        <br>
        <label for="translation_text">Translation Text:</label>
        <div class="quill-editor" id="translation_text" style="height: 200px"><?= htmlspecialchars($story_data['translation_text']) ?></div>
        <br>
        <button type="submit">Save Changes</button>
    </form>

    <script src="edit_story_script.js?v=<?= $versions['scripts'] ?>"></script>

</body>
</html>
