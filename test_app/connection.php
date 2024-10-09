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
    $sql = 'INSERT INTO todos (content) VALUES ("' . $todoText . '")';
    $dbh->query($sql); //$sqlをqueryメソッドの引数に渡して実行することでINSERT文を実行できる
}

function getAllRecords()
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL'; //データ取得処理だからselect文を使う。todosテーブルから、deleted_atがNULLのものに絞り込みをかけてレコードを全件取得する
    return $dbh->query($sql)->fetchAll();//$dbh->query($sql)でDBに対して作成したSQL文で実行し、fetchall()で実行結果を全配列で取得
}//queryメソッドの戻り値はPDOstaementオブジェクト。PDOstaementクラスのメソッドがfetchAll