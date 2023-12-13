<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/PostModel.php');

//DB 연결부
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
  $postId = $_GET['id'];

  // PostModel 인스턴스 생성 (DB 연결 객체 필요)
  $postModel = new PostModel($conn);

  // 글 삭제 시도
  $deleted = $postModel->deletePost($postId);

  if ($deleted) {
    echo "<script>alert('게시글이 성공적으로 삭제되었습니다.');
        window.location.href = '../views/post_list.php';</script>";
  } else {
    echo "<script>alert('게시글 삭제에 실패했습니다.');
        window.location.href = '../views/post_list.php';</script>";
  }
} else {
  // 적절한 요청이 아닐 때 처리할 내용
  // 예를 들어, POST 요청인데 id가 전달되지 않았을 경우 등
  // 에러 처리 로직을 추가
}
?>