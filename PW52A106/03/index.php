<?php 
//会員専用TOPページのコントローラー
session_start();
//定数呼び出し
require_once '../../config.php';
//関数呼び出し
require_once './func.php';

//ログインせずにページを開いた場合
if(!isset($_COOKIE['id'])){
    header('location:./entry.php');
    exit;
}

//[ログアウト]ボタンを押された時
if(isset($_POST['state']) && $_POST['state'] == 'logout'){
    //Cookieを消す
    setcookie('id','',time() - 60 * 60);
    setcookie('page','',time() - 60 * 60);
    session_destroy();
    header('location:./login.php');
    exit;
}

//ニュースのタイトルを押された時（PDFのダウンロード処理）
if(isset($_GET['news_id'])){
    //DBからニュースの中身を取ってくる
    $link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
    mysqli_set_charset($link , 'utf8');
    $news_id = sql_sanitize($link,$_GET['news_id']);    //サニタイズ
    $sql = "SELECT * FROM m_news WHERE id =" . $news_id . ";";
    $result = mysqli_query($link ,$sql);    //該当IDのニュースデータを取ってきた状態
    $row = mysqli_fetch_assoc($result);  //そいつを1行ずつ取っていくぜ
    mysqli_close($link);

    require_once PDF_PATH;
    $mpdf = new \Mpdf\Mpdf([
        'fontdata' =>[
            'ipa' =>[
                'R' => 'ipag.ttf'
            ]
        ],
        'format' => 'A4-P',
        'mode' => 'ja',
    ]);

    $mpdf -> WriteHTML('<h1>'.$row['title'].'</h1>'); 
    $mpdf -> WriteHTML('<p>'.$row['created_at'].'</p>');
    $mpdf -> WriteHTML('<hr>');
    $mpdf -> WriteHTML('<p>'.$row['content'].'</p>');

    //最後にOutputでPDFを出力する
    $mpdf -> Output('dl_'.date("YmdHis").'.pdf','D');
}

/* //ログイン中に、最初にページを開いた時 or 数値以外のページ番号をパラメータへ入力された場合（1ページに飛ぶ）
if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
    header('location:./index.php?page=1');
    exit;
} */

if(isset($_GET['page'])){
    setcookie('page',$_GET['page'],time() + 60 * 60);
    header('location:./index.php');
}
if(!isset($_COOKIE['page'])){
    setcookie('page',1,time() + 60 * 60);
    header('location:./index.php');
}
$page = $_COOKIE['page'];

//ようこそ〇〇さんを出すための処理
$id = $_COOKIE['id'];
//総件数を取得するSQL
$sql = "SELECT * FROM m_user WHERE id =" . $id . ";";
//DB連結したい
$link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
mysqli_set_charset($link , 'utf8');
//ログインしている会員の名前をとってくる
$result = mysqli_query($link ,$sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$img = $row['file_name'];
mysqli_close($link);

//初期化
$list = [];
//１ページごとの表示件数
$line = 5;
/* //ページ番号
$page = (int)$_GET["page"]; //悪意の値を受け付けないように数値へ変換 */

//各ページごとにとってくるデータの先頭の添字
$top_key = ($page - 1) * $line;

//＝＝＝＝＝　SQL文を作成　＝＝＝＝＝
//総件数を取得するSQL
$sql_count = "SELECT COUNT(*) AS 'count' FROM m_news";

//表示件数分（今回なら5件）のデータを取得するSQL
/* //LIMIT句の生成
$limit = SQL_part_of_LIMIT($top_key,$line);
$sql = "SELECT * FROM m_news ORDER BY created_at DESC " . $limit; */
$sql = "SELECT * FROM m_news ORDER BY created_at DESC LIMIT $top_key,$line";

//SQL文最終調整
$sql_count .= ";"; 
$sql .= ";";

//＝＝＝＝＝　データベースへの連結部分　＝＝＝＝＝
//DB連結したい
$link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
mysqli_set_charset($link , 'utf8');
//まず、DBから総件数をとってくる
$result = mysqli_query($link ,$sql_count);
$row = mysqli_fetch_assoc($result);
mysqli_close($link);

//総件数を元にして総ページ数を求める
$total_page = (int)ceil($row['count'] / $line);

//存在しないページ番号を入力された場合（1ページに飛ぶ）
if($page < 1 || $total_page < $page){
    header('location:./index.php?page=1');
}


//DB連結したい
$link = mysqli_connect( HOST , USER_ID , PASSWORD , DB_NAME);
mysqli_set_charset($link , 'utf8');
//続いて、DBから1ページ分のデータをとってくる
$result = mysqli_query($link ,$sql);    //５件分だけ取ってきた状態
while($row = mysqli_fetch_assoc($result)){  //そいつを1行ずつ取っていくぜ
    $news_list[] = $row; //配列に突っ込むぜ
}
mysqli_close($link);


//＝＝＝＝＝　リンク部分　＝＝＝＝＝
//ページ番号のリンク部分
/* $page_array = array_for_PageNumLink($total_page,$page,'nomal','active'); */
$page_array = array_for_pageNation($total_page,$page,'nomal','active','none');
//「前へ」、「次へ」のclassを初期化
$top_class = 'nomal';
$last_class = 'nomal';
//最初のページの時「前へ」のリンクを切るCSSを適応
if($page == 1){
    $top_class = 'active';
}
//最後のページの時「次へ」のリンクを切るCSSを適応
if($page == $total_page){
    $last_class = 'active';
}

//ビューの表示
require_once 'tpl/index.php';
?>