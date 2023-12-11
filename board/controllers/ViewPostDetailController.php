<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/PostModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/models/CommentModel.php');

$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$postModel = new PostModel($conn);
$CommentModel = new CommentModel($conn);

$postId = $_GET['post_id'];
$userId = $_GET['user_id'];

$post = $postModel->getPostById($postId);
$comments = $CommentModel->getAllComments();

$conn->close();
?>