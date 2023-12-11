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

$postModel = new PostModel($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // POST로 전달된 데이터를 변수에 할당
  $postId = $_POST['post_id'];
  $title = $_POST['post_title'];
  $content = $_POST['post_content'];
  $isAttached = !empty($_FILES['file']['name']) ? 1 : 0;

  // 해당 ID를 가진 게시글을 업데이트
  $updated = $postModel->updatePost($postId, $title, $content, $isAttached); // updatePost 메소드를 사용하여 게시글을 업데이트

  if ($updated) {
    echo "<script>alert('게시글이 성공적으로 업데이트 되었습니다.');
        window.location.href = '../views/post_list.php';</script>";
  } else {
    echo "<script>alert('게시글 업데이트에 실패했습니다.');
        window.location.href = '../views/post_list.php';</script>";
  }
}
