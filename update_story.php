<?php
header("Content-Type: application/json");

if (
    !isset($_POST["id"]) ||
    !isset($_POST["story_name"]) ||
    !isset($_POST["author_name"]) ||
    !isset($_POST["story_language"]) ||
    !isset($_POST["story_text"])
) {
    echo json_encode([
        "success" => false,
        "error" => "Required fields are missing.",
    ]);
    exit();
}

require_once "db_connection.php";

$id = $_POST["id"];
$story_name = $_POST["story_name"];
$author_name = $_POST["author_name"];
$story_language = $_POST["story_language"];
$translation_language = isset($_POST["translation_language"]) ? $_POST["translation_language"] : "";
$story_text = $_POST["story_text"];
$translation_text = isset($_POST["translation_text"]) ? $_POST["translation_text"] : "";

$sql = "UPDATE stories SET story_name = ?, author_name = ?, story_language = ?, translation_language = ?, story_text = ?, translation_text = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssi",
    $story_name,
    $author_name,
    $story_language,
    $translation_language,
    $story_text,
    $translation_text,
    $id
);

$success = $stmt->execute();

if ($success) {
    echo json_encode([
        "success" => true,
    ]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "Failed to update the story.",
    ]);
}

$stmt->close();
$conn->close();
