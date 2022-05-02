<?php 
//【会員仮登録】確認画面のコントローラー
session_start();
//定数呼び出し
require_once '../../config.php';
//関数呼び出し
require_once './func.php';

if(!isset($_SESSION['name'])){
    header('location:./entry.php');
    exit;
}

//この確認ページで「戻る」ボタンを押された場合
if(isset($_POST['state']) && $_POST['state'] == 'back'){//確認画面で戻るボタンを押された場合。
    //もう一度登録画面に戻るよ。
    header('location:./entry.php');
    exit;
}

//「登録」ボタンを押された場合
if(isset($_POST['state']) && $_POST['state'] == 'entry'){
    //SESSIONの受け取り（どっかのタイミングでこの子らSQLサニタイズをしなくては！）
    $name = $_SESSION['name'];
    $login_id = $_SESSION['login_id'];
    $password = $_SESSION['password'];
    $mail = $_SESSION['mail'];
    

    //値の加工処理(パスワード)
    //ソルトとなるランダムな文字列を生成
    $salt = uniqid();
    //ストレッチ回数となるランダムな数値を生成
    $stretch = rand(1000, 10000);
    //パスワードをハッシュ化します
    $hash_password = hash_val($password,$salt,$stretch);

    //メール送信用にログインIDをハッシュ化
    $hash_login_id = md5($login_id);

    //ユーザーの状態を「仮登録：０」にする
    $user_state = 0;

    //SQL文作成
    $sql = "INSERT INTO m_user (name,mail,login_id,password,hash_login_id,salt,stretch,user_state) VALUES ('" . $name . "','" . $mail . "','" . $login_id . "','" . $hash_password . "','" . $hash_login_id . "','" . $salt . "'," . $stretch . "," . $user_state . ");";

    //DB接続
    $link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
    mysqli_set_charset($link , 'utf8');
    mysqli_query($link ,$sql);
    
    mysqli_close($link);

    //「仮登録完了」のメールを送信する
    //言語と文字コードを設定
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    //メールの情報を設定
    $mailto = $mail;
    $title = "仮登録OK";
    $url = BASE_URL . "03/main_entry.php?login_id=" . $hash_login_id;
    $message = "仮登録が完了しました。こちらのURLから本登録へお進みください。";
    $headers = "From:" . FROM;

    if(mb_send_mail($mailto,$title,$message . $url,$headers)){
        //echo "送信成功";
        echo $message . $url;
        $_SESSION['mailto'] = $mailto;
        $_SESSION['title'] = $title;
        $_SESSION['message'] = $message;
        $_SESSION['url'] = $url;
        $_SESSION['headers'] = $headers;

        header('location:./temp_complete.php');
        exit;

    }/* else{
        echo "送信失敗";
    } */
}

//ビューの表示
require_once 'tpl/temp_confirm.php';
?>