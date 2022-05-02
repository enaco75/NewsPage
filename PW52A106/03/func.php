<?php 
//＝＝＝＝＝　ハッシュ化する関数
//引数1：ハッシュしようとする値
//引数2：ソルト
//引数3：ストレッチ回数
function hash_val($pass,$salt,$stretch_cnt){
    for($i=1;$i<=$stretch_cnt;$i++){
        $pass = md5($salt . $pass);  //これなら1行で済む
        //$pass = $slt . $pass;
        //$pass = md5($pass);
    }
    return $pass;
}


//＝＝＝＝＝　SQL文のLIMIT句を作る関数
//引数1：何行目から（数値）
//引数2：何行分取ってくるのか（数値）
//戻り値：完成形のLIMIT句（文字列）
//※SQL文にくっつける時はLIMITの前に空白が入ってないのでご注意ください。
function SQL_part_of_LIMIT($top_key,$line){
    $limit = "LIMIT " . $top_key . "," . $line;
    return $limit;
}


//＝＝＝＝＝　ページャのページ番号からのリンク部分を生成するのに必要な配列を返します
//引数1：総ページ数（数値）
//引数2：今開いているページ番号（数値）
//引数3：（今開いていない）普通のaタグにつけるclass名（文字列）
//引数4：リンクをカットしたりCSSで制御する方（今開いてるページ）のaタグにつけるclass名（文字列）
//戻り値：ページ番号とclass名が入った2次元（連想）配列
function array_for_PageNumLink($total_page,$reading_page,$class1,$class2){
    $page_array = [];
    for($i=1;$i<=$total_page;$i++){
        $list['page'] = $i;
        $list['class'] = $class1;
        if($i == $reading_page){
            $list['class'] = $class2;    //閲覧中のページ番号にはリンクを切るCSSを適応
        }
        $page_array[] = $list;
    }
    return $page_array;
}

//＝＝＝＝＝　ページネーションを生成するのに必要な配列を返します❷
//引数1：総ページ数（数値）
//引数2：今開いているページ番号（数値）
//引数3：普通のaタグにつけるclass名（文字列）show
//引数4：リンクをカットしたりCSSで制御する方（今開いてるページ）のaタグにつけるclass名（文字列）active
//引数5：リンクに表示されないaタグにつけるclass名（文字列）none
//戻り値：ページ番号とclass名が入った2次元（連想）配列
function array_for_pageNation($total_page,$reading_page,$class1='show',$class2='active',$class3='none'){
    $page_array = [];
    for($i=1;$i<=$total_page;$i++){
        $list['page'] = $i; //ひとまずページ番号をぶっこむ
        $list['class'] = $class3;   //noneのクラスもぶっこむ
        $list['before_dot'] = '';
        $list['after_dot'] = '';
        $page_array[] = $list;
    }
    
    //今見ているページが1~3ページの場合
    if($reading_page <= 3){
        for($j=1;$j<=5;$j++){
            unset($page_array[$j-1]['class']);  //一旦1~5ページのclassを抹消する
            $page_array[$j-1]['class'] = $class1;   //1~5ページにshowを入れ直す
        }
    }
    //今見ているページが67~最後のページの場合
    elseif($reading_page >= $total_page-2){
        for($j=$total_page-4;$j<=$total_page;$j++){
            unset($page_array[$j-1]['class']);  //一旦1~5ページのclassを抹消する
            $page_array[$j-1]['class'] = $class1;   //1~5ページにshowを入れ直す
        }
    }
    elseif(3 < $reading_page && $reading_page < $total_page-2){
        //(それ以外で)今見ているページが4~66ページの時
        $start = $reading_page - 2;
        $end = $reading_page + 2;
        for($j=$start;$j<=$end;$j++){
            unset($page_array[$j-1]['class']);  //一旦閲覧ページとその前後2ページ分classを抹消する
            $page_array[$j-1]['class'] = $class1;   //閲覧ページとその前後2ページにshowを入れ直す
        }
        unset($page_array[0]['class']);  //1ページのclassを抹消する
        $page_array[0]['class'] = $class1;   //1ページにshowを入れ直す

        unset($page_array[$total_page-1]['class']);  //最後のページのclassを抹消する
        $page_array[$total_page-1]['class'] = $class1;   //最後のページにshowを入れ直す

        $page_array[0]['before_dot'] = '･･･';
        $page_array[$total_page-1]['after_dot'] = '･･･';
    }

    $page_array[$reading_page-1]['class'] .= ' '.$class2;    //閲覧中のページ番号にはリンクを切るCSSを適応
    
    return $page_array;
}

//＝＝＝＝＝　関数mysqli_real_escape_stringを省略するためだけの関数
//引数1：手続き型（＝ 接続識別子：いつも$linkって書いてるアレ）
//引数2：エスケープしたい文字列
//戻り値：エスケープ済みの文字列
function sql_sanitize($link,$val){
    return mysqli_real_escape_string($link,$val);
}

//＝＝＝＝＝　関数htmlspecialcharsを省略するためだけの関数
function h($val){
    return htmlspecialchars($val,ENT_QUOTES);
}

//＝＝＝＝＝　桁数チェック（半角英数）
//引数１：値
//引数２：下限の数値
//引数３：上限の数値
//引数４：チェックの方法（0:未満・以内、1:以下&以上（○〜○桁で））
function check_digit($val,$digit_min='',$digit_max='',$check_style){

    switch ($check_style) {
        case 0: //〜桁以内で
            if (strlen($val) > $digit_max) {
                $err_msg = '※ 半角英数'.$digit_max.'桁以内で入力してください。';
                return $err_msg;
            }
            return false;
            break;
        case 1: //○〜○桁で
            if (strlen($val) < $digit_min || $digit_max < strlen($val)) {
                $err_msg = '※ 半角英数'.$digit_min.'〜'.$digit_max.'桁で入力してください。';
                return $err_msg;
            }
            return false;
            break;

    }
}

//＝＝＝＝＝　妥当性チェック(引数：入力数値,制限したい桁数)
function check_date($date_val,$digit=''){
    
    if (!is_numeric($date_val)) {   //数値で入力されているか？
        $err_msg = '※ 日付を数値(半角)で入力してください。';
        return $err_msg;
    }
    elseif (strlen($date_val) !== $digit) {  //(今回なら)8桁かどうか？
        $err_msg = '※ 日付は数値(半角)'.$digit.'桁で入力してください。';
        return $err_msg;
    }

    //8桁の数値で入力された日付をYYYYmmddに分割
    $year = substr($date_val,0,4);
    $month = substr($date_val,4,2);
    $day = substr($date_val,6,2);
    if(!checkdate((int)$month,(int)$day,(int)$year)){
        $err_msg = '※ 正確な日付を入力してください。';
        return $err_msg;
    }
    return false;
}
?>