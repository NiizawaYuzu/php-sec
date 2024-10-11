<?php //編集画面
require_once('functions.php');
setToken();
$todo = getSelectedTodo($_GET['id']);//index.phpでURLのパラメータとして渡したid取得し、そのまま関数に渡している
?>
<!-- $_で始まる特殊な変数はグローバル変数→どの関数やクラスからもアクセスが可能 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>編集</title>
</head>
<body>
  <?php if (!empty($_SESSION['err'])): ?> 
    <p><?= $_SESSION['err']; ?></p>
    <!-- pタグは段落であることを表す -->
  <?php endif; ?>
  <form action="store.php" method="post">
    <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>"> 
    <input type="hidden" name="id" value="<?= e($_GET['id']); ?>">
    <input type="text" name="content" value="<?= e($todo); ?>">
    <input type="submit" value="更新">
  </form>
  <div>
  <?php unsetError(); ?>
</body>
</html>