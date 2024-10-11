<?php
require_once('config.php');//require_once式は指定されたファイルを読み込み、ファイルがすでに読み込まれているかどうかを PHP がチェックする

// PDOクラス（DBとやり取りをすることができるメソッドが詰め込まれているクラス）のインスタンス化
function connectPdo()//PDOという定義済みのクラスをインスタンス化している/例外処理をするための記述
{
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD); //throw new　例外クラス名（引数）で例外を発生させる
    } catch (PDOException $e) { //Exceptionではなく「PDOException」と別のクラスになっている＝PDOを使用してDBにアクセスする際に発生する例外クラスだから
        echo $e->getMessage();  //getMessage()は例外メッセージを取得するインスタンスメソッド。
        exit();
    }//try{例外を発生させるコード}catch{例外が発生した場合の処理}
}

function createTodoData($todoText)
{
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (content) VALUES (:todoText)'; //プレースホルダーはSQL文中の変動する箇所(:todoText)＝文字列に使用する。あくまで値として処理されSQL命令を出さなくなる
    $stmt = $dbh->prepare($sql); //prepare()メソッドにsql文を引数に入れて実行する準備をしている
    $stmt->bindValue(':todoText', $todoText, PDO::PARAM_STR); //上記のプレースホルダーに値をセットし
    $stmt->execute(); //INSERT文を実行している
} //TRUNCATE TABLEで指定したテーブルのレコードを全削除するというSQL文

function getAllRecords()
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL'; //データ取得処理だからselect文を使う。todosテーブルから、deleted_atがNULLのものに絞り込みをかけてレコードを全件取得する
    return $dbh->query($sql)->fetchAll();//$dbh->query($sql)でDBに対して作成したSQL文で実行し、fetchall()で実行結果を全配列で取得
}//queryメソッドの戻り値はPDOstaementオブジェクト。PDOstaementクラスのメソッドがfetchAll

function updateTodoData($post)//DBで既に作成・登録したデータを更新
{
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET content = :todoText WHERE id = :id';//todosテーブルの全データの中から指定したidに絞って'content'を更新する
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':todoText', $post['content'], PDO::PARAM_STR);
    $stmt->bindValue(':id', (int) $post['id'], PDO::PARAM_INT);
    $stmt->execute();
}

function getTodoTextById($id)//編集画面に現在保存されているTODOの内容を返す
{
    $dbh = connectPdo();
    $sql = "SELECT * FROM todos WHERE deleted_at IS NULL AND id = :id";//$idが変数だから''ではなく""で囲う AND id = $id選択したID
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();
    return $data['content'];
}

function deleteTodoData($id)//データの論理削除処理（指定したidのレコードの deleted_atを現在時刻に更新する処理）
{
    $dbh = connectPdo();
    $now = date('Y-m-d H:i:s');
    $sql = "UPDATE todos SET deleted_at = '$now' WHERE id = :id";//""で文字列としているから中に''しても変数展開はされる。文字列結合と同等の扱いがある。
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
   
}