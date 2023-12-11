<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/CommentModel.php');

// 데이터베이스 연결을 설정
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

// 데이터베이스 연결을 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 데이터베이스 연결 여부를 확인
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// PostModel의 인스턴스를 생성
$CommentModel = new CommentModel($conn);

$commentContent = $_POST['comment_content']; // 댓글 내용
$postId = $_POST['post_id']; // 게시물 ID
$userId = $_POST['user_id']; // 사용자 ID

// 게시물 추가
$added = $CommentModel->addComment($postId, $userId, $commentContent);

// 추가 성공 여부 확인
if ($added) {
  echo "<script>alert('댓글이 성공적으로 추가되었습니다.');
      window.location.href = '../views/view_post_detail.php?post_id=$postId&user_id=$userId';</script>";
} else {
  echo "<script>alert('댓글 추가에 실패했습니다.');
      window.location.href = '../views/view_post_detail.php?post_id=$postId&user_id=$userId';</script>";
}

// 데이터베이스 연결 끊기
$conn->close();

?>