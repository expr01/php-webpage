<?php
class PostModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function createPost($user_id, $title, $content, $is_attached)
  {
    $query = "INSERT INTO posts (user_id, post_title, post_content, is_attached) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("isss", $user_id, $title, $content, $is_attached);

    // 데이터 삽입 실행
    if ($stmt->execute()) {
      return true; // 글이 성공적으로 작성됨
    } else {
      return false; // 글 작성 실패
    }
  }

  public function getPostList()
  {
    $query = "SELECT user_id, post_title, post_content, posted_at FROM posts";
    $result = $this->conn->query($query);

    if ($result->num_rows > 0) {
      $posts = array();
      while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
      }
      return $posts;
    } else {
      return array();
    }
  }
}
