<?php
header('Content-Type: application/json');

// Connect to the database
require_once "db_connection.php";

// Get the form data
$input_method = $_POST['input_method'];

// Depending on the input method, process the data differently
if ($input_method === 'freely') {
  $author_name = htmlspecialchars($_POST['author_name'], ENT_QUOTES, 'UTF-8');
  $story_name = htmlspecialchars($_POST['story_name'], ENT_QUOTES, 'UTF-8');
  $story_text = htmlspecialchars($_POST['story_text'], ENT_QUOTES, 'UTF-8');
} else {
  $author_name = htmlspecialchars($_POST['author_name'], ENT_QUOTES, 'UTF-8');
  $story_name = htmlspecialchars($_POST['story_name'], ENT_QUOTES, 'UTF-8');
  $core_idea = $_POST['core_idea'];
  $universe = $_POST['universe'];
  $characters = $_POST['characters'];
  $antagonistic_forces = $_POST['antagonistic_forces'];
  $block1 = htmlspecialchars($_POST['block1'], ENT_QUOTES, 'UTF-8');
  $block2 = htmlspecialchars($_POST['block2'], ENT_QUOTES, 'UTF-8');
  $block3 = htmlspecialchars($_POST['block3'], ENT_QUOTES, 'UTF-8');
  $story_text = $block1 . "\n\n" . $block2 . "\n\n" . $block3;
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
$sql = "INSERT INTO stories (author_name, story_name, story_text, images, core_idea, universe, characters, antagonistic_forces)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
  die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ssssssss", $author_name, $story_name, $story_text, $images_json, $core_idea, $universe, $characters, $antagonistic_forces);

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
    ],
  ]);
}


$stmt->close();
$conn->close();
?>
