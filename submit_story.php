<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Connect to the database
require_once "db_connection.php";

// Get the form data
$input_method = $_POST['input_method'];

$core_idea = NULL;
$universe = NULL;
$characters = NULL;
$antagonistic_forces = NULL;

// Depending on the input method, process the data differently
if ($input_method === 'freely') {
  $author_name = htmlspecialchars($_POST['author_name'], ENT_QUOTES, 'UTF-8');
  $story_name = htmlspecialchars($_POST['story_name'], ENT_QUOTES, 'UTF-8');
  $story_text = htmlspecialchars($_POST['story_text'], ENT_QUOTES, 'UTF-8');
  // Get the language and translation data
  $story_language = isset($_POST['story_language_freely']) ? $_POST['story_language_freely'] : '';
  $translation_language = isset($_POST['translation_language_freely']) ? $_POST['translation_language_freely'] : '';
  $translation_text = isset($_POST['translation_text_freely']) ? htmlspecialchars($_POST['translation_text_freely'], ENT_QUOTES, 'UTF-8') : '';

} else {
  $author_name = htmlspecialchars($_POST['author_name'], ENT_QUOTES, 'UTF-8');
  $story_name = htmlspecialchars($_POST['story_name'], ENT_QUOTES, 'UTF-8');
  $core_idea = isset($_POST['core_idea']) ? htmlspecialchars($_POST['core_idea'], ENT_QUOTES, 'UTF-8') : NULL;
  $universe = isset($_POST['universe']) ? htmlspecialchars($_POST['universe'], ENT_QUOTES, 'UTF-8') : NULL;
  $characters = isset($_POST['characters']) ? htmlspecialchars($_POST['characters'], ENT_QUOTES, 'UTF-8') : NULL;
  $antagonistic_forces = isset($_POST['antagonistic_forces']) ? htmlspecialchars($_POST['antagonistic_forces'], ENT_QUOTES, 'UTF-8') : NULL;
  $block1 = htmlspecialchars($_POST['block1'], ENT_QUOTES, 'UTF-8');
  $block2 = htmlspecialchars($_POST['block2'], ENT_QUOTES, 'UTF-8');
  $block3 = htmlspecialchars($_POST['block3'], ENT_QUOTES, 'UTF-8');
  $story_text = $block1 . "\n\n" . $block2 . "\n\n" . $block3;
  // Get the language and translation data
  $story_language = isset($_POST['story_language_frame']) ? $_POST['story_language_frame'] : '';
  $translation_language = isset($_POST['translation_language_frame']) ? $_POST['translation_language_frame'] : '';
  $translation_text = isset($_POST['translation_text_frame']) ? htmlspecialchars($_POST['translation_text_frame'], ENT_QUOTES, 'UTF-8') : '';
}



// Handle uploaded images
$images = [];
if (isset($_FILES['story_images']) && !empty($_FILES['story_images']['name'][0])) {
  $target_dir = "uploads/";
  for ($i = 0; $i < count($_FILES['story_images']['name']); $i++) {
    $target_file = $target_dir . time() . '_' . basename($_FILES['story_images']['name'][$i]);
    if (move_uploaded_file($_FILES['story_images']['tmp_name'][$i], $target_file)) {
      $images[] = $target_file;
    }
  }
}

// Save the story and images to the database
$images_json = json_encode($images);
$sql = "INSERT INTO stories (author_name, story_name, story_text, images, core_idea, universe, characters, antagonistic_forces, story_language, translation_language, translation_text)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
  die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("sssssssssss", $author_name, $story_name, $story_text, $images_json, $core_idea, $universe, $characters, $antagonistic_forces, $story_language, $translation_language, $translation_text);

$result = $stmt->execute();

if ($result) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode([
    'success' => false,
    'error' => "Error: " . $stmt->error,
    'errno' => $stmt->errno,
    'sql' => $sql,
    'params' => [
      'author_name' => $author_name,
      'story_name' => $story_name,
      'story_text' => $story_text,
      'images_json' => $images_json,
      'core_idea' => $core_idea,
      'universe' => $universe,
      'characters' => $characters,
      'antagonistic_forces' => $antagonistic_forces,
      'story_language_freely' => $story_language,
      'translation_language_freely' => $translation_language,
      'translation_text_freely' => $translation_text,
      'story_language_frame' => $story_language,
      'translation_language_frame' => $translation_language,
      'translation_text_frame' => $translation_text,
    ],
  ]);
}

$stmt->close();
$conn->close();
?>