<?php
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
  echo json_encode([
    'success' => false,
    'error' => 'No story ID provided.',
  ]);
  exit();
}

require_once "db_connection.php";

$id = $_GET['id'];
$sql = "SELECT s.*, c.id as comment_id, c.comment_text FROM stories s LEFT JOIN comments c ON s.id = c.story_id WHERE s.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$story_data = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if (empty($story_data)) {
      $story_data = [
          'success' => true,
          'story_name' => html_entity_decode($row['story_name']),
          'author_name' => html_entity_decode($row['author_name']),
          'story_text' => nl2br(html_entity_decode($row['story_text'])),
          'translation_text' => $row['translation_text'] ? nl2br(html_entity_decode($row['translation_text'])) : null,
          'story_language' => $row['story_language'], // Add this line
          'translation_language' => $row['translation_language'], // Add this line
          'images' => json_decode($row['images']),
          'likes' => intval($row['likes']),
          'comments' => [],
      ];
  }

    if (!is_null($row['comment_id'])) {
      $story_data['comments'][] = [
        'id' => $row['comment_id'],
        'comment_text' => $row['comment_text'],
      ];
    }
  }

  echo json_encode($story_data);
} else {
  echo json_encode([
    'success' => false,
    'error' => 'Story not found.',
  ]);
}

$stmt->close();
$conn->close();

?>
