<?php //fromタグのactionに書いたstore.phpを作成
require_once('functions.php');//引数に渡したfunctions.phpファイルで定義されている関数を使用できるようにする関数

savePostedData($_POST); // 追記 呼び出している関数はfunction.phpに定義 更新の際のPOST先
header('Location: ./index.php');
//HTTPヘッダは、クライアントからのリクエスト（要求）→サーバーからのレスポンス（応答）の流れにおいてどんな情報を要求して、どんなコンテンツを受け取るのかを定義
//header関数でLocationを使ってURLを指定すれば、指定のページへリダイレクトできる