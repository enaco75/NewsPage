<!-- 仮登録｜確認ページのビュー -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>仮会員登録｜確認ページ</title>
</head>
<body>
<div id="wrapper">

    <header>
        <h1>enaco</h1>
    </header>

    <main>
        <div class="form_wrap">
            <form action="./temp_confirm.php" method="post">
                <div  class="_intro">
                    <h2>登録内容の確認</h2>
                    <p>
                    入力した内容を確認してください。<br>
                    変更があれば「<strong>戻る</strong>」、
                    変更がなければ「<strong>登録</strong>」<br>
                    を押してください。
                    </p>
                </div>

                <div class="input_wrap">
                    <h3>氏名</h3>
                    <div class="input_set"><p class="namae"><?php echo $_SESSION['name'];?></p></div>
                </div>
                                
                <div class="input_wrap">
                    <h3>ログインID</h3>
                    <div class="input_set"><p class="namae"><?php echo $_SESSION['login_id'];?></p></div>
                </div>

                <div class="input_wrap">
                    <h3>パスワード</h3>
                    <div class="input_set"><p class="namae"><?php echo str_repeat('●' , strlen($_SESSION['password']));?></p></div>
                </div>

                <div class="input_wrap">
                    <h3>メールアドレス</h3>
                    <div class="input_set"><p class="namae"><?php echo $_SESSION['mail'];?></p></div>
                </div>

                <p class="check_msg">上記の内容で登録します。</p>
                
        
                <div class="btn_wrap">
                    <button type="submit" name="state" value="entry">登録　▶︎</button>
                    <button type="submit" name="state" value="back" class="back">◀︎　戻る</button>
                </div>
            </form>
        </div><!-- form_wrap -->
    </main>

    <footer id="footer">
        <p>©︎2021 PH24 Erina no hyo-ka Kadai</p>
    </footer>

</div><!-- wrapper -->
</body>
</html>