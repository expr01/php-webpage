<?php

class CommentModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addComment($postId, $userId, $commentContent)
    {
        $query = "INSERT INTO comments (post_id, user_id, comment_content) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $postId, $userId, $commentContent);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteComment($commentId)
    {
        $query = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $commentId);

        if ($stmt->execute()) {
            return true; // 삭제 성공
        } else {
            return false;
        }
    }

    public function getCommentsById($postId)
    {
        $sql = "SELECT * FROM comments WHERE post_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }

        return $comments;
    }

    // 게시물 ID에 해당하는 모든 댓글을 가져오는 메서드
    public function getAllComments()
    {
        $query = "SELECT * FROM comments";
        $result = $this->conn->query($query);

        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }
        return $comments;
    }
}
