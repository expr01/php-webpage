<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Write Post</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .writepost-container {
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 70%;
      max-width: 800px; /* 최대 너비 지정 */
      margin: auto; /* 중앙 정렬을 위한 margin 추가 */
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }

    label {
      margin-bottom: 15px;
    }

    input[type="text"],
    textarea,
    input[type="file"],
    input[type="submit"] {
      width: 100%;
      max-width: 500px; /* 최대 너비 지정 */
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box; /* padding과 border를 width에 포함 */
    }

    textarea {
      height: 150px;
    }

    input[type="submit"] {
      background-color: #3498db;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <div class="writepost-container">
    <h2>Write Post</h2>
    <!-- 글 작성 폼 -->
    <form action="../controllers/CreatePostController.php" method="POST" enctype="multipart/form-data">
      <label for="post_title">Title:</label>
      <input type="text" id="post_title" name="post_title" required>
      <label for="post_content">Content:</label>
      <textarea id="post_content" name="post_content" required></textarea>
      <label for="file">Attachment:</label>
      <input type="file" id="file" name="file">
      <input type="submit" value="Submit">
    </form>
  </div>
</body>
</html>