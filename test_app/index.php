<?php //追記 HTMLとPHPを混合して書く方法
require_once('functions.php'); //追記
?> 

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
</head>
<body>
  welcome hello world
  <div>
     <a href="new.php">
       <p>新規作成</p>
     </a>
  </div>
  <div> 
    <table>
      <tr>
        <th>ID</th>
        <th>内容</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
      <?php foreach (getTodoList() as $todo): ?> 
        <!-- =はechoの省略形。HTMLとphpが混在してるときphpタグ内でechoを使用すこの書き方  -->
        <tr>
          <td><?= $todo['id']; ?></td>
          <td><?= $todo['content']; ?></td>
          <td>
            <a href="">更新</a>
          </td>
          <td>
            <form action="store.php" method="post">
              <input type="hidden" name="id" value="">
              <button type="submit">削除</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?> <!-- HTTMLと混在してPHPの処理を書くときにのみ、：とendforach;とかく-->
    </table>
  </div>
</body>
</html>