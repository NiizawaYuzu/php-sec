<?php //追記 HTMLとPHPを混合して書く方法
require_once('functions.php'); 
header('Set-Cookie: userId=123');
setToken(); //functions.phpで定義したsetToken関数を呼び出している。ここではstore.phpへのリクエストは  new.php, edit.php, index.php からのみに限定している
?> 

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
</head>
<body>
  <?php if (!empty($_SESSION['err'])): ?>
    <p><?= $_SESSION['err']; ?></p> 
  <?php endif; ?>
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
        <td><?= e($todo['id']); ?></td> 
        <td><?= e($todo['content']); ?></td> 
          <td>
          <a href="edit.php?id=<?= e($todo['id']); ?>">更新</a>
           <!-- ?1以下はクエリパラメータ（サーバーへ送りたいデータを指定するためにURLの最後に追加する文字列）：edit.phpに遷移し、クエリパラメータのデータをGET（GETはなにか情報を検索したり取得するためのメソッド）でedit.phpに送ることができる。 -->
          </td>
          <td>
            <form action="store.php" method="post">
              <input type="hidden" name="id" value="<?= e($todo['id']); ?>"> <!-- 編集 -->
              <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
              <button type="submit">削除</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?> <!-- HTTMLと混在してPHPの処理を書くときにのみ、：とendforach;とかく-->
    </table>
  </div>
  <?php unsetError(); ?>
  <!-- sessionのキーであるerrに格納したエラーメッセージを空文字にして、ブラウザ上にエラーメッセージを表示させないようにする-->
</body>
</html>