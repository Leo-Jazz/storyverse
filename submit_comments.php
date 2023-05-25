<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $storyId = $_POST["storyId"];
    $likes = isset($_POST["likes"]) ? $_POST["likes"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;

    if (!isset($_POST["storyId"]) || empty($_POST["storyId"])) {
        echo json_encode(['success' => false, 'error' => 'Story ID not provided.']);
        exit;
    }
    
    if ($likes !== null) {
        // Update likes in the database
        $sql = "UPDATE stories SET likes = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $likes, $storyId);
        $stmt->execute();
        $stmt->close();
    }
    
    if ($comment !== null) {
        // Insert comment into the database
        $sql = "INSERT INTO comments (story_id, comment_text) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'Error preparing statement: ' . $conn->error]);
            exit;
        }
        $comment = urldecode($comment);
        $stmt->bind_param("is", $storyId, $comment);
        if ($stmt->execute() === false) {
            $error = $stmt->error; // Store the error message before closing the statement
            $stmt->close(); // Close the statement
            echo json_encode(['success' => false, 'error' => 'Error executing statement: ' . $error]);
            exit;
        }
        $stmt->close();
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
$conn->close();
?>