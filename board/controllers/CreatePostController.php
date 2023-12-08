<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB 연결
require_once($_SERVER['DOCUMENT_ROOT'] . '/models/PostModel.php');

// 데이터베이스 연결 정보
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// POST로 받은 데이터 가져오기
$user_id = $_SESSION['user_id'];
$post_title = $_POST['post_title'];
$post_content = $_POST['post_content'];
$is_attached = !empty($_FILES['file']['name']) ? 1 : 0;
// 파일 업로드 처리는 따로 구성

// PostModel 인스턴스 생성
$postModel = new PostModel($conn);

// 가져온 데이터를 화면에 표시
$posts = $postModel->getPostList();

// 데이터베이스에 글 작성
if ($postModel->createPost($user_id, $post_title, $post_content, $is_attached)) {
    echo "글이 성공적으로 작성되었습니다.";
} else {
    echo "글 작성에 실패했습니다.";
}
?>