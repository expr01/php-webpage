<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/ViewPostDetailController.php');
session_start();

$_SESSION["post_id"] = $post['post_id'];
$_SESSION["user_id"] = $post['user_id'];

if (isset($_SESSION["user_id"])) {
  $currentUserId = $_SESSION['user_id'];
} else {
  // 로그인 되어 있지 않은 경우 처리
  echo "<script>alert('로그인이 필요합니다.');
  window.location.href = '../login.php';</script>";
  exit; // 작업 중지
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>게시글 상세 정보</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .post-details-container {
      width: 80%;
      margin: 20px auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    .post-content {
      border-bottom: 1px solid #ccc;
      padding-bottom: 20px;
      margin-bottom: 20px;
    }

    .comment-section {
      margin-top: 20px;
    }

    .comment-section h2 {
      margin-bottom: 10px;
    }

    textarea {
      width: calc(100% - 22px);
      padding: 8px;
      margin-bottom: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      resize: vertical;
    }

    .create-comment-button,
    .delete-comment-button {
      display: inline-block;
      margin-right: 10px;
    }

    .create-comment-button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .create-comment-button:hover {
      background-color: #0056b3;
    }

    .delete-comment-button {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .delete-comment-button:hover {
      background-color: #c0392b;
    }

    /* 모달 스타일 */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: white;
      margin: 25% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 400px;
      border-radius: 5px;
      text-align: center;
    }

    .modal-content p {
      margin-bottom: 20px;
    }

    .modal-content button {
      padding: 10px 20px;
      margin-right: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .modal-content button:nth-child(1) {
      background-color: #007bff;
      color: white;
    }

    .modal-content button:nth-child(1):hover {
      background-color: #0056b3;
    }

    .modal-content button:nth-child(2) {
      background-color: #f4f4f4;
      color: #333;
    }

    .modal-content button:nth-child(2):hover {
      background-color: #ddd;
    }
  </style>
</head>

<body>
  <div class="post-details-container">
    <div class="post-content">
      <h1><?php echo $post['post_title']; ?></h1>
      <p><?php echo $post['post_content']; ?></p>
      <p>Posted At: <?php echo $post['posted_at']; ?></p>
      <p>Modified At: <?php echo $post['modified_at']; ?></p>
    </div>

    <div class="comment-section">
      <h2>댓글</h2>
      <!-- 댓글을 보여주는 부분 -->
      <?php foreach ($comments as $comment) { ?>
        <!-- 여기서 comment에 post_id가 문자열로 되어있었던 것 같은데 왜 그런지 살펴봐야함 -->
        <?php if ((int)$post['post_id'] === (int)$comment['post_id']) { ?>
          <div class="comment">
            <p>Comment Id : <?php echo $comment['comment_id']; ?></p>
            <p>User Id : <?php echo $comment['user_id']; ?></p>
            <p>Comment Content : <?php echo $comment['comment_content']; ?></p>
            <p>Commented At : <?php echo $comment['commented_at']; ?></p>
            <!-- 여기에 댓글의 작성자, 작성 시간 등 추가 가능 -->
            <button type="submit" onclick="openDeleteCommentModal('<?php echo $comment['comment_id']; ?>', '<?php echo $comment['user_id']; ?>')"
            class="delete-comment-button">댓글 삭제</button>
          </div>
        <?php } ?>
      <?php } ?>
    </div>

    <div id="deleteCommentModal" class="modal">
      <div class="modal-content">
        <p>댓글을 삭제하시겠습니까?</p>
        <button onclick="deleteComment()">삭제</button>
        <button onclick="closeDeleteCommentModal()">취소</button>
      </div>
    </div>

    <!-- 댓글 입력 폼 -->
    <form action="../controllers/AddCommentController.php" method="POST">
      <label for="comment_content">댓글 작성:</label>
      <textarea id="comment_content" name="comment_content" required></textarea>
      <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
      <input type="hidden" name="user_id" value="<?php echo $post['user_id']; ?>">
      <input type="submit" value="댓글 작성" class="create-comment-button">
    </form>
  </div>
  </div>

  <script>
    let commentIdToDelete;

    // 댓글 삭제 모달 열기 함수
    function openDeleteCommentModal(commentId, commentUserId) {
      if (commentUserId === '<?php echo $currentUserId; ?>') {
        commentIdToDelete = commentId;
        document.getElementById('deleteCommentModal').style.display = 'block';
      } else {
        alert("본인의 댓글만 삭제할 수 있습니다.");
      }
    }

    // 댓글 삭제 모달 닫기 함수
    function closeDeleteCommentModal() {
      document.getElementById('deleteCommentModal').style.display = 'none';
    }

    // 댓글 삭제 함수
    function deleteComment() {
      window.location.href = `../controllers/DeleteCommentController.php?comment_id=${commentIdToDelete}`;
    }
  </script>
</body>

</html>