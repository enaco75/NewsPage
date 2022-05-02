<!-- 仮会員登録ページのビュー -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>会員仮登録 TOP</title>
</head>
<body>
<div id="wrapper">

    <header>
        <h1>enaco</h1>
    </header>
        
    <main class="main_list">
        <div class="form_wrap">
            <form action="./entry.php" method="POST">
                <div class="_intro">
                    <h2>会員仮登録</h2>
                    <p>以下の項目を入力してください。</p>
                </div>
                <label class="input_wrap">
                    <h3 class="title">氏名</h3>
                    <div class="input_set">
                        <input type="text" name="name" value="<?php echo isset($_POST['name'])?$_POST['name']:'';?>">
                        <p class="err"><?php echo isset($err['name'])?$err['name']:'';?></p>
                    </div>
                </label>
    
                <label class="input_wrap">
                    <h3 class="title">ログインID</h3>
                    <div class="input_set">
                        <input type="text" name="login_id" value="<?php echo isset($_POST['login_id'])?$_POST['login_id']:'';?>">
                        <p class="err"><?php echo isset($err['login_id'])?$err['login_id']:'';?></p>
                    </div>
                </label>
    
                <label class="input_wrap">
                    <h3 class="title">パスワード</h3>
                    <div class="input_set">
                        <input type="password" name="password" value="">
                        <p class="err"><?php echo isset($err['password'])?$err['password']:'';?></p>
                    </div>
                </label>
    
                <label class="input_wrap">
                    <h3 class="title">メールアドレス</h3>
                    <div class="input_set">
                        <input type="text" name="mail" value="<?php echo isset($_POST['mail'])?$_POST['mail']:'';?>">
                        <p class="err"><?php echo isset($err['mail'])?$err['mail']:'';?></p>
                    </div>
                </label>
    
                <div class="btn_wrap"><button type="submit" name="state" value="confirm">確認</button></div>

                <div class="already">
                    <p>すでにアカウントをお持ちですか？</p>
                    <p><a href="./login.php">ログイン　▶︎</a></p>
                </div><!-- already -->
            </form>
        </div>
    </main>

    <footer id="footer">
        <p>©︎2021 PH24 Erina no hyo-ka Kadai</p>
    </footer>
</div><!-- wrapper -->
</body>
</html>