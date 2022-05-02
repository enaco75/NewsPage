<!-- ログインページのビュー -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>ログイン</title>
</head>
<body>
<div id="wrapper">

    <header>
        <h1>enaco</h1>
    </header>
        
    <main class="main_list">
        <div class="form_wrap">
            <form action="./login.php" method="POST">
                <div class="_intro">
                    <h2>ログイン</h2>
                    <p>ログインIDとパスワードを入力してください。</p>
                    <p class="err_msg"><?php echo isset($err['msg'])?$err['msg']:'';?></p>
                </div>
    
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
    
                <div class="btn_wrap"><button type="submit" name="state" value="login">ログイン</button></div>

                <h4>アカウントをお持ちでない方</h4>
                <p class="link"><a href="./entry.php">会員登録はこちら</a></p>
            </form>
        </div>
    </main>

    <footer id="footer">
        <p>©︎2021 PH24 Erina no hyo-ka Kadai</p>
    </footer>
</div><!-- wrapper -->
</body>
</html>