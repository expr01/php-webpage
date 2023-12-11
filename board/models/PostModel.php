<?php
class PostModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function insertPostWithUserID($user_id, $title, $content, $is_attached)
  {
    $query = "INSERT INTO posts (user_id, post_title, post_content, is_attached) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("isss", $user_id, $title, $content, $is_attached);

    if ($stmt->execute()) {
      return true; // 글이 성공적으로 작성됨
    } else {
      return false; // 글 작성 실패
    }
  }

  // posts 테이블에서 모든 글을 가져오는 메서드
  public function getAllPosts()
  {
    $query = "SELECT * FROM posts";
    $result = $this->conn->query($query);

    $posts = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
      }
    }
    return $posts;
  }

  public function getPostById($postId)
  {
    $query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      $post = $result->fetch_assoc();
      return $post;
    } else {
      return null; // 해당 ID의 게시글을 찾을 수 없을 때
    }
  }

  public function updatePost($postId, $title, $content, $isAttached)
  {
    $query = "UPDATE posts SET post_title = ?, post_content = ?, modified_at = current_timestamp(), is_attached = ? WHERE post_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssii", $title, $content, $isAttached, $postId);

    if ($stmt->execute()) {
      return true; // 게시글이 성공적으로 업데이트됨
    } else {
      return false; // 게시글 업데이트 실패
    }
  }

  public function deletePost($postId)
  {
    $query = "DELETE FROM posts WHERE post_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $postId);

    if ($stmt->execute()) {
      return true; // 게시글이 성공적으로 삭제됨
    } else {
      return false; // 게시글 삭제 실패
    }
  }
}
