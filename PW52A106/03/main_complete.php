<?php 
//【会員仮登録】完了画面のコントローラー
session_start();
//定数呼び出し
require_once '../../config.php';
//関数呼び出し
require_once './func.php';

//不正なアクセスをされた場合
/* if(!isset($_SESSION['url'])){
    header('location:./entry.php');
    exit;
} */

//ビューの表示
require_once 'tpl/main_complete.php';
?>