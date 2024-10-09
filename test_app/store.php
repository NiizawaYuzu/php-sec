<?php
require_once('functions.php');

createData($_POST);
header('Location: ./index.php');//header関数指定したファイルに遷移することができる
