<?php 
//会員仮登録TOPのコントローラー
//session_start();
//定数呼び出し
require_once '../../config.php';
//関数呼び出し
require_once './func.php';

//初期化
$err = [];  //エラーメッセージ入れるための配列
$file_type = ['jpg'];   //OKな形式

//不正なアクセスをされた場合
if(!isset($_GET['login_id'])){
    header('location:./entry.php');
    exit;
}
//GETからハッシュ化されたログインIDの受け取り
$hash_login_id = $_GET['login_id'];
//DB接続
$link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
mysqli_set_charset($link , 'utf8');
$hash_login_id = sql_sanitize($link,$hash_login_id);
//ログインIDにより仮登録者の氏名を取得
$sql = "SELECT * FROM m_user WHERE hash_login_id = '" . $hash_login_id . "'";
$result = mysqli_query($link ,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($link);

//氏名欄に入れ込む
$name = $row['name'];

//[登録]ボタンを押された時
if(isset($_POST['state']) && $_POST['state'] == 'main_entry'){
    $_GET['login_id'] = $row['hash_login_id'];
    //入力値チェック
    //パスワードのエラーメッセージ
    if($_POST['password'] == ''){//未入力ですか？
        $err['password'] = 'パスワードを入力してください。';
    }else{
        //仮登録内容とID、パスワードの組み合わせ照合
        //DBにあるデータを使ってパスワードの照合をする
        $salt = $row['salt'];
        $stretch = $row['stretch'];
        //パスワードをハッシュ化します
        $hash_password = hash_val($_POST['password'],$salt,$stretch);
        if($hash_password !== $row['password']){
            $err['match'] = '※該当するユーザーはいません。';
        }
    }
    //ファイルのエラーメッセージ
    //アップロードされたファイルの受け取り
    $upload_file = $_FILES['file'];
    if($upload_file['name'] == ''){ //ファイルがアップされているか？
        $err['file'] = '※ ファイルを選択してください。';
    }
    else{
        //拡張子のチェック
        $err['ext'] = "※ ファイル形式が違います。";
        $ext_check = [];
        $ext_check = explode('.',$upload_file['name']);
        $ext = $ext_check[count($ext_check)-1];
        foreach ($file_type as $val) {
            if ($ext == $val) {
                unset($err['ext']);
            }
        }
    }

    //以上のエラーチェックを全てクリアした場合。
    if(count($err) == 0){
        //◎画像サイズを取得
        $img_size = getimagesize($_FILES['file']['tmp_name']);
        //[0]…幅width
        //[1]…高さheight
        //[2]…ファイルタイプ
            //gif…1
            //jpeg(jpgも)…2
            //png…3
            //・・・
        //[3]…imgタグ用
        //失敗した場合…false

        //比率を保って縮小
        $width_per = 60 / $img_size[0];
        $height_per = 70 / $img_size[1];
        if($width_per < $height_per){
            $width = $img_size[0] * $width_per;
            $height = $img_size[1] * $width_per;
        }
        else{
            $height = $img_size[1] * $height_per;
            $width = $img_size[0] * $height_per;
        }        

        //画像ファイルがjpgの場合
        if($img_size[2] == 2){
            //◎画像ファイルのコピーおよび画像ファイルの縮小拡大(jpg)
            $img_in=imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
            $img_out=ImageCreateTruecolor($width,$height);
            ImageCopyResampled($img_out,$img_in,0,0,0,0,$width,$height,$img_size[0],$img_size[1]);
            mkdir("./images/user/" . $row['id'], 0777);
            Imagejpeg($img_out,'images/user/' . $row['id'] . '/thumb_' . $upload_file['name']);
        }

        //◎画像加工を行った後は、メモリを開放すること
        ImageDestroy($img_in);
        ImageDestroy($img_out);

        //元のファイル名を代入
        $img = $upload_file['name'];
        //ユーザーの状態を「本登録：１」にする
        $user_state = 1;

        //DB接続
        $link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
        mysqli_set_charset($link , 'utf8');
        $img = sql_sanitize($link,$img);
        //SQL文作成（ついでにuser_stateも１へ変更）
        $sql = "UPDATE m_user SET user_state = " . $user_state . " , file_name = '" . $img . "' WHERE hash_login_id = '" . $row['hash_login_id'] . "';";
        mysqli_query($link ,$sql);

        mysqli_close($link);
      
        //画像をimgフォルダに格納
        move_uploaded_file($upload_file['tmp_name'],'./images/user/' . $row['id'] . '/' . $upload_file['name']);
        
        //入力内容の確認ページへ遷移
        header('location:./main_complete.php');
        exit;
    }
}

//ビューの表示
require_once 'tpl/main_entry.php';
?>