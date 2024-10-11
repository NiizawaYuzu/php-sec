<?php //データの受け取り・受け渡しとDBへの処理を依頼する機能をまとめる（関数がある）ファイル
require_once('connection.php');
session_start(); 

// SESSIONにtokenを格納する
function setToken()
{
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));//ランダム16文字のバイト文字列を作り2進数から16進数に変換した値を$_SESSION['token']に代入
} //bin2hex：stringを16進数に変換した文字列を返す→

// SESSIONに格納されたtokenのチェックを行い、SESSIONにエラー文を格納する
function checkToken($token)
{
    if (empty($_SESSION['token']) || ($_SESSION['token'] !== $token)) { //
        $_SESSION['err'] = '不正な操作です';
        redirectToPostedPage();
    }
}

function unsetError()
{
    $_SESSION['err'] = '';
}

function redirectToPostedPage()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

function e($text)//エスケープ処理
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function createData($post)//関数の中に関数がある
{
  createTodoData($post['content']); // ここを追記
}

function getTodoList() // connection.php に記述した関数を呼び出す関数を実装する データの一覧を表示を行う
{
    return getAllRecords();//$dbh->query($sql)->fetchAll();が戻り値
}

function getSelectedTodo($id)//getTodoTextById($id)関数を実行している
{
    return getTodoTextById($id); 
}

function savePostedData($post)//getRefererPath()関数で定義したリクエスト元のページのパスで条件分岐し処理を振り分けている
{   
    checkToken($post['token']);//サーバー側とクライアント側のトークンの整合性を行う
    validate($post);
    $path = getRefererPath();
    switch ($path) {
        case '/new.php': //新規作成のページからPOSTされたなら
            createTodoData($post['content']);
            break;
        case '/edit.php': //編集ページからPOSTされたなら
            updateTodoData($post);//connection.phpでデータを更新する処理をしている
            break;
        case '/index.php': //削除処理のリクエスト元（index.php）からPOSTされたなら
            deleteTodoData($post['id']);
            break;
        default:
            break;
        }
}

function validate($post)//入力された値が、制限通りの内容になっているかを検証
{
    if (isset($post['content']) && $post['content'] === '') {
        $_SESSION['err'] = '入力がありません';
        redirectToPostedPage();
    }
}//送信されてきた情報が空の場合「入力がありません」と表示させる

function getRefererPath()//リクエスト元のURLを文字列で取得しそのパスを返す関数を定義
{
    $urlArray = parse_url($_SERVER['HTTP_REFERER']);
    // var_dump($urlArray);
    // exit();
    return $urlArray['path'];
}