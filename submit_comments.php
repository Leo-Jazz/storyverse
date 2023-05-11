<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $storyId = $_POST["storyId"];
    $likes = isset($_POST["likes"]) ? $_POST["likes"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;
    $likes = isset($_POST["likes"]) ? $_POST["likes"] : null;


    if (!isset($_POST["storyId"]) || empty($_POST["storyId"])) {
        echo json_encode(['success' => false, 'error' => 'Story ID not provided.']);
        exit;
    }
    

    if ($likes !== null) {
        // Update likes in the database
        $sql = "UPDATE stories SET likes = likes + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $storyId);
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
