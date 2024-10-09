<?php
require_once('connection.php');
function createData($post)
{
  createTodoData($post['content']); // ここを追記
}

function getTodoList() // connection.php に記述した関数を呼び出す関数を実装する
{
    return getAllRecords();//$dbh->query($sql)->fetchAll();が戻り値
}