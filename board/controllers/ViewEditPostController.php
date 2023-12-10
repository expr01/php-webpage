<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/PostModel.php');

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

// 만약 GET 요청으로 전달된 ID가 있다면
if (isset($_GET['id'])) {
  // 해당 ID를 사용하여 게시글 정보를 가져옴.
  $postId = $_GET['id'];
  $post = $postModel->getPostById($postId); // 예시에서는 getPostById 메소드를 사용한다고 가정합니다.
}
?>